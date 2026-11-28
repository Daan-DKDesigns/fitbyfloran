<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Elke intake-aanvraag wordt ook in het admin bewaard (menu-item "Intake-aanvragen"),
 * zodat er nooit een aanvraag verloren gaat als het versturen van de e-mail mislukt.
 * Alleen zichtbaar voor beheerders; niet openbaar en niet in zoekmachines.
 *
 * Daarnaast: lukt het versturen van een e-mail niet, dan krijgt de beheerder een melding
 * in het admin met de foutmelding van de server.
 */

add_action( 'init', function () {
	register_post_type( 'fbf_aanvraag', array(
		'labels'              => array(
			'name'               => 'Intake-aanvragen',
			'singular_name'      => 'Intake-aanvraag',
			'menu_name'          => 'Intake-aanvragen',
			'all_items'          => 'Alle aanvragen',
			'edit_item'          => 'Aanvraag bekijken',
			'search_items'       => 'Aanvragen zoeken',
			'not_found'          => 'Nog geen aanvragen',
			'not_found_in_trash' => 'Geen aanvragen in de prullenbak',
		),
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_rest'        => false,
		'exclude_from_search' => true,
		'has_archive'         => false,
		'rewrite'             => false,
		'menu_icon'           => 'dashicons-email-alt',
		'menu_position'       => 20,
		'supports'            => array( 'title' ),
		'capability_type'     => 'post',
		'capabilities'        => array( 'create_posts' => 'do_not_allow' ), // Alleen via het formulier.
		'map_meta_cap'        => true,
	) );
} );

/** Een aanvraag bewaren. Geeft het ID terug (0 bij een fout). */
function fbf_aanvraag_bewaren( $d ) {
	$id = wp_insert_post( array(
		'post_type'   => 'fbf_aanvraag',
		'post_status' => 'private',
		'post_title'  => $d['naam'] . ( $d['hulpvraag'] !== '' ? ' — ' . $d['hulpvraag'] : '' ),
		'meta_input'  => array(
			'fbf_email'     => $d['email'],
			'fbf_telefoon'  => $d['telefoon'],
			'fbf_hulpvraag' => $d['hulpvraag'],
			'fbf_bericht'   => $d['bericht'],
			'fbf_mail_ok'   => '',
		),
	), true );
	return is_wp_error( $id ) ? 0 : (int) $id;
}

/** Overzicht: e-mail, telefoon, hulpvraag en of de mail aan Floran is aangekomen. */
add_filter( 'manage_fbf_aanvraag_posts_columns', function ( $columns ) {
	return array(
		'cb'        => $columns['cb'],
		'title'     => 'Naam',
		'fbf_email' => 'E-mail',
		'fbf_tel'   => 'Telefoon',
		'fbf_mail'  => 'Mail verstuurd',
		'date'      => 'Ontvangen',
	);
} );

add_action( 'manage_fbf_aanvraag_posts_custom_column', function ( $column, $post_id ) {
	if ( 'fbf_email' === $column ) {
		$email = get_post_meta( $post_id, 'fbf_email', true );
		printf( '<a href="mailto:%1$s">%2$s</a>', esc_attr( $email ), esc_html( $email ) );
	} elseif ( 'fbf_tel' === $column ) {
		echo esc_html( get_post_meta( $post_id, 'fbf_telefoon', true ) ?: '–' );
	} elseif ( 'fbf_mail' === $column ) {
		echo '1' === get_post_meta( $post_id, 'fbf_mail_ok', true ) ? '<span style="color:#1a7f37">&#10003; ja</span>' : '<span style="color:#b32d2e">&#10007; nee</span>';
	}
}, 10, 2 );

/** De aanvraag zelf netjes tonen (alleen lezen). */
add_action( 'add_meta_boxes_fbf_aanvraag', function ( $post ) {
	add_meta_box( 'fbf_aanvraag_gegevens', 'Gegevens van de aanvraag', function ( $post ) {
		$email = get_post_meta( $post->ID, 'fbf_email', true );
		$tel   = get_post_meta( $post->ID, 'fbf_telefoon', true );
		$rijen = array(
			'E-mail'      => $email ? '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>' : '–',
			'Telefoon'    => $tel ? '<a href="' . esc_url( fbf_tel_href( $tel ) ) . '">' . esc_html( $tel ) . '</a>' : '–',
			'Hulpvraag'   => esc_html( get_post_meta( $post->ID, 'fbf_hulpvraag', true ) ?: '–' ),
			'Toelichting' => nl2br( esc_html( get_post_meta( $post->ID, 'fbf_bericht', true ) ?: '–' ) ),
			'Ontvangen'   => esc_html( get_the_date( 'j F Y \o\m H:i', $post ) ),
			'Mail aan jou' => '1' === get_post_meta( $post->ID, 'fbf_mail_ok', true ) ? 'Verstuurd' : 'Niet gelukt (zie melding bovenaan het admin)',
		);
		echo '<table class="form-table" role="presentation">';
		foreach ( $rijen as $label => $waarde ) {
			echo '<tr><th scope="row">' . esc_html( $label ) . '</th><td>' . $waarde . '</td></tr>'; // phpcs:ignore WordPress.Security.EscapeOutput
		}
		echo '</table>';
	}, 'fbf_aanvraag', 'normal', 'high' );
} );

/* ---------- Mislukte e-mails zichtbaar maken ---------- */

/** De laatste foutmelding bij het versturen van een e-mail onthouden. */
add_action( 'wp_mail_failed', function ( $error ) {
	update_option( 'fbf_mail_fout', array(
		'tijd'    => time(),
		'melding' => wp_strip_all_tags( $error->get_error_message() ),
	), false );
} );

/** Melding in het admin zolang de laatste e-mail mislukte (verdwijnt na een geslaagde mail). */
add_action( 'admin_notices', function () {
	$fout = get_option( 'fbf_mail_fout' );
	if ( ! $fout || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	printf(
		'<div class="notice notice-error"><p><strong>Let op: een e-mail van het intakeformulier kon niet worden verstuurd</strong> (%1$s).<br>Melding van de server: <code>%2$s</code><br>De aanvraag zelf staat veilig onder <a href="%3$s">Intake-aanvragen</a>.</p></div>',
		esc_html( wp_date( 'j F Y H:i', (int) $fout['tijd'] ) ),
		esc_html( $fout['melding'] ),
		esc_url( admin_url( 'edit.php?post_type=fbf_aanvraag' ) )
	);
} );
