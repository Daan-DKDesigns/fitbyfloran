<?php
/**
 * Voorpagina — hero t/m contact.
 * ACF-beheerbaar (per klantwens): hero (titel/onderschrift/knoppen), het
 * "Over Floran"-blok (titel/ondertitel/knop), "Van analyse..." (titel + 4 kaarten),
 * en de prijsopgaves (los menu-item "Prijsopgaves" in het WP-admin, één item per pakket).
 * Specialisaties, samenwerkingen en socials zijn via ACF beheerbaar.
 * Lege fotovelden vallen terug op de foto's in assets/images/.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

$fbf_hero_image = function_exists( 'get_field' ) ? get_field( 'hero_achtergrond' ) : false;

$fbf_about_img1 = function_exists( 'get_field' ) ? get_field( 'about_afbeelding_1' ) : false;
$fbf_about_img2 = function_exists( 'get_field' ) ? get_field( 'about_afbeelding_2' ) : false;
$fbf_second_img = function_exists( 'get_field' ) ? get_field( 'tweede_sectie_afbeelding' ) : false;

// Zolang een fotoveld in ACF leeg is, valt het thema terug op de meegeleverde foto's.
$fbf_img_dir = get_template_directory_uri() . '/assets/images/';
if ( empty( $fbf_hero_image['url'] ) ) {
	$fbf_hero_image = array( 'url' => $fbf_img_dir . 'header-afbeelding.jpg' );
}
if ( empty( $fbf_about_img1['url'] ) ) {
	$fbf_about_img1 = array( 'url' => $fbf_img_dir . 'floran.jpg', 'alt' => 'Floran' );
}
if ( empty( $fbf_about_img2['url'] ) ) {
	$fbf_about_img2 = array( 'url' => $fbf_img_dir . 'floran-op-het-veld.jpg', 'alt' => 'Floran op het veld' );
}
if ( empty( $fbf_second_img['url'] ) ) {
	$fbf_second_img = array( 'url' => $fbf_img_dir . 'lang-het-veld.jpg', 'alt' => 'Floran langs het veld' );
}

$fbf_hero_style = ' style="background-image:linear-gradient(90deg,rgba(0,0,0,.92) 0%,rgba(0,0,0,.76) 38%,rgba(0,0,0,.18) 100%),url(' . esc_url( $fbf_hero_image['url'] ) . ');"';

$fbf_prijzen = fbf_get_prijsopgaves();

$fbf_specials = fbf_specialisaties();

$fbf_partners = fbf_samenwerkingen();

$fbf_contact_status = isset( $_GET['contact'] ) ? sanitize_key( wp_unslash( $_GET['contact'] ) ) : '';
$fbf_wa_url         = fbf_whatsapp_url();
?>

<main id="inhoud">
<section class="hero"<?php echo $fbf_hero_style; ?>>
  <div class="container hero-inner">
    <div class="eyebrow"><?php echo esc_html( fbf_field( 'hero_eyebrow', 'Fit by Floran · High Performance Physiotherapy' ) ); ?></div>
    <h1>
      <?php echo esc_html( fbf_field( 'hero_titel_regel1', 'Meer dan herstellen.' ) ); ?><br>
      <span><?php echo esc_html( fbf_field( 'hero_titel_regel2', 'Presteren op je hoogste niveau.' ) ); ?></span>
    </h1>
    <p class="lead-text"><?php echo esc_html( fbf_field( 'hero_tekst', "Persoonlijke fysiotherapie en performancebegeleiding voor sporters die sterker, belastbaarder en beter willen presteren — van blessureherstel en preventie tot return-to-performance." ) ); ?></p>
    <div class="actions">
      <a class="btn btn-gold" href="<?php echo esc_url( fbf_field( 'hero_knop1_link', '#contact' ) ); ?>"><?php echo esc_html( fbf_field( 'hero_knop1_tekst', 'Plan je gratis intake' ) ); ?></a>
      <a class="btn btn-outline" href="<?php echo esc_url( fbf_field( 'hero_knop2_link', '#diensten' ) ); ?>"><?php echo esc_html( fbf_field( 'hero_knop2_tekst', 'Bekijk de trajecten' ) ); ?></a>
    </div>
  </div>
</section>

<section id="over">
  <div class="container about">
    <div class="about-images">
      <img src="<?php echo esc_url( $fbf_about_img1['url'] ); ?>" alt="<?php echo esc_attr( ! empty( $fbf_about_img1['alt'] ) ? $fbf_about_img1['alt'] : 'Floran, sportfysiotherapeut en oprichter van Fit by Floran' ); ?>"<?php echo fbf_img_attrs( $fbf_about_img1 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
      <img src="<?php echo esc_url( $fbf_about_img2['url'] ); ?>" alt="<?php echo esc_attr( ! empty( $fbf_about_img2['alt'] ) ? $fbf_about_img2['alt'] : 'Floran begeleidt een sporter op het veld' ); ?>"<?php echo fbf_img_attrs( $fbf_about_img2 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
    </div>
    <div class="copy">
      <div class="kicker"><?php echo esc_html( fbf_field( 'about_kicker', 'Over Floran' ) ); ?></div>
      <h2><?php echo esc_html( fbf_field( 'about_titel', 'Jouw partner in herstel én topprestaties.' ) ); ?></h2>
      <?php
      foreach ( fbf_about_alineas() as $fbf_p ) :
      ?>
        <p><?php echo esc_html( $fbf_p ); ?></p>
      <?php endforeach; ?>
      <a class="btn btn-gold" href="<?php echo esc_url( fbf_field( 'about_knop_link', '#contact' ) ); ?>"><?php echo esc_html( fbf_field( 'about_knop_tekst', 'Plan een kennismaking' ) ); ?></a>
    </div>
  </div>
</section>

<section id="aanpak" class="cream">
  <div class="container">
    <div class="kicker"><?php echo esc_html( fbf_field( 'aanpak_kicker', 'Mijn aanpak' ) ); ?></div>
    <h2><?php echo esc_html( fbf_field( 'aanpak_titel', 'Van analyse naar maximale prestaties.' ) ); ?></h2>
    <p class="lead"><?php echo esc_html( fbf_field( 'aanpak_intro', 'Succesvol herstellen begint met inzicht. Iedere samenwerking volgt een gestructureerd traject, gericht op duurzame vooruitgang.' ) ); ?></p>
    <div class="steps">
      <?php
      $fbf_stappen = fbf_aanpak_stappen();
      foreach ( $fbf_stappen as $fbf_stap ) :
      ?>
      <div class="step">
        <div class="num"><?php echo esc_html( $fbf_stap['label'] ); ?></div>
        <h3><?php echo esc_html( $fbf_stap['titel'] ); ?></h3>
        <p><?php echo esc_html( $fbf_stap['tekst'] ); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section id="diensten">
  <div class="container">
    <div class="kicker"><?php echo esc_html( fbf_field( 'diensten_kicker', 'Trajecten & memberships' ) ); ?></div>
    <h2><?php echo esc_html( fbf_field( 'diensten_titel', 'Kies de begeleiding die bij jouw ambitie past.' ) ); ?></h2>
    <p class="lead"><?php echo esc_html( fbf_field( 'diensten_intro', 'Van gericht herstel tot intensieve één-op-één performancebegeleiding. Vier niveaus, één uitgangspunt: duurzaam beter presteren.' ) ); ?></p>
    <?php if ( $fbf_prijzen ) : ?>
    <div class="services">
      <?php foreach ( $fbf_prijzen as $fbf_dienst ) :
        $fbf_featured = ! empty( $fbf_dienst['uitgelicht'] );
      ?>
      <article class="service<?php echo $fbf_featured ? ' featured' : ''; ?>">
        <?php if ( $fbf_featured && ! empty( $fbf_dienst['badge_tekst'] ) ) : ?>
          <span class="badge"><?php echo esc_html( $fbf_dienst['badge_tekst'] ); ?></span>
        <?php endif; ?>
        <h3><?php echo esc_html( $fbf_dienst['titel'] ); ?></h3>
        <p><?php echo esc_html( $fbf_dienst['beschrijving'] ); ?></p>
        <div class="from"><?php echo esc_html( $fbf_dienst['vanaf_label'] ); ?></div>
        <div class="price"><?php echo esc_html( $fbf_dienst['prijs'] ); ?><?php if ( ! empty( $fbf_dienst['prijs_periode'] ) ) : ?> <span class="per"><?php echo esc_html( $fbf_dienst['prijs_periode'] ); ?></span><?php endif; ?></div>
        <ul>
          <?php foreach ( $fbf_dienst['kenmerken'] as $fbf_kenmerk ) : ?>
            <li><?php echo esc_html( $fbf_kenmerk ); ?></li>
          <?php endforeach; ?>
        </ul>
        <?php if ( $fbf_dienst['knop_tekst'] !== '' ) : ?>
          <a class="btn <?php echo $fbf_featured ? 'btn-gold' : 'btn-outline'; ?>" href="<?php echo esc_url( $fbf_dienst['knop_link'] ?: '#contact' ); ?>" data-hulpvraag="<?php echo esc_attr( $fbf_dienst['titel'] ); ?>"><?php echo esc_html( $fbf_dienst['knop_tekst'] ); ?></a>
        <?php endif; ?>
      </article>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<section id="specialisaties" class="section-tight">
  <div class="container">
    <div class="kicker"><?php echo esc_html( fbf_field( 'special_kicker', 'Specialistische begeleiding' ) ); ?></div>
    <h2><?php echo esc_html( fbf_field( 'special_titel', 'Gericht advies wanneer jij het nodig hebt.' ) ); ?></h2>
    <div class="special">
      <?php foreach ( $fbf_specials as $fbf_special ) : ?>
      <div class="special-card">
        <h3><?php echo esc_html( $fbf_special['titel'] ); ?></h3>
        <p class="muted"><?php echo esc_html( $fbf_special['tekst'] ); ?></p>
        <?php if ( ! empty( $fbf_special['knop_tekst'] ) ) : ?>
          <a class="btn btn-outline" href="<?php echo esc_url( $fbf_special['knop_link'] ?: '#contact' ); ?>" data-hulpvraag="<?php echo esc_attr( $fbf_special['titel'] ); ?>"><?php echo esc_html( $fbf_special['knop_tekst'] ); ?></a>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section id="resultaten" class="cream">
  <div class="container second">
    <div>
      <div class="kicker"><?php echo esc_html( fbf_field( 'resultaten_kicker', 'Voor iedere fase' ) ); ?></div>
      <h2><?php echo esc_html( fbf_field( 'resultaten_titel', 'Van herstel naar volledige performance.' ) ); ?></h2>
      <p class="lead"><?php echo esc_html( fbf_field( 'resultaten_tekst', 'Of je nu op nationaal of internationaal niveau actief bent, een ambitieuze recreatieve sporter bent of behoefte hebt aan een onafhankelijke second opinion: de begeleiding wordt afgestemd op jouw situatie, sport en ambitie.' ) ); ?></p>
    </div>
    <img src="<?php echo esc_url( $fbf_second_img['url'] ); ?>" alt="<?php echo esc_attr( ! empty( $fbf_second_img['alt'] ) ? $fbf_second_img['alt'] : 'Sportfysiotherapie en performancebegeleiding bij Fit by Floran' ); ?>"<?php echo fbf_img_attrs( $fbf_second_img ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
  </div>
</section>

<section id="partners" class="partners">
  <div class="container">
    <div class="kicker"><?php echo esc_html( fbf_field( 'partners_kicker', 'Samenwerkingen' ) ); ?></div>
    <h2><?php echo esc_html( fbf_field( 'partners_titel', 'Sterke prestaties bouw je samen.' ) ); ?></h2>
    <p class="lead"><?php echo esc_html( fbf_field( 'partners_intro', 'Met trots werk ik samen met professionals en organisaties die kwaliteit, ontwikkeling en prestaties centraal stellen.' ) ); ?></p>
    <div class="partner-grid">
      <?php foreach ( $fbf_partners as $fbf_partner ) :
        $fbf_partner_url = ! empty( $fbf_partner['url'] ) ? $fbf_partner['url'] : '';
        $fbf_partner_tag = $fbf_partner_url ? 'a' : 'div';
      ?>
      <<?php echo $fbf_partner_tag; ?> class="partner-logo<?php echo ! empty( $fbf_partner['logo']['url'] ) ? ' partner-logo--logo' : ''; ?>"<?php if ( $fbf_partner_url ) : ?> href="<?php echo esc_url( $fbf_partner_url ); ?>" target="_blank" rel="noopener noreferrer"<?php endif; ?>>
        <?php if ( ! empty( $fbf_partner['logo']['url'] ) ) : ?>
          <img src="<?php echo esc_url( $fbf_partner['logo']['url'] ); ?>" alt="<?php echo esc_attr( $fbf_partner['naam'] ); ?>"<?php echo fbf_img_attrs( $fbf_partner['logo'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
        <?php else : ?>
          <span class="partner-initial"><?php echo esc_html( $fbf_partner['initialen'] ); ?></span>
        <?php endif; ?>
        <span><?php echo esc_html( $fbf_partner['naam'] ); ?></span>
      </<?php echo $fbf_partner_tag; ?>>
      <?php endforeach; ?>
    </div>
    <p class="partner-note"><?php echo esc_html( fbf_field( 'partners_note', 'Klik op een partnerlogo om de website van de organisatie te bezoeken.' ) ); ?></p>
  </div>
</section>

<section id="contact" class="intake">
  <div class="container intake__grid">

    <div class="intake__intro">
      <div class="kicker"><?php echo esc_html( fbf_field( 'contact_kicker', 'Jouw volgende stap' ) ); ?></div>
      <h2><?php echo esc_html( fbf_field( 'contact_titel', 'Klaar om het maximale uit jezelf te halen?' ) ); ?></h2>
      <p class="lead"><?php echo esc_html( fbf_field( 'contact_intro', 'Of jouw doel nu herstel, blessurepreventie of topprestaties is: samen bouwen we aan een lichaam dat klaar is voor de volgende stap.' ) ); ?></p>
      <?php $fbf_punten = fbf_intake_punten(); ?>
      <?php if ( $fbf_punten ) : ?>
      <ul class="intake__punten">
        <?php foreach ( $fbf_punten as $fbf_punt ) : ?>
          <li><svg class="icoon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m5 12.5 4.5 4.5L19 7.5"/></svg><span><?php echo esc_html( $fbf_punt ); ?></span></li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </div>

    <div class="intake__form">
      <?php if ( $fbf_contact_status === 'verzonden' ) : ?>
        <p class="contact-form__notice contact-form__notice--ok" role="status">Bedankt! Je aanvraag is verstuurd. Ik neem zo snel mogelijk contact met je op.</p>
      <?php elseif ( $fbf_contact_status === 'fout' ) : ?>
        <p class="contact-form__notice contact-form__notice--err" role="alert">Je aanvraag kon niet worden verstuurd. Vul je naam, een geldig e-mailadres en een keuze of toelichting in, of stuur een WhatsApp.</p>
      <?php endif; ?>

      <form class="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-whatsapp="<?php echo esc_url( $fbf_wa_url ); ?>">
        <div class="contact-form__head">
          <h3><?php echo esc_html( fbf_field( 'formulier_titel', 'Plan je gratis intake' ) ); ?></h3>
          <p><?php echo esc_html( fbf_field( 'formulier_tekst', 'Binnen een minuut ingevuld. Ik neem daarna persoonlijk contact met je op.' ) ); ?></p>
        </div>
        <input type="hidden" name="action" value="fbf_contact">
        <?php wp_nonce_field( 'fbf_contact', 'fbf_contact_nonce' ); ?>
        <?php echo fbf_spam_token_field(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
        <div class="contact-form__honeypot" aria-hidden="true">
          <label for="fbf_website">Website</label>
          <input type="text" name="fbf_website" id="fbf_website" tabindex="-1" autocomplete="off">
        </div>
        <div class="contact-form__row">
          <div class="contact-form__field">
            <label for="fbf_naam">Naam</label>
            <input type="text" id="fbf_naam" name="fbf_naam" required autocomplete="name" placeholder="Je voor- en achternaam">
          </div>
          <div class="contact-form__field">
            <label for="fbf_email">E-mailadres</label>
            <input type="email" id="fbf_email" name="fbf_email" required autocomplete="email" inputmode="email" placeholder="naam@voorbeeld.nl">
          </div>
        </div>
        <div class="contact-form__row">
          <div class="contact-form__field">
            <label for="fbf_telefoon">Telefoon <span>(optioneel)</span></label>
            <input type="tel" id="fbf_telefoon" name="fbf_telefoon" autocomplete="tel" inputmode="tel" placeholder="06 12345678">
          </div>
          <div class="contact-form__field">
            <label for="fbf_hulpvraag">Waar kan ik je mee helpen?</label>
            <select id="fbf_hulpvraag" name="fbf_hulpvraag" required>
              <option value="" disabled selected>Maak een keuze</option>
              <?php foreach ( fbf_hulpvragen() as $fbf_groep => $fbf_opties ) : ?>
                <optgroup label="<?php echo esc_attr( $fbf_groep ); ?>">
                  <?php foreach ( $fbf_opties as $fbf_optie ) : ?>
                    <option value="<?php echo esc_attr( $fbf_optie ); ?>"><?php echo esc_html( $fbf_optie ); ?></option>
                  <?php endforeach; ?>
                </optgroup>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="contact-form__field">
          <label for="fbf_bericht">Toelichting <span>(optioneel)</span></label>
          <textarea id="fbf_bericht" name="fbf_bericht" rows="3" placeholder="Bijv. je sport, je niveau en waar je tegenaan loopt"></textarea>
        </div>
        <div class="contact-form__submit">
          <button class="btn btn-gold" type="submit"><?php echo esc_html( fbf_field( 'formulier_knop', 'Verstuur intake-aanvraag' ) ); ?></button>
          <p class="contact-form__privacy"><?php echo esc_html( fbf_field( 'formulier_privacy', 'Je gegevens gebruik ik alleen om contact met je op te nemen over je aanvraag.' ) ); ?></p>
        </div>
      </form>
    </div>

    <div class="intake__direct">
      <span class="intake__direct-titel"><?php echo esc_html( fbf_field( 'direct_titel', 'Liever direct contact?' ) ); ?></span>
      <div class="intake__direct-knoppen">
        <a href="<?php echo esc_url( $fbf_wa_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo fbf_icoon( 'whatsapp', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span>WhatsApp</span></a>
        <?php $fbf_intake_tel = fbf_tel_href( fbf_contact_phone() ); ?>
        <?php if ( $fbf_intake_tel ) : ?>
        <a href="<?php echo esc_url( $fbf_intake_tel ); ?>"><?php echo fbf_icoon( 'telefoon', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span>Bellen</span></a>
        <?php endif; ?>
        <a href="mailto:<?php echo esc_attr( fbf_contact_email() ); ?>"><?php echo fbf_icoon( 'mail', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span>E-mail</span></a>
      </div>
    </div>

  </div>
</section>
</main>

<?php get_footer(); ?>
