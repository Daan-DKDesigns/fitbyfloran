<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'FBF_VERSION', '1.0.0' );

/** Theme setup */
function fbf_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 86, 'width' => 300, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	register_nav_menus( array( 'primary' => __( 'Hoofdmenu', 'fitbyfloran' ) ) );
}
add_action( 'after_setup_theme', 'fbf_setup' );

/** Enqueue styles/scripts */
function fbf_assets() {
	wp_enqueue_style( 'fbf-style', get_stylesheet_uri(), array(), FBF_VERSION );
	wp_enqueue_script( 'fbf-main', get_template_directory_uri() . '/assets/js/main.js', array(), FBF_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'fbf_assets' );

/**
 * Kleine helper: haalt een ACF-veld op met fallback-tekst, zodat de site
 * er ook goed uitziet voordat iemand de velden heeft ingevuld.
 */
function fbf_field( $selector, $default = '', $post_id = false ) {
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $selector, $post_id );
		if ( $value !== null && $value !== '' ) {
			return $value;
		}
	}
	return $default;
}

/**
 * ACF Options-pagina's registreren:
 * - "Site-instellingen": WhatsApp/contact
 * - "Prijsopgaves": eigen menukopje links in het WP-admin, los van de paginacontent,
 *   met de volledige lijst trajecten/memberships die op de website getoond worden.
 * - "Paketten": aanvullende beheeropties voor de homepage-sectie
 */
function fbf_acf_options_pages() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}
	acf_add_options_page( array(
		'page_title' => 'Site-instellingen',
		'menu_title' => 'Fit by Floran',
		'menu_slug'  => 'fbf-options',
		'capability' => 'edit_theme_options',
	) );
	acf_add_options_page( array(
		'page_title' => 'Prijsopgaves',
		'menu_title' => 'Prijsopgaves',
		'menu_slug'  => 'fbf-prijsopgaves',
		'capability' => 'edit_theme_options',
		'icon_url'   => 'dashicons-money-alt',
		'position'   => 21,
	) );
	acf_add_options_page( array(
		'page_title' => 'Paketten',
		'menu_title' => 'Paketten',
		'menu_slug'  => 'fbf-paketten',
		'capability' => 'edit_theme_options',
		'icon_url'   => 'dashicons-grid-view',
		'position'   => 22,
	) );
}
add_action( 'acf/init', 'fbf_acf_options_pages', 5 );

/**
 * ACF-veldgroepen automatisch registreren via code ("Local JSON"-methode).
 * Bewust niet via de handmatige import-knop: die is in recentere ACF-versies
 * (6.1+) kwetsbaar voor een fatale fout bij handmatig samengestelde JSON-bestanden.
 * Deze route leest hetzelfde JSON-bestand in en werkt stabiel op elke ACF-versie.
 * De velden verschijnen automatisch zodra ACF actief is, zonder handmatige import.
 */
function fbf_register_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	$json_path = get_template_directory() . '/acf-fields-fitbyfloran.json';
	if ( ! file_exists( $json_path ) ) {
		return;
	}
	$groups = json_decode( file_get_contents( $json_path ), true );
	if ( ! is_array( $groups ) ) {
		return;
	}
	foreach ( $groups as $group ) {
		acf_add_local_field_group( $group );
	}
}
add_action( 'acf/init', 'fbf_register_acf_fields', 20 );

/**
 * Melding in het admin zolang ACF niet actief is: de site werkt ook zonder,
 * met de ingebouwde voorbeeldteksten, maar zonder ACF kan Floran niets aanpassen.
 */
function fbf_admin_notice_acf() {
	if ( ! current_user_can( 'activate_plugins' ) || function_exists( 'get_field' ) ) {
		return;
	}
	$install_url = admin_url( 'plugin-install.php?s=Advanced+Custom+Fields&tab=search&type=term' );
	?>
	<div class="notice notice-warning is-dismissible">
		<p><strong>Fit by Floran-thema:</strong> Aanbevolen plugin <strong>Advanced Custom Fields (ACF)</strong> is nog niet actief. Nodig om de hero, de teksten en de prijsopgaves te beheren via het W[...]
		<a href="<?php echo esc_url( $install_url ); ?>">Plugin installeren / activeren</a></p>
	</div>
	<?php
}
add_action( 'admin_notices', 'fbf_admin_notice_acf' );

/** Fallback hoofdmenu (desktop), zolang er nog geen WP-menu is aangemaakt. */
function fbf_default_menu() {
	echo '<ul>
		<li><a href="#over">Over Floran</a></li>
		<li><a href="#aanpak">Aanpak</a></li>
		<li><a href="#diensten">Diensten</a></li>
		<li><a href="#specialisaties">Specialisaties</a></li>
		<li><a href="#partners">Samenwerkingen</a></li>
		<li><a href="#contact">Contact</a></li>
		<li><a href="#contact" class="nav-cta">Plan je intake</a></li>
	</ul>';
}

/** Fallback hoofdmenu (mobiel). */
function fbf_default_menu_mobile() {
	echo '<ul>
		<li><a href="#over">Over Floran</a></li>
		<li><a href="#aanpak">Aanpak</a></li>
		<li><a href="#diensten">Diensten</a></li>
		<li><a href="#specialisaties">Specialisaties</a></li>
		<li><a href="#partners">Samenwerkingen</a></li>
		<li><a href="#contact">Contact</a></li>
		<li><a href="#contact">Plan je intake</a></li>
	</ul>';
}
function fitbyfloran_maintenance_mode() {

    // Admins kunnen de normale website bekijken
    if ( current_user_can('manage_options') ) {
        return;
    }

    // Geen maintenance tonen in de WordPress admin
    if ( is_admin() ) {
        return;
    }

    // Maintenance pagina laden
    include get_template_directory() . '/maintenance.php';

    exit;
}

add_action('template_redirect', 'fitbyfloran_maintenance_mode');

/**
 * Fit by Floran - Custom WordPress Login
 */

function fitbyfloran_get_login_logo() {

    $logo_dir = get_stylesheet_directory() . '/assets/images/';
    $logo_url = get_stylesheet_directory_uri() . '/assets/images/';

    /*
     * Voorkeur:
     * 1. SVG
     * 2. PNG
     * 3. JPG
     */

    $possible_logos = array(
        'logo.svg',
        'Logo.svg',
        'logo.png',
        'Logo.png',
        'logo.jpg',
        'Logo.jpg',
    );

    foreach ( $possible_logos as $logo ) {

        if ( file_exists( $logo_dir . $logo ) ) {
            return $logo_url . $logo;
        }
    }

    return '';
}


function fitbyfloran_custom_login_styles() {

    $logo_url = fitbyfloran_get_login_logo();
    ?>

    <style>

        /* ==================================================
           BASIS
        ================================================== */

        html,
        body.login {
            background: #FCF9EA !important;
        }

        body.login {
            min-height: 100vh;
        }


        /* ==================================================
           LOGIN CONTAINER
        ================================================== */

        #login {
            width: 100% !important;
            max-width: 400px !important;

            padding: 45px 20px 25px !important;

            margin: 0 auto !important;
        }


        /* ==================================================
           LOGO
        ================================================== */

        .login h1 {
            margin: 0 0 30px !important;
            padding: 0 !important;
        }

        .login h1 a {

            <?php if ( $logo_url ) : ?>
            background-image: url('<?php echo esc_url( $logo_url ); ?>') !important;
            <?php endif; ?>

            background-size: contain !important;
            background-repeat: no-repeat !important;
            background-position: center !important;

            width: 100% !important;
            height: 130px !important;

            margin: 0 auto !important;
            padding: 0 !important;

            display: block !important;

            text-indent: -9999px !important;
            overflow: hidden !important;

            box-shadow: none !important;
        }


        /* ==================================================
           LOGIN FORMULIER
        ================================================== */

        .login form {

            background: #111111 !important;

            border: none !important;
            border-radius: 8px !important;

            padding: 30px !important;

            margin-top: 0 !important;

            box-shadow:
                0 12px 35px rgba(0, 0, 0, 0.15) !important;
        }


        /* ==================================================
           LABELS
        ================================================== */

        .login form label {

            color: #ffffff !important;

            font-size: 13px !important;
            font-weight: 500 !important;
        }


        /* ==================================================
           INPUTS
        ================================================== */

        .login form input[type="text"],
        .login form input[type="password"] {

            background: #1c1c1c !important;

            border: 1px solid #444444 !important;

            color: #ffffff !important;

            border-radius: 4px !important;

            box-shadow: none !important;

            min-height: 42px !important;
        }


        .login form input[type="text"]:focus,
        .login form input[type="password"]:focus {

            background: #1c1c1c !important;

            border-color: #C9A15B !important;

            box-shadow:
                0 0 0 1px #C9A15B !important;

            outline: none !important;
        }


        /* ==================================================
           WACHTWOORD OOG
        ================================================== */

        .login .button.wp-hide-pw {

            color: #C9A15B !important;

            background: transparent !important;

            border: none !important;

            box-shadow: none !important;
        }


        /* ==================================================
           ONTHOUD MIJ
        ================================================== */

        .login .forgetmenot label {

            color: #cccccc !important;
        }

        .login input[type="checkbox"] {

            accent-color: #C9A15B !important;
        }


        /* ==================================================
           LOGIN KNOP
        ================================================== */

        .login .button-primary {

            background: #C9A15B !important;

            border: 1px solid #C9A15B !important;

            color: #000000 !important;

            text-shadow: none !important;

            box-shadow: none !important;

            border-radius: 4px !important;

            min-height: 40px !important;

            padding: 0 20px !important;

            transition:
                background 0.2s ease,
                border-color 0.2s ease !important;
        }


        .login .button-primary:hover,
        .login .button-primary:focus {

            background: #D8B875 !important;

            border-color: #D8B875 !important;

            color: #000000 !important;
        }


        /* ==================================================
           LINKS ONDER FORMULIER
        ================================================== */

        .login #nav,
        .login #backtoblog {

            text-align: center !important;

            padding: 0 !important;

            margin-left: 0 !important;
            margin-right: 0 !important;
        }


        .login #nav {

            margin-top: 20px !important;
        }


        .login #backtoblog {

            margin-top: 8px !important;
        }


        .login #nav a,
        .login #backtoblog a {

            color: #8C6B32 !important;

            text-decoration: none !important;

            font-size: 13px !important;
        }


        .login #nav a:hover,
        .login #backtoblog a:hover {

            color: #000000 !important;
        }


        /* ==================================================
           TAALKEUZE
        ================================================== */

        body.login .language-switcher {

            width: auto !important;

            max-width: 400px !important;

            margin: 22px auto 0 !important;

            padding: 0 !important;

            background: transparent !important;

            border: none !important;

            box-shadow: none !important;

            text-align: center !important;
        }


        body.login .language-switcher label {

            display: inline-flex !important;

            align-items: center !important;

            gap: 8px !important;

            color: #555555 !important;

            font-size: 13px !important;
        }


        body.login .language-switcher select {

            height: 36px !important;

            min-width: 130px !important;

            padding: 0 10px !important;

            background: #ffffff !important;

            border: 1px solid #D8D2BC !important;

            border-radius: 4px !important;

            color: #333333 !important;
        }


        body.login .language-switcher .button {

            height: 36px !important;

            margin-left: 5px !important;

            padding: 0 13px !important;

            background: #111111 !important;

            border: 1px solid #111111 !important;

            border-radius: 4px !important;

            color: #ffffff !important;

            box-shadow: none !important;
        }


        body.login .language-switcher .button:hover {

            background: #C9A15B !important;

            border-color: #C9A15B !important;

            color: #000000 !important;
        }


        /* ==================================================
           MELDINGEN
        ================================================== */

        .login .message,
        .login #login_error {

            background: #ffffff !important;

            border-left: 4px solid #C9A15B !important;

            color: #333333 !important;

            border-radius: 3px !important;

            box-shadow: none !important;
        }


        /* ==================================================
           MOBIEL
        ================================================== */

        @media screen and (max-width: 480px) {

            #login {

                padding: 30px 20px 20px !important;
            }

            .login h1 a {

                height: 105px !important;
            }

            .login form {

                padding: 25px !important;
            }

            body.login .language-switcher {

                margin-top: 20px !important;
            }
        }

    </style>

    <?php
}

add_action(
    'login_enqueue_scripts',
    'fitbyfloran_custom_login_styles'
);


/**
 * Logo link naar website
 */
function fitbyfloran_login_logo_url() {

    return home_url('/');
}

add_filter(
    'login_headerurl',
    'fitbyfloran_login_logo_url'
);


/**
 * Titel van het logo
 */
function fitbyfloran_login_logo_title() {

    return 'Fit by Floran';
}

add_filter(
    'login_headertext',
    'fitbyfloran_login_logo_title'
);
