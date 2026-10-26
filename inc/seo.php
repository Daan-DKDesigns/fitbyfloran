<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Technische vindbaarheid (SEO).
 * - Beschrijving, deelvoorbeeld (Open Graph) en Twitter-kaart. Alleen zonder SEO-plug-in:
 *   installeer je later Yoast of Rank Math, dan neemt die het over en komt er niets dubbel op de pagina.
 * - Gestructureerde data (schema.org): de praktijk als fysiotherapeut, met de trajecten en prijzen.
 * - Indexering: geen dunne pagina's in Google, geen gebruikersnamen zichtbaar, schone sitemap.
 * - Een opgeruimde <head>.
 */

/** Is er een SEO-plug-in actief? Dan regelt die beschrijving en deelvoorbeeld. */
function fbf_has_seo_plugin() {
	return defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) || defined( 'SEOPRESS_VERSION' ) || defined( 'AIOSEO_VERSION' );
}

/** Korte, schone tekst: zonder HTML en witruimte, hooguit $max tekens. */
function fbf_seo_clean( $text, $max = 160 ) {
	$text = trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( (string) $text ) ) );
	return wp_html_excerpt( $text, $max, '...' );
}

/** De introductietekst van de voorpagina (dezelfde fallback als in front-page.php). */
function fbf_seo_intro( $max = 160 ) {
	return fbf_seo_clean( fbf_field( 'hero_tekst', 'Persoonlijke fysiotherapie en performancebegeleiding voor sporters die sterker, belastbaarder en beter willen presteren — van blessureherstel en preventie tot return-to-performance.', (int) get_option( 'page_on_front' ) ?: false ), $max );
}

/** Beschrijving van de huidige pagina. */
function fbf_seo_description() {
	if ( is_front_page() ) {
		return fbf_seo_intro();
	}
	if ( is_singular() ) {
		$post = get_queried_object();
		$text = has_excerpt( $post ) ? get_the_excerpt( $post ) : $post->post_content;
		$text = fbf_seo_clean( strip_shortcodes( $text ) );
		return $text ? $text : fbf_seo_intro();
	}
	return fbf_seo_intro();
}

/** Deelafbeelding: de hero-achtergrond, anders de meegeleverde headerfoto. */
function fbf_seo_image() {
	$front = (int) get_option( 'page_on_front' );
	$image = function_exists( 'get_field' ) ? get_field( 'hero_achtergrond', $front ?: false ) : false;
	if ( ! empty( $image['url'] ) ) {
		return array(
			'url'    => $image['url'],
			'width'  => isset( $image['width'] ) ? (int) $image['width'] : 0,
			'height' => isset( $image['height'] ) ? (int) $image['height'] : 0,
			'alt'    => isset( $image['alt'] ) ? $image['alt'] : '',
		);
	}
	return array(
		'url'    => get_template_directory_uri() . '/assets/images/header-afbeelding.jpg',
		'width'  => 0,
		'height' => 0,
		'alt'    => '',
	);
}

/* ---------- Beschrijving en deelvoorbeeld ---------- */

add_action( 'wp_head', function () {
	if ( fbf_has_seo_plugin() ) {
		return;
	}
	$desc  = fbf_seo_description();
	$url   = is_front_page() ? home_url( '/' ) : ( is_singular() ? get_permalink( get_queried_object_id() ) : '' );
	$image = fbf_seo_image();

	if ( $desc ) {
		printf( "<meta name=\"description\" content=\"%s\">\n", esc_attr( $desc ) );
	}
	echo "<meta property=\"og:type\" content=\"website\">\n";
	printf( "<meta property=\"og:site_name\" content=\"%s\">\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( "<meta property=\"og:title\" content=\"%s\">\n", esc_attr( wp_get_document_title() ) );
	if ( $desc ) {
		printf( "<meta property=\"og:description\" content=\"%s\">\n", esc_attr( $desc ) );
	}
	if ( $url ) {
		printf( "<meta property=\"og:url\" content=\"%s\">\n", esc_url( $url ) );
	}
	printf( "<meta property=\"og:locale\" content=\"%s\">\n", esc_attr( get_locale() ) );
	printf( "<meta property=\"og:image\" content=\"%s\">\n", esc_url( $image['url'] ) );
	if ( $image['width'] && $image['height'] ) {
		printf( "<meta property=\"og:image:width\" content=\"%d\">\n", $image['width'] );
		printf( "<meta property=\"og:image:height\" content=\"%d\">\n", $image['height'] );
	}
	if ( $image['alt'] ) {
		printf( "<meta property=\"og:image:alt\" content=\"%s\">\n", esc_attr( $image['alt'] ) );
	}
	echo "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
}, 1 );

/* ---------- Indexering ---------- */

/**
 * Niet in Google: zoekresultaten, datumarchieven, 404, en de voorpagina met ?contact=
 * (de melding na het formulier). Links op die pagina's worden wel gevolgd.
 */
add_filter( 'wp_robots', function ( $robots ) {
	$contact = isset( $_GET['contact'] ); // phpcs:ignore WordPress.Security.NonceVerification
	if ( is_search() || is_date() || is_404() || $contact ) {
		$robots['noindex'] = true;
		$robots['follow']  = true;
		unset( $robots['max-image-preview'] );
	}
	return $robots;
} );

/** Auteurspagina's verwijzen naar de voorpagina: ze verraden anders de gebruikersnaam om in te loggen. */
add_action( 'template_redirect', function () {
	if ( is_author() || isset( $_GET['author'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}, 1 );

/** Ook de REST-API geeft gebruikersnamen niet prijs aan bezoekers die niet zijn ingelogd. */
add_filter( 'rest_endpoints', function ( $endpoints ) {
	if ( ! is_user_logged_in() ) {
		unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
	}
	return $endpoints;
} );

/** Sitemap: geen gebruikers, geen prijsopgaves (die staan op de voorpagina), en geen blog zonder blogberichten. */
add_filter( 'wp_sitemaps_add_provider', function ( $provider, $name ) {
	return 'users' === $name ? false : $provider;
}, 10, 2 );

/** ID's van de voorbeeldinhoud die WordPress bij installatie aanmaakt ("Hallo wereld!", "Voorbeeldpagina"). */
function fbf_default_content_ids() {
	static $ids = null;
	if ( null === $ids ) {
		$ids = array();
		foreach ( array( 'hello-world', 'hallo-wereld' ) as $slug ) {
			$post = get_page_by_path( $slug, OBJECT, 'post' );
			if ( $post ) {
				$ids[] = (int) $post->ID;
			}
		}
		foreach ( array( 'sample-page', 'voorbeeld-pagina' ) as $slug ) {
			$page = get_page_by_path( $slug );
			if ( $page ) {
				$ids[] = (int) $page->ID;
			}
		}
	}
	return $ids;
}

/** Zijn er echte blogberichten (dus niet alleen "Hallo wereld!")? */
function fbf_has_blog_posts() {
	return (bool) get_posts( array(
		'post_type'    => 'post',
		'numberposts'  => 1,
		'fields'       => 'ids',
		'post__not_in' => fbf_default_content_ids(),
	) );
}

add_filter( 'wp_sitemaps_post_types', function ( $types ) {
	unset( $types['prijsopgave'] );
	if ( ! fbf_has_blog_posts() ) {
		unset( $types['post'] );
	}
	return $types;
} );

add_filter( 'wp_sitemaps_taxonomies', function ( $taxonomies ) {
	if ( ! fbf_has_blog_posts() ) {
		unset( $taxonomies['category'], $taxonomies['post_tag'] );
	}
	return $taxonomies;
} );

/** Voorbeeldinhoud van WordPress hoort niet in de sitemap... */
add_filter( 'wp_sitemaps_posts_query_args', function ( $args ) {
	$args['post__not_in'] = array_merge( isset( $args['post__not_in'] ) ? (array) $args['post__not_in'] : array(), fbf_default_content_ids() );
	return $args;
} );

/** ...en ook niet in Google, als iemand ze vergeet te verwijderen. */
add_filter( 'wp_robots', function ( $robots ) {
	if ( is_singular() && in_array( get_queried_object_id(), fbf_default_content_ids(), true ) ) {
		$robots['noindex'] = true;
		$robots['follow']  = true;
	}
	return $robots;
} );

/* ---------- Gestructureerde data (schema.org) ---------- */

/** Bedrag uit een prijsveld als "€495" of "€ 1.250,-", of '' als er geen bedrag in staat. */
function fbf_schema_price( $prijs ) {
	if ( ! preg_match( '/\d[\d.]*(?:,\d{1,2})?/', (string) $prijs, $m ) ) {
		return '';
	}
	return str_replace( ',', '.', str_replace( '.', '', $m[0] ) );
}

/** De praktijk, zoals Google en AI-zoekmachines die als fysiotherapeut kunnen begrijpen. */
function fbf_schema_business() {
	$home  = home_url( '/' );
	$image = fbf_seo_image();
	$logo  = has_site_icon() ? get_site_icon_url( 512 ) : get_template_directory_uri() . '/assets/images/logo.png';
	$biz   = array(
		'@type'       => 'Physiotherapy',
		'@id'         => $home . '#praktijk',
		'name'        => get_bloginfo( 'name' ),
		'description' => fbf_seo_intro( 300 ),
		'url'         => $home,
		'logo'        => $logo,
		'image'       => $image['url'],
		'email'       => fbf_contact_email(),
		'telephone'   => fbf_contact_phone(),
	);
	$same = array_values( array_filter( array(
		fbf_field( 'instagram_url', '', 'option' ),
		fbf_field( 'linkedin_url', '', 'option' ),
	) ) );
	if ( $same ) {
		$biz['sameAs'] = $same;
	}

	// De trajecten en memberships met prijs, zodat zoekmachines het aanbod kennen.
	$offers = array();
	foreach ( fbf_get_prijsopgaves() as $item ) {
		$service = array(
			'@type' => 'Service',
			'name'  => $item['titel'],
		);
		if ( $item['beschrijving'] ) {
			$service['description'] = fbf_seo_clean( $item['beschrijving'], 300 );
		}
		$offer = array(
			'@type'       => 'Offer',
			'itemOffered' => $service,
			'url'         => $home . '#diensten',
		);
		$price = fbf_schema_price( $item['prijs'] );
		if ( '' !== $price ) {
			$offer['priceSpecification'] = array(
				'@type'         => 'PriceSpecification',
				'price'         => $price,
				'priceCurrency' => 'EUR',
			);
			if ( preg_match( '/p\.?\s*m\.?|per maand|maand/i', $item['prijs_periode'] ) ) {
				$offer['priceSpecification']['@type']         = 'UnitPriceSpecification';
				$offer['priceSpecification']['unitCode']      = 'MON';
				$offer['priceSpecification']['referenceQuantity'] = array(
					'@type'    => 'QuantitativeValue',
					'value'    => 1,
					'unitCode' => 'MON',
				);
			}
		}
		$offers[] = $offer;
	}
	if ( $offers ) {
		$biz['hasOfferCatalog'] = array(
			'@type'           => 'OfferCatalog',
			'name'            => 'Trajecten en memberships',
			'itemListElement' => $offers,
		);
	}

	$knows    = array( 'Sportfysiotherapie', 'Blessureherstel', 'Blessurepreventie', 'Return-to-performance', 'Performancebegeleiding' );
	$knows = array_merge( $knows, array_filter( wp_list_pluck( fbf_specialisaties(), 'titel' ) ) );
	$biz['knowsAbout'] = array_values( array_unique( $knows ) );

	return $biz;
}

add_action( 'wp_head', function () {
	$home  = home_url( '/' );
	$graph = array( fbf_schema_business() );

	if ( ! fbf_has_seo_plugin() ) {
		$graph[] = array(
			'@type'      => 'WebSite',
			'@id'        => $home . '#website',
			'url'        => $home,
			'name'       => get_bloginfo( 'name' ),
			'inLanguage' => str_replace( '_', '-', get_locale() ),
			'publisher'  => array( '@id' => $home . '#praktijk' ),
		);
	}

	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG ) . "</script>\n";
}, 5 );

/* ---------- Een opgeruimde <head> ---------- */

// Emoji-script van WordPress: browsers tonen emoji zelf al.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_emoji_styles' );
add_filter( 'emoji_svg_url', '__return_false' );

// Overbodige regels, waaronder de WordPress-versie.
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

/** De voorpagina gebruikt geen blokken, dus de stijlen van de blokeditor zijn daar niet nodig. */
add_action( 'wp_enqueue_scripts', function () {
	if ( is_front_page() ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'classic-theme-styles' );
		wp_dequeue_style( 'global-styles' );
	}
}, 100 );

/**
 * Extra attributen voor een <img> uit een ACF-afbeelding: vaste afmetingen (geen verspringende
 * pagina tijdens het laden) en pas laden als de foto in beeld komt.
 */
function fbf_img_attrs( $image ) {
	$attrs = ' loading="lazy" decoding="async"';
	if ( ! empty( $image['width'] ) && ! empty( $image['height'] ) ) {
		$attrs .= sprintf( ' width="%d" height="%d"', (int) $image['width'], (int) $image['height'] );
	}
	return $attrs;
}

/** De hero-foto is het grootste element bovenaan: die laat de browser als eerste ophalen. */
add_action( 'wp_head', function () {
	if ( ! is_front_page() ) {
		return;
	}
	$image = fbf_seo_image();
	printf( "<link rel=\"preload\" as=\"image\" href=\"%s\" fetchpriority=\"high\">\n", esc_url( $image['url'] ) );
}, 2 );

/** Kleur van de browserbalk op de telefoon, gelijk aan de zwarte header. */
add_action( 'wp_head', function () {
	echo "<meta name=\"theme-color\" content=\"#0e0e0e\">\n";
}, 2 );
