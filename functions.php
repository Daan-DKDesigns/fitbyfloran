<?php
/**
 * Fit by Floran theme functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FBF_VERSION', '1.0.0' );

/**
 * Theme setup.
 */
function fbf_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo' );

	register_nav_menus( array(
		'primary' => __( 'Hoofdmenu', 'fitbyfloran' ),
	) );
}
add_action( 'after_setup_theme', 'fbf_setup' );

/**
 * Enqueue styles and scripts.
 */
function fbf_assets() {
	// Google Fonts.
	wp_enqueue_style(
		'fbf-fonts',
		'https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@600;700;800&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap',
		array(),
		null
	);

	// Main stylesheet (style.css in theme root).
	wp_enqueue_style( 'fbf-style', get_stylesheet_uri(), array(), FBF_VERSION );

	// Main script.
	wp_enqueue_script( 'fbf-main', get_template_directory_uri() . '/assets/js/main.js', array(), FBF_VERSION, true );

	// WhatsApp nummer + tekst doorgeven aan JS/PHP via een data-attribuut i.p.v. losse localize (simpel te houden).
}
add_action( 'wp_enqueue_scripts', 'fbf_assets' );

/**
 * Favicon: gebruik het SVG-icoon uit de theme assets als er geen site-icon is ingesteld.
 */
function fbf_favicon() {
	if ( ! has_site_icon() ) {
		echo '<link rel="icon" type="image/svg+xml" href="' . esc_url( get_template_directory_uri() . '/assets/images/favicon.svg' ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'fbf_favicon' );

/**
 * Helper: WhatsApp nummer ophalen (via ACF Options als beschikbaar, anders een filter/constante).
 * Pas het nummer hieronder aan, of vul het in via ACF Opties als je die plugin toevoegt.
 */
function fbf_get_whatsapp_number() {
	if ( function_exists( 'get_field' ) ) {
		$number = get_field( 'whatsapp_nummer', 'option' );
		if ( $number ) {
			return preg_replace( '/[^0-9]/', '', $number );
		}
	}
	return apply_filters( 'fbf_whatsapp_number', '31600000000' );
}

/**
 * Helper: WhatsApp voorinvultekst.
 */
function fbf_get_whatsapp_message() {
	if ( function_exists( 'get_field' ) ) {
		$msg = get_field( 'whatsapp_bericht', 'option' );
		if ( $msg ) {
			return $msg;
		}
	}
	return apply_filters( 'fbf_whatsapp_message', 'Hallo, ik wil graag een intake plannen' );
}

/**
 * Helper: kleine wrapper om get_field() veilig te gebruiken.
 * Geeft $default terug als ACF niet actief is of het veld leeg is.
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
 * ACF Options-pagina registreren (alleen als ACF Pro actief is).
 */
function fbf_acf_options_page() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page( array(
			'page_title' => 'Site-instellingen',
			'menu_title' => 'Fit by Floran',
			'menu_slug'  => 'fbf-options',
			'capability' => 'edit_theme_options',
		) );
	}
}
add_action( 'acf/init', 'fbf_acf_options_page' );

/**
 * Vereiste/aanbevolen plugins voor dit thema.
 *
 * ACF (Advanced Custom Fields) is niet strikt verplicht om de site te laten werken —
 * front-page.php heeft overal een fallback-tekst — maar is wel nodig om Floran
 * teksten, diensten, cijfers en het WhatsApp-nummer zelf te laten beheren zonder code.
 */
function fbf_required_plugins() {
	return array(
		array(
			'slug'        => 'advanced-custom-fields',
			'name'        => 'Advanced Custom Fields (ACF)',
			'required'    => false, // false = aanbevolen, site werkt ook zonder.
			'reason'      => 'Nodig om diensten, cijfers, quote en het WhatsApp-nummer te beheren via het WordPress-admin. Zonder ACF blijft de site werken met de ingebouwde voorbeeldteksten.',
		),
	);
}

/**
 * Toon een melding in het admin als een aanbevolen plugin nog niet actief is.
 */
function fbf_admin_notice_required_plugins() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	foreach ( fbf_required_plugins() as $plugin ) {
		$is_active = false;

		if ( 'advanced-custom-fields' === $plugin['slug'] ) {
			$is_active = function_exists( 'get_field' );
		}

		if ( $is_active ) {
			continue;
		}

		$install_path = 'plugin-install.php?s=' . rawurlencode( $plugin['name'] ) . '&tab=search&type=term';
		$install_url  = admin_url( $install_path );
		$label        = $plugin['required'] ? 'Vereist' : 'Aanbevolen';
		$class        = $plugin['required'] ? 'notice-error' : 'notice-warning';
		?>
		<div class="notice <?php echo esc_attr( $class ); ?> is-dismissible">
			<p>
				<strong>Fit by Floran-thema:</strong>
				<?php echo esc_html( $label ); ?> plugin <strong><?php echo esc_html( $plugin['name'] ); ?></strong> is nog niet actief.
				<?php echo esc_html( $plugin['reason'] ); ?>
				<a href="<?php echo esc_url( $install_url ); ?>">Plugin installeren / activeren</a>
			</p>
		</div>
		<?php
	}
}
add_action( 'admin_notices', 'fbf_admin_notice_required_plugins' );

/**
 * Widget-areas (optioneel, voor toekomstig gebruik).
 */
function fbf_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer', 'fitbyfloran' ),
		'id'            => 'footer-1',
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'fbf_widgets_init' );

/**
 * Fallback hoofdmenu (zolang er nog geen menu is aangemaakt onder Weergave > Menu's).
 */
function fbf_default_menu() {
	echo '<ul class="navlinks">
		<li><a href="#aanpak">Aanpak</a></li>
		<li><a href="#diensten">Diensten</a></li>
		<li><a href="#resultaten">Resultaten</a></li>
		<li><a href="#contact">Contact</a></li>
	</ul>';
}

/**
 * Fallback mobiel menu.
 */
function fbf_default_menu_mobile() {
	echo '<a href="#aanpak">Aanpak</a>
	<a href="#diensten">Diensten</a>
	<a href="#resultaten">Resultaten</a>
	<a href="#contact">Contact</a>';
}

/**
 * Fallback footermenu.
 */
function fbf_default_menu_footer() {
	echo '<ul>
		<li><a href="#diensten">Diensten</a></li>
		<li><a href="#aanpak">Aanpak</a></li>
		<li><a href="#resultaten">Resultaten</a></li>
		<li><a href="#contact">Contact</a></li>
	</ul>';
}
