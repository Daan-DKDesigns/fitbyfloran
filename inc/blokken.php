<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Losse blokken op de voorpagina die Floran zelf beheert, elk met een eigen menu-item
 * in het WP-admin (net als Prijsopgaves): Aanpak, Specialisaties en Samenwerkingen.
 *
 * Elke kaart is een los item: toevoegen, aanpassen, volgorde bepalen (veld "Volgorde")
 * of tijdelijk verbergen (op "Concept" zetten). Werkt met de gratis versie van ACF;
 * de eerdere herhaalvelden ("repeater") werken alleen met ACF Pro en waren daardoor
 * in het admin onzichtbaar.
 */

/** Instellingen per bloktype: menu, labels, velden en de startinhoud uit de demo. */
function fbf_blok_types() {
	return array(
		'fbf_stap'          => array(
			'menu'        => 'Aanpak',
			'enkelvoud'   => 'stap',
			'meervoud'    => 'stappen',
			'icoon'       => 'dashicons-chart-line',
			'positie'     => 22,
			'titel_hint'  => 'Titel van de stap, bijv. Inzicht',
			'titel_kolom' => 'Stap',
			'uitleg'      => 'De kaarten in "Mijn aanpak" op de voorpagina. Het nummer (01, 02, …) komt automatisch uit de volgorde.',
			'velden'      => array(
				array( 'name' => 'label', 'label' => 'Kopje boven de titel', 'type' => 'text', 'instructions' => 'Eén woord in hoofdletters, bijv. ANALYSE. Het nummer ervoor (01 ·) zet de site er zelf bij.' ),
				array( 'name' => 'tekst', 'label' => 'Tekst', 'type' => 'textarea', 'rows' => 3, 'required' => 1 ),
			),
			'kolommen'    => array( 'label' => 'Kopje' ),
			'start'       => array(
				array( 'titel' => 'Inzicht', 'label' => 'ANALYSE', 'tekst' => 'Uitgebreide intake en performance screening van mobiliteit, kracht, belastbaarheid, blessuregeschiedenis en sportdoelen.' ),
				array( 'titel' => 'Belastbaarheid', 'label' => 'HERSTEL', 'tekst' => 'Gericht herstel met aandacht voor pijn, functie, kracht en het opnieuw opbouwen van vertrouwen in je lichaam.' ),
				array( 'titel' => 'Behouden', 'label' => 'PREVENTIE', 'tekst' => 'Gerichte training, monitoring en slim belastingmanagement om terugkerende klachten te helpen voorkomen.' ),
				array( 'titel' => 'Presteren', 'label' => 'PERFORMANCE', 'tekst' => 'Van klachtenvrij naar sterker, sneller en beter voorbereid op de eisen van jouw sport.' ),
			),
		),
		'fbf_specialisatie' => array(
			'menu'        => 'Specialisaties',
			'enkelvoud'   => 'specialisatie',
			'meervoud'    => 'specialisaties',
			'icoon'       => 'dashicons-awards',
			'positie'     => 23,
			'titel_hint'  => 'Naam van de specialisatie, bijv. Second Opinion',
			'titel_kolom' => 'Specialisatie',
			'uitleg'      => 'De kaarten in "Specialistische begeleiding" op de voorpagina.',
			'velden'      => array(
				array( 'name' => 'tekst', 'label' => 'Tekst', 'type' => 'textarea', 'rows' => 3, 'required' => 1 ),
				array( 'name' => 'knop_tekst', 'label' => 'Knoptekst', 'type' => 'text', 'instructions' => 'Leeg laten = geen knop.', 'default_value' => 'Plan je intake' ),
				array( 'name' => 'knop_link', 'label' => 'Knoplink', 'type' => 'text', 'instructions' => '#contact gaat naar het intakeformulier onderaan de pagina.', 'default_value' => '#contact' ),
			),
			'kolommen'    => array( 'knop_tekst' => 'Knop' ),
			'start'       => array(
				array( 'titel' => 'Second Opinion', 'tekst' => 'Twijfel je over een diagnose of behandelplan? We bekijken jouw situatie objectief en vertalen dit naar een helder advies.', 'knop_tekst' => 'Plan second opinion', 'knop_link' => '#contact' ),
				array( 'titel' => 'Performance Screening', 'tekst' => 'Krijg inzicht in je huidige fysieke capaciteit, aandachtspunten en de volgende stap richting jouw prestatiedoel.', 'knop_tekst' => 'Plan screening', 'knop_link' => '#contact' ),
				array( 'titel' => 'Return-to-Sport & Running', 'tekst' => 'Van sportspecifieke screening en running analysis tot videoanalyse en return-to-performance testing.', 'knop_tekst' => 'Plan analyse', 'knop_link' => '#contact' ),
			),
		),
		'fbf_partner'       => array(
			'menu'        => 'Samenwerkingen',
			'enkelvoud'   => 'samenwerking',
			'meervoud'    => 'samenwerkingen',
			'icoon'       => 'dashicons-groups',
			'positie'     => 24,
			'titel_hint'  => 'Naam van de organisatie',
			'titel_kolom' => 'Organisatie',
			'uitleg'      => 'De logo\'s bij "Samenwerkingen" op de voorpagina. Zonder logo toont de site de initialen.',
			'velden'      => array(
				array( 'name' => 'logo', 'label' => 'Logo', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'instructions' => 'Bij voorkeur een PNG of SVG met transparante achtergrond. Het logo wordt automatisch passend gemaakt.' ),
				array( 'name' => 'url', 'label' => 'Website', 'type' => 'url', 'instructions' => 'Bezoekers gaan hierheen als ze op het logo klikken.' ),
				array( 'name' => 'initialen', 'label' => 'Initialen (als er geen logo is)', 'type' => 'text', 'instructions' => 'Bijv. KM. Alleen zichtbaar zolang er geen logo is geüpload.' ),
			),
			'kolommen'    => array( 'logo' => 'Logo', 'url' => 'Website' ),
			'start'       => array(
				array( 'titel' => "KNAP'MAN", 'initialen' => 'K', 'url' => 'https://www.knapman.nl/' ),
				array( 'titel' => 'EVOLVE PHYSIO', 'initialen' => 'EP', 'url' => 'https://www.evolvephysio.uk/' ),
				array( 'titel' => 'STATSPORTS', 'initialen' => 'SS', 'url' => 'https://statsports.com/' ),
				array( 'titel' => 'FRANS BOSCH SYSTEMS', 'initialen' => 'FBS', 'url' => 'https://www.fransbosch.systems/' ),
				array( 'titel' => 'MB SPORTPSYCHOLOGIE', 'initialen' => 'MB', 'url' => 'https://mbsportpsychologie.nl/' ),
			),
		),
	);
}

/** Veldsleutel zoals ACF die gebruikt, bijv. field_fbf_stap_label. */
function fbf_blok_veldsleutel( $type, $veld ) {
	return 'field_' . $type . '_' . $veld;
}

/* ---------- Menu-items (post types) ---------- */

add_action( 'init', function () {
	foreach ( fbf_blok_types() as $type => $cfg ) {
		$enk = $cfg['enkelvoud'];
		$mv  = $cfg['meervoud'];
		register_post_type( $type, array(
			'labels'              => array(
				'name'               => $cfg['menu'],
				'singular_name'      => ucfirst( $enk ),
				'menu_name'          => $cfg['menu'],
				'add_new'            => 'Nieuwe ' . $enk,
				'add_new_item'       => 'Nieuwe ' . $enk . ' toevoegen',
				'edit_item'          => ucfirst( $enk ) . ' bewerken',
				'new_item'           => 'Nieuwe ' . $enk,
				'all_items'          => 'Alle ' . $mv,
				'search_items'       => ucfirst( $mv ) . ' zoeken',
				'not_found'          => 'Geen ' . $mv . ' gevonden',
				'not_found_in_trash' => 'Geen ' . $mv . ' in de prullenbak',
			),
			'description'         => $cfg['uitleg'],
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_rest'        => false,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'rewrite'             => false,
			'menu_icon'           => $cfg['icoon'],
			'menu_position'       => $cfg['positie'],
			'supports'            => array( 'title', 'page-attributes' ),
			'capability_type'     => 'page',
		) );
	}
} );

/** Duidelijke tekst in het titelveld. */
add_filter( 'enter_title_here', function ( $title, $post ) {
	$types = fbf_blok_types();
	return isset( $types[ $post->post_type ] ) ? $types[ $post->post_type ]['titel_hint'] : $title;
}, 10, 2 );

/** Korte uitleg boven het overzicht, zodat Floran weet waar het op de site staat. */
add_action( 'admin_notices', function () {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	$types  = fbf_blok_types();
	if ( ! $screen || 'edit' !== $screen->base || ! isset( $types[ $screen->post_type ] ) ) {
		return;
	}
	printf(
		'<div class="notice notice-info"><p>%s Volgorde aanpassen: open een item en wijzig rechts het veld <strong>Volgorde</strong> (laagste nummer eerst). Tijdelijk verbergen: zet het item op <strong>Concept</strong>.</p></div>',
		esc_html( $types[ $screen->post_type ]['uitleg'] )
	);
} );

/* ---------- Overzicht in het admin ---------- */

foreach ( array_keys( fbf_blok_types() ) as $fbf_blok_type ) {
	add_filter( 'manage_' . $fbf_blok_type . '_posts_columns', function ( $columns ) use ( $fbf_blok_type ) {
		$cfg = fbf_blok_types()[ $fbf_blok_type ];
		$new = array(
			'cb'    => $columns['cb'],
			'title' => $cfg['titel_kolom'],
		);
		foreach ( $cfg['kolommen'] as $veld => $label ) {
			$new[ 'fbf_' . $veld ] = $label;
		}
		$new['fbf_volgorde'] = 'Volgorde';
		return $new;
	} );

	add_action( 'manage_' . $fbf_blok_type . '_posts_custom_column', function ( $column, $post_id ) {
		if ( 'fbf_volgorde' === $column ) {
			echo esc_html( (string) get_post_field( 'menu_order', $post_id ) );
			return;
		}
		if ( 0 !== strpos( $column, 'fbf_' ) ) {
			return;
		}
		$veld  = substr( $column, 4 );
		$value = get_post_meta( $post_id, $veld, true );
		if ( 'logo' === $veld ) {
			echo $value ? wp_get_attachment_image( (int) $value, array( 80, 40 ), false, array( 'style' => 'max-height:40px;width:auto;background:#111;padding:4px' ) ) : '&ndash;';
		} else {
			echo $value ? esc_html( (string) $value ) : '&ndash;';
		}
	}, 10, 2 );
}

/** Admin-overzicht standaard op volgorde. */
add_action( 'pre_get_posts', function ( $query ) {
	if ( is_admin() && $query->is_main_query() && array_key_exists( (string) $query->get( 'post_type' ), fbf_blok_types() ) && ! $query->get( 'orderby' ) ) {
		$query->set( 'orderby', array( 'menu_order' => 'ASC', 'title' => 'ASC' ) );
	}
} );

/** Nieuwe items komen achteraan: volgorde = hoogste + 1. */
add_filter( 'wp_insert_post_data', function ( $data, $postarr ) {
	if ( array_key_exists( $data['post_type'], fbf_blok_types() ) && empty( $postarr['ID'] ) && empty( $data['menu_order'] ) ) {
		$laatste            = get_posts( array( 'post_type' => $data['post_type'], 'post_status' => 'any', 'numberposts' => 1, 'orderby' => 'menu_order', 'order' => 'DESC', 'fields' => 'ids' ) );
		$data['menu_order'] = $laatste ? (int) get_post_field( 'menu_order', $laatste[0] ) + 1 : 1;
	}
	return $data;
}, 10, 2 );

/* ---------- Velden (ACF, gratis versie) ---------- */

add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	foreach ( fbf_blok_types() as $type => $cfg ) {
		$fields = array();
		foreach ( $cfg['velden'] as $veld ) {
			$veld['key'] = fbf_blok_veldsleutel( $type, $veld['name'] );
			$fields[]    = $veld;
		}
		acf_add_local_field_group( array(
			'key'                   => 'group_' . $type,
			'title'                 => ucfirst( $cfg['enkelvoud'] ),
			'fields'                => $fields,
			'location'              => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => $type ) ) ),
			'position'              => 'acf_after_title',
			'style'                 => 'seamless',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		) );
	}
}, 20 );

/* ---------- Startinhoud ---------- */

/**
 * Eenmalig per bloktype: zet de teksten die nu op de site staan klaar als losse items,
 * zodat Floran direct kan aanpassen. Alleen als er van dat type nog niets bestaat.
 */
add_action( 'admin_init', function () {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	foreach ( fbf_blok_types() as $type => $cfg ) {
		$vlag = $type . '_seeded';
		if ( get_option( $vlag ) ) {
			continue;
		}
		update_option( $vlag, 1, false );
		if ( get_posts( array( 'post_type' => $type, 'post_status' => 'any', 'numberposts' => 1, 'fields' => 'ids' ) ) ) {
			continue;
		}
		foreach ( $cfg['start'] as $i => $item ) {
			$meta = array();
			foreach ( $cfg['velden'] as $veld ) {
				if ( isset( $item[ $veld['name'] ] ) ) {
					$meta[ $veld['name'] ]       = $item[ $veld['name'] ];
					$meta[ '_' . $veld['name'] ] = fbf_blok_veldsleutel( $type, $veld['name'] );
				}
			}
			wp_insert_post( array(
				'post_type'   => $type,
				'post_status' => 'publish',
				'post_title'  => $item['titel'],
				'menu_order'  => $i + 1,
				'meta_input'  => $meta,
			) );
		}
	}
} );

/* ---------- Uitlezen voor de voorpagina ---------- */

/**
 * Alle gepubliceerde items van een bloktype als arrays met 'titel' en de veldwaarden.
 * Leest gewone post-meta, dus werkt ook als ACF (tijdelijk) uit staat.
 * Nog geen enkel item (bijv. vóór het eerste admin-bezoek)? Dan de startinhoud.
 */
function fbf_blokken( $type ) {
	$cfg   = fbf_blok_types()[ $type ];
	$posts = get_posts( array(
		'post_type'      => $type,
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
	) );

	if ( ! $posts ) {
		$bestaat = get_posts( array( 'post_type' => $type, 'post_status' => 'any', 'numberposts' => 1, 'fields' => 'ids' ) );
		// Alles bewust verborgen (op concept gezet)? Dan ook niets tonen.
		return $bestaat ? array() : $cfg['start'];
	}

	$items = array();
	foreach ( $posts as $post ) {
		$item = array( 'titel' => $post->post_title );
		foreach ( $cfg['velden'] as $veld ) {
			$item[ $veld['name'] ] = get_post_meta( $post->ID, $veld['name'], true );
		}
		$items[] = $item;
	}
	return $items;
}

/** Logo (bijlage-ID) als array met url, breedte, hoogte en alt, of false. */
function fbf_blok_afbeelding( $id, $alt = '' ) {
	$id  = (int) $id;
	$src = $id ? wp_get_attachment_image_src( $id, 'medium' ) : false;
	if ( ! $src ) {
		return false;
	}
	$eigen_alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
	return array(
		'url'    => $src[0],
		'width'  => (int) $src[1],
		'height' => (int) $src[2],
		'alt'    => $eigen_alt ? $eigen_alt : $alt,
	);
}
