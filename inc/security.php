<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Beveiliging en spam, voor zover het thema dat kan regelen.
 * HTTPS, HSTS, de minimale TLS-versie en het afremmen van inlogpogingen gaan via Cloudflare.
 */

/** Geen code bewerken in het beheer: het thema komt uit GitHub en een wijziging daar wordt toch overschreven. */
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', true );
}

/** Veilige standaardinstellingen voor de browser. */
add_action( 'send_headers', function () {
	header_remove( 'X-Powered-By' ); // Niet verklappen welke PHP-versie draait.
	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	header( 'Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=(), usb=()' );
} );

/** Bij een mislukte inlog niet verklappen of de gebruikersnaam bestaat. */
add_filter( 'login_errors', function ( $error ) {
	global $errors;
	$codes = is_wp_error( $errors ) ? $errors->get_error_codes() : array();
	if ( array_intersect( $codes, array( 'invalid_username', 'invalid_email', 'incorrect_password' ) ) ) {
		return '<strong>Inloggen mislukt.</strong> De gebruikersnaam of het wachtwoord klopt niet.';
	}
	return $error;
} );

/** Applicatiewachtwoorden (inloggen voor externe apps) gebruikt de site niet: weer een deur minder. */
add_filter( 'wp_is_application_passwords_available', '__return_false' );

/** XML-RPC en pingbacks zijn niet nodig en worden vooral misbruikt. */
add_filter( 'xmlrpc_enabled', '__return_false' );
add_action( 'after_setup_theme', function () {
	// WordPress biedt via xmlrpc.php altijd nog system.listMethods e.d. aan: het hele bestand dicht.
	if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
		status_header( 403 );
		exit;
	}
} );
add_filter( 'wp_headers', function ( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
} );

/** Ingesloten berichten (oEmbed) tonen geen gebruikersnaam. */
add_filter( 'oembed_response_data', function ( $data ) {
	unset( $data['author_name'], $data['author_url'] );
	return $data;
} );

/* ---------- Reacties helemaal uit: de site gebruikt ze niet, spammers wel ---------- */

add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );
add_filter( 'comments_array', '__return_empty_array', 20 );
add_filter( 'feed_links_show_comments_feed', '__return_false' );

add_action( 'init', function () {
	foreach ( get_post_types() as $type ) {
		if ( post_type_supports( $type, 'comments' ) ) {
			remove_post_type_support( $type, 'comments' );
			remove_post_type_support( $type, 'trackbacks' );
		}
	}
}, 100 );

add_action( 'admin_menu', function () {
	remove_menu_page( 'edit-comments.php' );
	remove_submenu_page( 'options-general.php', 'options-discussion.php' );
} );

add_action( 'admin_init', function () {
	global $pagenow;
	if ( in_array( $pagenow, array( 'edit-comments.php', 'options-discussion.php' ), true ) ) {
		wp_safe_redirect( admin_url() );
		exit;
	}
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
} );

add_action( 'admin_bar_menu', function ( $bar ) {
	$bar->remove_node( 'comments' );
}, 100 );

/** Reacties via de REST-API dicht. */
add_filter( 'rest_endpoints', function ( $endpoints ) {
	foreach ( array_keys( $endpoints ) as $route ) {
		if ( 0 === strpos( $route, '/wp/v2/comments' ) ) {
			unset( $endpoints[ $route ] );
		}
	}
	return $endpoints;
} );

/** Voor het geval een robot rechtstreeks naar wp-comments-post.php gaat. */
add_action( 'pre_comment_on_post', function () {
	wp_die( 'Reageren is op deze site niet mogelijk.', '', array( 'response' => 403 ) );
} );

/* ---------- Spam bij het contactformulier, zonder puzzel voor de bezoeker ---------- */

/**
 * Ondertekende tijd voor in het formulier. Samen met het verborgen veld en de linklimiet:
 * - wie binnen 3 seconden na het laden verstuurt, is een robot;
 * - een bericht met meer dan 3 links is bijna altijd reclame.
 */
function fbf_spam_token_field() {
	$t = time();
	return '<input type="hidden" name="fbf_t" value="' . esc_attr( $t . '.' . wp_hash( 'fbf_form|' . $t ) ) . '">';
}

/** Is dit verstuurde contactformulier spam? */
function fbf_is_spam() {
	// phpcs:disable WordPress.Security.NonceVerification
	if ( ! empty( $_POST['fbf_website'] ) ) {
		return true;
	}
	$token = isset( $_POST['fbf_t'] ) ? sanitize_text_field( wp_unslash( $_POST['fbf_t'] ) ) : '';
	$parts = explode( '.', $token, 2 );
	if ( 2 !== count( $parts ) || ! hash_equals( wp_hash( 'fbf_form|' . $parts[0] ), $parts[1] ) ) {
		return true; // Geen of een vervalste tijd: niet via de site verstuurd.
	}
	if ( time() - (int) $parts[0] < 3 ) {
		return true;
	}
	$bericht = isset( $_POST['fbf_bericht'] ) ? wp_unslash( $_POST['fbf_bericht'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	// phpcs:enable
	return preg_match_all( '#https?://|www\.#i', (string) $bericht ) > 3;
}
