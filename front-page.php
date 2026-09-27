<?php
/**
 * Voorpagina — hero t/m contact.
 * ACF-beheerbaar (per klantwens): hero (titel/onderschrift/knoppen), het
 * "Over Floran"-blok (titel/ondertitel/knop), "Van analyse..." (titel + 4 kaarten),
 * en de prijsopgaves (los menu-item "Prijsopgaves" in het WP-admin).
 * Overige secties (specialisaties, samenwerkingen) staan vast, zoals in de
 * goedgekeurde demo, en zijn eenvoudig uit te breiden met extra ACF-velden.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

$fbf_hero_image = function_exists( 'get_field' ) ? get_field( 'hero_achtergrond' ) : false;
$fbf_hero_style = '';
if ( $fbf_hero_image && ! empty( $fbf_hero_image['url'] ) ) {
	$fbf_hero_style = ' style="background-image:linear-gradient(90deg,rgba(0,0,0,.92) 0%,rgba(0,0,0,.76) 38%,rgba(0,0,0,.18) 100%),url(' . esc_url( $fbf_hero_image['url'] ) . ');"';
}

$fbf_about_img1 = function_exists( 'get_field' ) ? get_field( 'about_afbeelding_1' ) : false;
$fbf_about_img2 = function_exists( 'get_field' ) ? get_field( 'about_afbeelding_2' ) : false;
$fbf_second_img = function_exists( 'get_field' ) ? get_field( 'tweede_sectie_afbeelding' ) : false;

$fbf_prijzen = function_exists( 'get_field' ) ? get_field( 'prijsopgaves', 'option' ) : false;
if ( ! $fbf_prijzen ) {
	$fbf_prijzen = array(
		array(
			'titel' => 'Recovery Program', 'beschrijving' => 'Voor sporters die willen herstellen én sterker terug willen keren.',
			'vanaf_label' => 'Vanaf', 'prijs' => '€495', 'prijs_periode' => '',
			'uitgelicht' => false, 'badge_tekst' => '',
			'features' => array(
				array( 'regel' => 'Uitgebreide intake & fysieke screening' ),
				array( 'regel' => 'Persoonlijk behandelplan' ),
				array( 'regel' => 'Individueel oefenprogramma' ),
				array( 'regel' => 'Hands-on behandelingen' ),
				array( 'regel' => 'Wekelijkse evaluaties' ),
				array( 'regel' => 'WhatsApp-ondersteuning' ),
				array( 'regel' => 'Return-to-Performance Assessment' ),
				array( 'regel' => 'Eindrapport met advies' ),
			),
			'knop_tekst' => 'Meer informatie', 'knop_link' => '#contact',
		),
		array(
			'titel' => 'Basic Performance Membership', 'beschrijving' => 'Structurele begeleiding voor ambitieuze sporters die continu willen blijven ontwikkelen.',
			'vanaf_label' => 'Vanaf', 'prijs' => '€149', 'prijs_periode' => 'p.m.',
			'uitgelicht' => false, 'badge_tekst' => '',
			'features' => array(
				array( 'regel' => '1 fysieke sessie per maand' ),
				array( 'regel' => 'Persoonlijk trainingsprogramma' ),
				array( 'regel' => 'Online check-in 1u per week' ),
				array( 'regel' => 'Chatondersteuning 1u per week' ),
				array( 'regel' => 'Belastingmanagement basis' ),
			),
			'knop_tekst' => 'Meer informatie', 'knop_link' => '#contact',
		),
		array(
			'titel' => 'Plus Performance Membership', 'beschrijving' => 'Meer begeleiding, meer inzicht en meer ruimte voor structurele ontwikkeling.',
			'vanaf_label' => 'Vanaf', 'prijs' => '€349', 'prijs_periode' => 'p.m.',
			'uitgelicht' => false, 'badge_tekst' => '',
			'features' => array(
				array( 'regel' => '1 fysieke sessie per maand' ),
				array( 'regel' => 'Trainingsprogramma maandelijks aanpasbaar' ),
				array( 'regel' => 'Online check-in op werkdagen' ),
				array( 'regel' => 'Chatondersteuning op werkdagen' ),
				array( 'regel' => 'Belastingmanagement plus' ),
				array( 'regel' => 'Voortgangsrapportages' ),
				array( 'regel' => 'Toegang tot de community' ),
			),
			'knop_tekst' => 'Meer informatie', 'knop_link' => '#contact',
		),
		array(
			'titel' => 'Premium High Performance Membership', 'beschrijving' => 'Exclusieve één-op-één begeleiding voor topsporters en atleten die niets aan het toeval overlaten.',
			'vanaf_label' => 'Vanaf', 'prijs' => '€449', 'prijs_periode' => 'p.m.',
			'uitgelicht' => true, 'badge_tekst' => 'HIGH PERFORMANCE',
			'features' => array(
				array( 'regel' => '2 fysieke sessies per maand' ),
				array( 'regel' => 'Prioriteit bij afspraken' ),
				array( 'regel' => 'Persoonlijk trainingsprogramma onbeperkt' ),
				array( 'regel' => 'Personal Performance Decision System' ),
				array( 'regel' => 'Onbeperkte WhatsApp-support' ),
				array( 'regel' => "Analyse van trainings- en wedstrijdvideo's" ),
				array( 'regel' => 'Wedstrijd- en weekplanning' ),
				array( 'regel' => 'Toegang tot de community' ),
				array( 'regel' => 'Uitgebreide eindrapportages' ),
			),
			'knop_tekst' => 'Plan je intake', 'knop_link' => '#contact',
		),
	);
}
?>

<main>
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
      <?php if ( $fbf_about_img1 && ! empty( $fbf_about_img1['url'] ) ) : ?>
        <img src="<?php echo esc_url( $fbf_about_img1['url'] ); ?>" alt="<?php echo esc_attr( $fbf_about_img1['alt'] ?: 'Floran' ); ?>">
      <?php else : ?>
        <div class="img-ph">Foto (via ACF: About afbeelding 1)</div>
      <?php endif; ?>
      <?php if ( $fbf_about_img2 && ! empty( $fbf_about_img2['url'] ) ) : ?>
        <img src="<?php echo esc_url( $fbf_about_img2['url'] ); ?>" alt="<?php echo esc_attr( $fbf_about_img2['alt'] ?: 'Floran' ); ?>">
      <?php else : ?>
        <div class="img-ph">Foto (via ACF: About afbeelding 2)</div>
      <?php endif; ?>
    </div>
    <div class="copy">
      <div class="kicker"><?php echo esc_html( fbf_field( 'about_kicker', 'Over Floran' ) ); ?></div>
      <h2><?php echo esc_html( fbf_field( 'about_titel', 'Jouw partner in herstel én topprestaties.' ) ); ?></h2>
      <?php
      $fbf_about_tekst = fbf_field( 'about_tekst', "Mijn naam is Floran, oprichter van Fit by Floran – High Performance Physiotherapy. Sport heeft altijd centraal gestaan in mijn leven. Juist daardoor weet ik hoe belangrijk het is om volledig op je lichaam te kunnen vertrouwen.\n\nEen blessure is zelden alleen een fysieke beperking. Het beïnvloedt je prestaties, je zelfvertrouwen en het plezier waarmee je sport. Mijn missie is daarom om sporters niet alleen klachtenvrij te maken, maar sterker terug te laten komen dan voorheen.\n\nIk kijk verder dan de pijnklacht alleen. Ik analyseer hoe jouw lichaam beweegt, wordt belast en optimaal kan presteren. Op basis daarvan ontwikkelen we samen een persoonlijk plan dat aansluit op jouw sport, niveau en ambities.\n\nGeen standaardprotocollen, maar maatwerk waarin wetenschappelijke inzichten, klinische expertise en persoonlijke begeleiding samenkomen." );
      foreach ( explode( "\n\n", $fbf_about_tekst ) as $fbf_p ) :
        if ( trim( $fbf_p ) === '' ) { continue; }
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
      $fbf_stappen = function_exists( 'get_field' ) ? get_field( 'aanpak_stappen' ) : false;
      if ( ! $fbf_stappen ) {
        $fbf_stappen = array(
          array( 'label' => '01 · ANALYSE', 'titel' => 'Inzicht', 'tekst' => 'Uitgebreide intake en performance screening van mobiliteit, kracht, belastbaarheid, blessuregeschiedenis en sportdoelen.' ),
          array( 'label' => '02 · HERSTEL', 'titel' => 'Belastbaarheid', 'tekst' => 'Gericht herstel met aandacht voor pijn, functie, kracht en het opnieuw opbouwen van vertrouwen in je lichaam.' ),
          array( 'label' => '03 · PREVENTIE', 'titel' => 'Behouden', 'tekst' => 'Gerichte training, monitoring en slim belastingmanagement om terugkerende klachten te helpen voorkomen.' ),
          array( 'label' => '04 · PERFORMANCE', 'titel' => 'Presteren', 'tekst' => 'Van klachtenvrij naar sterker, sneller en beter voorbereid op de eisen van jouw sport.' ),
        );
      }
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
          <?php foreach ( (array) $fbf_dienst['features'] as $fbf_feature ) : ?>
            <li><?php echo esc_html( $fbf_feature['regel'] ); ?></li>
          <?php endforeach; ?>
        </ul>
        <a class="btn <?php echo $fbf_featured ? 'btn-gold' : 'btn-outline'; ?>" href="<?php echo esc_url( $fbf_dienst['knop_link'] ); ?>"><?php echo esc_html( $fbf_dienst['knop_tekst'] ); ?></a>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section id="specialisaties" style="padding-top:25px">
  <div class="container">
    <div class="kicker">Specialistische begeleiding</div>
    <h2>Gericht advies wanneer jij het nodig hebt.</h2>
    <div class="special">
      <div class="special-card">
        <h3>Second Opinion</h3>
        <p class="muted">Twijfel je over een diagnose of behandelplan? We bekijken jouw situatie objectief en vertalen dit naar een helder advies.</p>
        <a class="btn btn-outline" href="#contact">Plan second opinion</a>
      </div>
      <div class="special-card">
        <h3>Performance Screening</h3>
        <p class="muted">Krijg inzicht in je huidige fysieke capaciteit, aandachtspunten en de volgende stap richting jouw prestatiedoel.</p>
      </div>
      <div class="special-card">
        <h3>Return-to-Sport &amp; Running</h3>
        <p class="muted">Van sportspecifieke screening en running analysis tot videoanalyse en return-to-performance testing.</p>
      </div>
    </div>
  </div>
</section>

<section class="cream">
  <div class="container second">
    <div>
      <div class="kicker">Voor iedere fase</div>
      <h2>Van herstel naar volledige performance.</h2>
      <p class="lead">Of je nu op nationaal of internationaal niveau actief bent, een ambitieuze recreatieve sporter bent of behoefte hebt aan een onafhankelijke second opinion: de begeleiding wordt afgestemd op jouw situatie, sport en ambitie.</p>
    </div>
    <?php if ( $fbf_second_img && ! empty( $fbf_second_img['url'] ) ) : ?>
      <img src="<?php echo esc_url( $fbf_second_img['url'] ); ?>" alt="<?php echo esc_attr( $fbf_second_img['alt'] ?: 'Fit by Floran' ); ?>">
    <?php else : ?>
      <div class="img-ph" style="height:500px;">Foto (via ACF: Tweede-sectie afbeelding)</div>
    <?php endif; ?>
  </div>
</section>

<section id="partners" class="partners">
  <div class="container">
    <div class="kicker">Samenwerkingen</div>
    <h2>Strong performance is built together.</h2>
    <p class="lead">Met trots werk ik samen met professionals en organisaties die kwaliteit, ontwikkeling en prestaties centraal stellen.</p>
    <div class="partner-grid">
      <a class="partner-logo" href="https://www.evolvephysio.uk/" target="_blank" rel="noopener"><span class="partner-initial">EP</span><span>EVOLVE PHYSIO</span></a>
      <a class="partner-logo" href="https://www.knapman.nl/" target="_blank" rel="noopener"><span class="partner-initial">K</span><span>KNAP'MAN</span></a>
      <a class="partner-logo" href="https://statsports.com/" target="_blank" rel="noopener"><span class="partner-initial">SS</span><span>STATSPORTS</span></a>
      <a class="partner-logo" href="https://www.fransbosch.systems/" target="_blank" rel="noopener"><span class="partner-initial">FBS</span><span>FRANS BOSCH SYSTEMS</span></a>
      <a class="partner-logo" href="https://mbsportpsychologie.nl/" target="_blank" rel="noopener"><span class="partner-initial">MB</span><span>MB SPORTPSYCHOLOGIE</span></a>
    </div>
    <p class="partner-note">Klik op een partnerlogo om de website van de organisatie te bezoeken.</p>
  </div>
</section>

<section id="contact" class="cta">
  <div class="container">
    <div class="kicker">Jouw volgende stap</div>
    <h2>Klaar om het maximale uit jezelf te halen?</h2>
    <p class="lead">Of jouw doel nu herstel, blessurepreventie of topprestaties is: samen bouwen we aan een lichaam dat klaar is voor de volgende stap.</p>
    <div class="actions" style="justify-content:center">
      <a class="btn btn-gold" href="mailto:<?php echo esc_attr( function_exists('get_field') ? ( get_field('contact_email','option') ?: 'fitbyfloran@hotmail.com' ) : 'fitbyfloran@hotmail.com' ); ?>">Plan vandaag je gratis intake</a>
      <a class="btn btn-outline" href="https://wa.me/<?php echo esc_attr( function_exists('get_field') ? ( preg_replace('/[^0-9]/','', get_field('whatsapp_nummer','option') ?: '31634280140') ) : '31634280140' ); ?>">WhatsApp</a>
    </div>
  </div>
</section>
</main>

<?php get_footer(); ?>
