<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Vindbaarheid in AI-zoekmachines (ChatGPT, Claude, Perplexity, Google AI) en een nette robots.txt.
 * - /llms.txt: een korte, leesbare samenvatting van de praktijk, de aanpak en de trajecten,
 *   altijd actueel want opgebouwd uit de velden van de voorpagina en de prijsopgaves.
 * - robots.txt: zoekmachines en AI-zoekrobots welkom, geen dunne pagina's (zoeken, formuliermelding).
 * Tijdens de onderhoudsmodus geeft /llms.txt net als de rest van de site "Binnenkort live".
 */

/** De tekst van /llms.txt (Markdown, zie llmstxt.org). */
function fbf_llms_txt() {
	$lines = array( '# ' . get_bloginfo( 'name' ), '' );

	$intro = fbf_seo_intro( 400 );
	if ( $intro ) {
		$lines[] = '> ' . $intro;
		$lines[] = '';
	}

	$lines[] = '- Website: ' . home_url( '/' );
	$lines[] = '- E-mail: ' . fbf_contact_email();
	$lines[] = '- Telefoon: ' . fbf_contact_phone();
	$lines[] = '- WhatsApp: ' . fbf_whatsapp_url();
	foreach ( array( 'instagram_url' => 'Instagram', 'linkedin_url' => 'LinkedIn' ) as $key => $label ) {
		$value = fbf_field( $key, '', 'option' );
		if ( $value ) {
			$lines[] = '- ' . $label . ': ' . $value;
		}
	}
	$lines[] = '';

	$about = fbf_about_tekst();
	if ( $about ) {
		$lines[] = '## Over Floran';
		$lines[] = '';
		$lines[] = fbf_seo_clean( $about, 800 );
		$lines[] = '';
	}

	$stappen = fbf_aanpak_stappen();
	if ( is_array( $stappen ) && $stappen ) {
		$lines[] = '## Aanpak';
		$lines[] = '';
		foreach ( array_values( $stappen ) as $i => $stap ) {
			if ( empty( $stap['titel'] ) ) {
				continue;
			}
			$tekst   = ! empty( $stap['tekst'] ) ? fbf_seo_clean( $stap['tekst'], 300 ) : '';
			$lines[] = ( $i + 1 ) . '. ' . $stap['titel'] . ( $tekst ? ': ' . $tekst : '' );
		}
		$lines[] = '';
	}

	$trajecten = fbf_get_prijsopgaves();
	if ( $trajecten ) {
		$lines[] = '## Trajecten en memberships';
		$lines[] = '';
		foreach ( $trajecten as $item ) {
			$prijs = trim( trim( $item['vanaf_label'] . ' ' . $item['prijs'] ) . ' ' . $item['prijs_periode'] );
			$regel = '- ' . $item['titel'] . ( $prijs ? ' (' . $prijs . ')' : '' );
			if ( $item['beschrijving'] ) {
				$regel .= ': ' . fbf_seo_clean( $item['beschrijving'], 200 );
			}
			if ( $item['kenmerken'] ) {
				$regel .= ' Inclusief: ' . implode( '; ', $item['kenmerken'] ) . '.';
			}
			$lines[] = $regel;
		}
		$lines[] = '';
	}

	$specials = fbf_specialisaties();
	if ( is_array( $specials ) && $specials ) {
		$lines[] = '## Specialisaties';
		$lines[] = '';
		foreach ( $specials as $special ) {
			if ( empty( $special['titel'] ) ) {
				continue;
			}
			$tekst   = ! empty( $special['tekst'] ) ? fbf_seo_clean( $special['tekst'], 200 ) : '';
			$lines[] = '- ' . $special['titel'] . ( $tekst ? ': ' . $tekst : '' );
		}
		$lines[] = '';
	}

	$lines[] = '## Contact';
	$lines[] = '';
	$lines[] = '- [Gratis intake plannen via het contactformulier](' . home_url( '/#contact' ) . ')';
	$lines[] = '- [Sitemap](' . home_url( '/wp-sitemap.xml' ) . ')';

	return implode( "\n", $lines ) . "\n";
}

/** /llms.txt bedienen. Na de onderhoudsmodus (prioriteit 10), zodat die voorgaat. */
add_action( 'template_redirect', function () {
	$path = trim( (string) wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '', PHP_URL_PATH ), '/' ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	if ( 'llms.txt' !== $path ) {
		return;
	}
	status_header( 200 );
	header( 'Content-Type: text/plain; charset=utf-8' );
	header( 'X-Robots-Tag: noindex' );
	echo fbf_llms_txt(); // phpcs:ignore WordPress.Security.EscapeOutput
	exit;
}, 11 );

/** robots.txt: welkom voor zoekmachines en AI-zoekrobots, maar niet op zoek- en meldingspagina's. */
add_filter( 'robots_txt', function ( $output, $public ) {
	if ( ! $public ) {
		return $output;
	}
	$extra  = "Disallow: /?s=\nDisallow: /search/\nDisallow: /*?contact=\n";
	$output = preg_replace( '/^(Allow: \/wp-admin\/admin-ajax\.php\n)/m', '$1' . $extra, $output, 1 );
	$output .= "\n# AI-zoekmachines mogen de site lezen, zodat de praktijk daar ook gevonden wordt.\n";
	$output .= '# Samenvatting voor taalmodellen: ' . home_url( '/llms.txt' ) . "\n";
	foreach ( array( 'GPTBot', 'OAI-SearchBot', 'ChatGPT-User', 'ClaudeBot', 'Claude-SearchBot', 'Claude-User', 'PerplexityBot', 'Perplexity-User', 'Google-Extended', 'Applebot-Extended' ) as $bot ) {
		$output .= "User-agent: $bot\n";
	}
	$output .= "Allow: /\nDisallow: /wp-admin/\nDisallow: /?s=\nDisallow: /*?contact=\n";
	return $output;
}, 20, 2 );
