<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Menu-item "Fit by Floran" met de site-instellingen: onderhoudsmodus, contactgegevens,
 * WhatsApp en socials. Een gewone WordPress-instellingenpagina, dus het werkt met de gratis
 * versie van ACF (een ACF-optiespagina vereist ACF Pro en bestond daarom live niet).
 *
 * De waarden staan als "options_{naam}", precies zoals ACF Pro ze zou opslaan. fbf_field( …, 'option' )
 * leest ze daar uit, dus alles wat ooit is ingevuld blijft werken.
 */

/** Alle instellingen: naam => [label, type, standaardwaarde, uitleg, sectie]. */
function fbf_instellingen() {
	return array(
		'onderhoudsmodus'    => array( 'Onderhoudsmodus', 'schakelaar', '1', 'Aan: bezoekers zien de pagina "Binnenkort live". Uit: iedereen ziet de echte website. Als ingelogde beheerder zie je altijd de echte website.', 'online' ),
		'contact_email'      => array( 'E-mailadres', 'email', 'info@fitbyfloran.nl', 'Hier komen de intake-aanvragen binnen. Staat ook in de footer en het mobiele menu.', 'contact' ),
		'contact_telefoon'   => array( 'Telefoonnummer', 'text', '06 3428 0140', 'Zoals het op de website moet staan, bijv. 06 3428 0140.', 'contact' ),
		'whatsapp_nummer'    => array( 'WhatsApp-nummer', 'text', '31634280140', 'Internationaal, zonder + of 00. Bijv. 31634280140.', 'whatsapp' ),
		'whatsapp_bericht'   => array( 'Voorgevuld WhatsApp-bericht', 'text', 'Hallo, ik wil graag een gratis intake plannen', 'Deze tekst staat al klaar in WhatsApp als iemand op een WhatsApp-knop drukt.', 'whatsapp' ),
		'whatsapp_knoptekst' => array( 'Tekst naast de groene knop', 'text', 'Vragen? App me', 'Zichtbaar naast de WhatsApp-knop rechtsonder (op de computer).', 'whatsapp' ),
		'instagram_url'      => array( 'Instagram', 'url', '', 'Volledige link, bijv. https://www.instagram.com/fitbyfloran. Leeg = niet tonen.', 'socials' ),
		'linkedin_url'       => array( 'LinkedIn', 'url', '', 'Volledige link, bijv. https://www.linkedin.com/in/… Leeg = niet tonen.', 'socials' ),
	);
}

/** Opgeslagen waarde van een instelling, of null als die nooit is ingevuld. */
function fbf_instelling( $naam ) {
	$waarde = get_option( 'options_' . $naam, null );
	return ( null === $waarde || '' === $waarde ) ? null : $waarde;
}

/* ---------- Menu-item en pagina ---------- */

add_action( 'admin_menu', function () {
	add_menu_page(
		'Site-instellingen',
		'Fit by Floran',
		'manage_options',
		'fbf-options',
		'fbf_instellingen_pagina',
		'dashicons-admin-generic',
		59
	);
} );

add_action( 'admin_init', function () {
	foreach ( fbf_instellingen() as $naam => $cfg ) {
		register_setting( 'fbf_instellingen', 'options_' . $naam, array(
			'type'              => 'string',
			'sanitize_callback' => function ( $waarde ) use ( $cfg ) {
				$waarde = is_string( $waarde ) ? trim( $waarde ) : ''; // options.php heeft al ge-unslasht.
				switch ( $cfg[1] ) {
					case 'schakelaar':
						return '1' === $waarde ? '1' : '0';
					case 'email':
						return sanitize_email( $waarde );
					case 'url':
						return esc_url_raw( $waarde );
					default:
						return sanitize_text_field( $waarde );
				}
			},
		) );
	}
} );

function fbf_instellingen_pagina() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$secties = array(
		'online'   => array( 'Website online', 'Bepaal of bezoekers de website al zien.' ),
		'contact'  => array( 'Contactgegevens', 'Gebruikt in de footer, het mobiele menu, het intakeformulier en de e-mails.' ),
		'whatsapp' => array( 'WhatsApp', 'Voor alle WhatsApp-knoppen op de website.' ),
		'socials'  => array( 'Socials', 'Verschijnen in de footer zodra ze zijn ingevuld.' ),
	);
	$aan = fbf_onderhoud_aan();
	?>
	<div class="wrap fbf-instellingen">
		<h1>Site-instellingen</h1>
		<?php settings_errors(); ?>
		<?php if ( defined( 'FBF_MAINTENANCE' ) ) : ?>
			<div class="notice notice-warning inline"><p>De onderhoudsmodus wordt vastgezet in <code>wp-config.php</code> (FBF_MAINTENANCE) en kan hier niet worden gewijzigd.</p></div>
		<?php endif; ?>
		<form method="post" action="options.php">
			<?php settings_fields( 'fbf_instellingen' ); ?>
			<?php foreach ( $secties as $sectie => $kop ) : ?>
				<div class="fbf-kaart">
					<h2><?php echo esc_html( $kop[0] ); ?></h2>
					<p class="description"><?php echo esc_html( $kop[1] ); ?></p>
					<table class="form-table" role="presentation">
						<?php foreach ( fbf_instellingen() as $naam => $cfg ) : ?>
							<?php
							if ( $cfg[4] !== $sectie ) {
								continue;
							}
							$id     = 'fbf_' . $naam;
							$veld   = 'options_' . $naam;
							$waarde = fbf_instelling( $naam );
							$waarde = null === $waarde ? $cfg[2] : $waarde;
							?>
							<tr>
								<th scope="row"><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $cfg[0] ); ?></label></th>
								<td>
									<?php if ( 'schakelaar' === $cfg[1] ) : ?>
										<input type="hidden" name="<?php echo esc_attr( $veld ); ?>" value="0">
										<label class="fbf-schakelaar">
											<input type="checkbox" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $veld ); ?>" value="1" <?php checked( '1', (string) $waarde ); ?> <?php disabled( defined( 'FBF_MAINTENANCE' ) ); ?>>
											<span><?php echo $aan ? 'Aan: bezoekers zien "Binnenkort live"' : 'Uit: de website is voor iedereen zichtbaar'; ?></span>
										</label>
									<?php else : ?>
										<input type="<?php echo esc_attr( 'url' === $cfg[1] ? 'url' : ( 'email' === $cfg[1] ? 'email' : 'text' ) ); ?>" class="regular-text" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $veld ); ?>" value="<?php echo esc_attr( (string) $waarde ); ?>">
									<?php endif; ?>
									<p class="description"><?php echo esc_html( $cfg[3] ); ?></p>
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
			<?php endforeach; ?>
			<?php submit_button( 'Wijzigingen opslaan' ); ?>
		</form>
	</div>
	<style>
		.fbf-instellingen .fbf-kaart{max-width:860px;background:#fff;border:1px solid #dcdcde;border-top:3px solid #d4af37;padding:6px 22px 4px;margin:18px 0}
		.fbf-instellingen .fbf-kaart h2{margin:14px 0 2px}
		.fbf-instellingen .fbf-schakelaar{display:inline-flex;align-items:center;gap:10px;font-weight:600}
		.fbf-instellingen .fbf-schakelaar input{transform:scale(1.3)}
	</style>
	<?php
}
