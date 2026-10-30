<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * E-mails van het intakeformulier in de huisstijl:
 * - een aanvraag-mail aan Floran (naar het adres bij Site-instellingen);
 * - een bevestiging aan de bezoeker.
 * Opgemaakt met tabellen en inline stijlen (zo tonen Outlook, Gmail en Apple Mail het goed),
 * met een platte-tekstversie erbij voor mailprogramma's zonder HTML.
 */

/** Huisstijlkleuren voor in de mails. */
function fbf_mail_kleuren() {
	return array(
		'zwart' => '#0e0e0e',
		'goud'  => '#d4af37',
		'goud2' => '#f0d27a',
		'tekst' => '#1f2326',
		'grijs' => '#5e666c',
		'lijn'  => '#e6e1d6',
		'licht' => '#f3f0e9',
	);
}

/** Een gouden knop voor in een mail. */
function fbf_mail_knop( $tekst, $url, $donker = false ) {
	$k  = fbf_mail_kleuren();
	$bg = $donker ? $k['zwart'] : $k['goud'];
	$fg = $donker ? '#ffffff' : '#0e0e0e';
	return sprintf(
		'<a href="%1$s" style="display:inline-block;margin:0 8px 8px 0;padding:12px 18px;background:%2$s;color:%3$s;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:bold;letter-spacing:.04em;text-decoration:none;text-transform:uppercase;">%4$s</a>',
		esc_url( $url ),
		$bg,
		$fg,
		esc_html( $tekst )
	);
}

/**
 * De omlijsting van elke mail: zwarte kop met de naam in goud, witte inhoud, voet met contact.
 * $voorvertoning = de korte tekst die mailprogramma's naast het onderwerp tonen.
 */
function fbf_mail_layout( $voorvertoning, $titel, $inhoud ) {
	$k     = fbf_mail_kleuren();
	$email = fbf_contact_email();
	$tel   = fbf_contact_phone();
	$voet  = esc_html( get_bloginfo( 'name' ) ) . ' &middot; <a href="' . esc_url( home_url( '/' ) ) . '" style="color:' . $k['grijs'] . ';">' . esc_html( wp_parse_url( home_url(), PHP_URL_HOST ) ) . '</a>';
	if ( $email ) {
		$voet .= ' &middot; <a href="mailto:' . esc_attr( $email ) . '" style="color:' . $k['grijs'] . ';">' . esc_html( $email ) . '</a>';
	}
	if ( $tel ) {
		$voet .= ' &middot; ' . esc_html( $tel );
	}

	return '<!DOCTYPE html><html lang="nl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>' . esc_html( $titel ) . '</title></head>'
		. '<body style="margin:0;padding:0;background:' . $k['licht'] . ';">'
		. '<div style="display:none;max-height:0;overflow:hidden;opacity:0;">' . esc_html( $voorvertoning ) . '</div>'
		. '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:' . $k['licht'] . ';"><tr><td align="center" style="padding:28px 12px;">'
		. '<table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;background:#ffffff;border:1px solid ' . $k['lijn'] . ';">'
		// Kop
		. '<tr><td style="background:' . $k['zwart'] . ';padding:26px 32px;border-bottom:3px solid ' . $k['goud'] . ';">'
		. '<div style="font-family:Arial,Helvetica,sans-serif;font-size:11px;font-weight:bold;letter-spacing:.22em;color:' . $k['goud2'] . ';text-transform:uppercase;">High Performance Physiotherapy</div>'
		. '<div style="margin-top:6px;font-family:Arial,Helvetica,sans-serif;font-size:24px;font-weight:bold;letter-spacing:.06em;color:#ffffff;text-transform:uppercase;">Fit by Floran</div>'
		. '</td></tr>'
		// Inhoud
		. '<tr><td style="padding:32px;font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.6;color:' . $k['tekst'] . ';">'
		. '<h1 style="margin:0 0 16px;font-family:Arial,Helvetica,sans-serif;font-size:22px;line-height:1.3;color:' . $k['zwart'] . ';">' . esc_html( $titel ) . '</h1>'
		. $inhoud
		. '</td></tr>'
		// Voet
		. '<tr><td style="padding:18px 32px;background:' . $k['licht'] . ';border-top:1px solid ' . $k['lijn'] . ';font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:1.6;color:' . $k['grijs'] . ';">' . $voet . '</td></tr>'
		. '</table></td></tr></table></body></html>';
}

/** Een tabel met gegevens (label => waarde) voor in een mail. Waarden zijn al veilige HTML. */
function fbf_mail_tabel( $rijen ) {
	$k    = fbf_mail_kleuren();
	$html = '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:6px 0 22px;border-collapse:collapse;">';
	foreach ( $rijen as $label => $waarde ) {
		$html .= '<tr>'
			. '<td style="width:34%;padding:10px 12px 10px 0;border-bottom:1px solid ' . $k['lijn'] . ';font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;letter-spacing:.06em;text-transform:uppercase;color:' . $k['grijs'] . ';vertical-align:top;">' . esc_html( $label ) . '</td>'
			. '<td style="padding:10px 0;border-bottom:1px solid ' . $k['lijn'] . ';font-family:Arial,Helvetica,sans-serif;font-size:15px;color:' . $k['tekst'] . ';vertical-align:top;">' . $waarde . '</td>'
			. '</tr>';
	}
	return $html . '</table>';
}

/** Mail aan Floran met de aanvraag. Geeft [onderwerp, html, platte tekst]. */
function fbf_mail_aanvraag( $d ) {
	$k        = fbf_mail_kleuren();
	$tel_href = $d['telefoon'] !== '' ? fbf_tel_href( $d['telefoon'] ) : '';
	$onderwerp = 'Nieuwe intake-aanvraag: ' . $d['naam'] . ( $d['hulpvraag'] !== '' ? ' (' . $d['hulpvraag'] . ')' : '' );

	$rijen = array(
		'Naam'      => esc_html( $d['naam'] ),
		'E-mail'    => '<a href="mailto:' . esc_attr( $d['email'] ) . '" style="color:' . $k['tekst'] . ';">' . esc_html( $d['email'] ) . '</a>',
		'Telefoon'  => $d['telefoon'] !== '' ? ( $tel_href ? '<a href="' . esc_url( $tel_href ) . '" style="color:' . $k['tekst'] . ';">' . esc_html( $d['telefoon'] ) . '</a>' : esc_html( $d['telefoon'] ) ) : '<span style="color:' . $k['grijs'] . ';">Niet ingevuld</span>',
		'Hulpvraag' => $d['hulpvraag'] !== '' ? esc_html( $d['hulpvraag'] ) : '<span style="color:' . $k['grijs'] . ';">Niet gekozen</span>',
		'Ontvangen' => esc_html( wp_date( 'j F Y \o\m H:i' ) ),
	);

	$inhoud = '<p style="margin:0 0 18px;">Er is een nieuwe aanvraag binnengekomen via het intakeformulier op de website.</p>'
		. fbf_mail_tabel( $rijen );
	if ( $d['bericht'] !== '' ) {
		$inhoud .= '<div style="margin:0 0 6px;font-size:12px;font-weight:bold;letter-spacing:.06em;text-transform:uppercase;color:' . $k['grijs'] . ';">Toelichting</div>'
			. '<div style="margin:0 0 24px;padding:14px 16px;background:' . $k['licht'] . ';border-left:3px solid ' . $k['goud'] . ';white-space:pre-line;">' . esc_html( $d['bericht'] ) . '</div>';
	}
	$inhoud .= '<div style="margin-top:6px;">'
		. fbf_mail_knop( 'Beantwoorden per e-mail', 'mailto:' . $d['email'] . '?subject=' . rawurlencode( 'Re: je intake-aanvraag bij Fit by Floran' ) )
		. ( $tel_href ? fbf_mail_knop( 'Bellen', $tel_href, true ) : '' )
		. ( $d['telefoon'] !== '' ? fbf_mail_knop( 'WhatsApp', 'https://wa.me/' . fbf_whatsapp_nummer_van( $d['telefoon'] ), true ) : '' )
		. '</div>'
		. '<p style="margin:18px 0 0;font-size:13px;color:' . $k['grijs'] . ';">Tip: op "Beantwoorden" klikken in je mailprogramma stuurt je antwoord direct naar ' . esc_html( $d['naam'] ) . '.</p>';

	$tekst = "Nieuwe intake-aanvraag via de website\n\n"
		. 'Naam: ' . $d['naam'] . "\n"
		. 'E-mail: ' . $d['email'] . "\n"
		. 'Telefoon: ' . ( $d['telefoon'] !== '' ? $d['telefoon'] : '-' ) . "\n"
		. 'Hulpvraag: ' . ( $d['hulpvraag'] !== '' ? $d['hulpvraag'] : '-' ) . "\n\n"
		. "Toelichting:\n" . ( $d['bericht'] !== '' ? $d['bericht'] : '-' ) . "\n";

	return array( $onderwerp, fbf_mail_layout( $d['naam'] . ' heeft een intake aangevraagd.', 'Nieuwe intake-aanvraag', $inhoud ), $tekst );
}

/**
 * Bevestiging aan de bezoeker. Bevat bewust alleen de naam en de keuze uit de vaste lijst,
 * niet de vrije toelichting: zo kan niemand het formulier misbruiken om eigen tekst naar
 * andermans adres te sturen.
 */
function fbf_mail_bevestiging( $d ) {
	$k         = fbf_mail_kleuren();
	$voornaam  = trim( strtok( $d['naam'], ' ' ) );
	$onderwerp = 'Bedankt voor je aanvraag bij Fit by Floran';
	$wa        = fbf_whatsapp_url();

	$inhoud = '<p style="margin:0 0 16px;">Hoi ' . esc_html( $voornaam ) . ',</p>'
		. '<p style="margin:0 0 16px;">Bedankt voor je aanvraag voor een gratis intake. Ik heb hem goed ontvangen en neem zo snel mogelijk persoonlijk contact met je op om een moment af te spreken.</p>';
	if ( $d['hulpvraag'] !== '' ) {
		$inhoud .= fbf_mail_tabel( array( 'Je aanvraag' => esc_html( $d['hulpvraag'] ) ) );
	}
	$inhoud .= '<div style="margin:0 0 6px;font-size:12px;font-weight:bold;letter-spacing:.06em;text-transform:uppercase;color:' . $k['grijs'] . ';">Wat gebeurt er nu?</div>'
		. '<ol style="margin:0 0 22px;padding-left:20px;">'
		. '<li style="margin:0 0 6px;">Ik bekijk je aanvraag.</li>'
		. '<li style="margin:0 0 6px;">Ik neem contact met je op om de intake in te plannen.</li>'
		. '<li style="margin:0;">Tijdens de intake brengen we jouw situatie en doelen in kaart.</li>'
		. '</ol>'
		. '<p style="margin:0 0 16px;">Liever direct contact of wil je iets aanvullen? Stuur gerust een WhatsApp, of beantwoord deze mail.</p>'
		. '<div>' . fbf_mail_knop( 'Stuur een WhatsApp', $wa ) . '</div>'
		. '<p style="margin:22px 0 0;">Sportieve groet,<br><strong>Floran</strong><br><span style="color:' . $k['grijs'] . ';">Fit by Floran &ndash; High Performance Physiotherapy</span></p>';

	$tekst = 'Hoi ' . $voornaam . ",\n\n"
		. "Bedankt voor je aanvraag voor een gratis intake. Ik heb hem goed ontvangen en neem zo snel mogelijk persoonlijk contact met je op om een moment af te spreken.\n\n"
		. ( $d['hulpvraag'] !== '' ? 'Je aanvraag: ' . $d['hulpvraag'] . "\n\n" : '' )
		. "Liever direct contact? WhatsApp: " . $wa . "\nOf beantwoord deze mail.\n\n"
		. "Sportieve groet,\nFloran\nFit by Floran - High Performance Physiotherapy\n";

	return array( $onderwerp, fbf_mail_layout( 'Je aanvraag is ontvangen. Ik neem zo snel mogelijk contact met je op.', 'Bedankt voor je aanvraag', $inhoud ), $tekst );
}

/** Telefoonnummer naar het formaat van wa.me (alleen cijfers, met landcode). */
function fbf_whatsapp_nummer_van( $telefoon ) {
	$href = fbf_tel_href( $telefoon ); // tel:+31612345678
	return preg_replace( '/[^0-9]/', '', (string) $href );
}

/**
 * Een HTML-mail versturen met de platte tekst als alternatief, afzendernaam "Fit by Floran".
 * Het afzenderadres laat WordPress (of een SMTP-plug-in) zelf bepalen.
 */
function fbf_mail_versturen( $aan, $onderwerp, $html, $tekst, $antwoord_aan ) {
	$naam = static function () {
		return 'Fit by Floran';
	};
	$alt = static function ( $phpmailer ) use ( $tekst ) {
		$phpmailer->AltBody = $tekst;
	};
	add_filter( 'wp_mail_from_name', $naam );
	add_action( 'phpmailer_init', $alt );
	$ok = wp_mail( $aan, $onderwerp, $html, array( 'Content-Type: text/html; charset=UTF-8', 'Reply-To: ' . $antwoord_aan ) );
	remove_action( 'phpmailer_init', $alt );
	remove_filter( 'wp_mail_from_name', $naam );
	return $ok;
}
