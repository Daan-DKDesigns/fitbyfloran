<?php
/**
 * Voorpagina template — hero t/m CTA.
 *
 * Elk stukje zichtbare tekst en de hero-afbeelding komen uit ACF via fbf_field()
 * of get_field(), met een hardcoded fallback als er nog geen ACF-veld is ingevuld.
 * Zo blijft de pagina er altijd goed uitzien, ook voordat Floran iets heeft aangepast.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$fbf_hero_gebruik_foto = function_exists( 'get_field' ) ? (bool) get_field( 'hero_gebruik_foto' ) : false;
$fbf_hero_image        = function_exists( 'get_field' ) ? get_field( 'hero_afbeelding' ) : false;
$fbf_toon_foto          = $fbf_hero_gebruik_foto && $fbf_hero_image && ! empty( $fbf_hero_image['url'] );
?>

<header class="hero">
  <div class="hero-grid"></div>
  <div class="wrap hero-inner">
    <div>
      <div class="eyebrow"><?php echo esc_html( fbf_field( 'hero_eyebrow', 'Sportfysiotherapie voor topsport' ) ); ?></div>
      <h1>
        <?php echo esc_html( fbf_field( 'hero_titel_regel1', 'Terug op het veld.' ) ); ?><br>
        <em><?php echo esc_html( fbf_field( 'hero_titel_regel2', 'Sterker dan ervoor.' ) ); ?></em>
      </h1>
      <p><?php echo esc_html( fbf_field( 'hero_tekst', 'Fysiotherapie voor professionele voetballers en topsporters — van diagnose tot return-to-play, op het niveau dat de eredivisie van je vraagt.' ) ); ?></p>
      <div class="hero-cta">
        <a href="<?php echo esc_url( fbf_field( 'hero_knop1_link', '#contact' ) ); ?>" class="btn"><?php echo esc_html( fbf_field( 'hero_knop1_tekst', 'Plan een intake' ) ); ?></a>
        <a href="<?php echo esc_url( fbf_field( 'hero_knop2_link', '#aanpak' ) ); ?>" class="btn btn-ghost"><?php echo esc_html( fbf_field( 'hero_knop2_tekst', 'Bekijk de aanpak' ) ); ?></a>
      </div>
    </div>

    <?php if ( $fbf_toon_foto ) : ?>
      <div class="hero-figure">
        <img src="<?php echo esc_url( $fbf_hero_image['url'] ); ?>" alt="<?php echo esc_attr( $fbf_hero_image['alt'] ); ?>">
      </div>
    <?php else : ?>
      <div class="hero-figure" aria-hidden="true">
        <svg viewBox="0 0 320 460" width="100%" height="100%" style="overflow:visible;">
          <circle cx="168" cy="46" r="20" fill="none" stroke="var(--text-dim)" stroke-width="1.5"/>
          <line x1="168" y1="66" x2="150" y2="150" stroke="var(--text-dim)" stroke-width="1.5"/>
          <line x1="168" y1="66" x2="196" y2="140" stroke="var(--text-dim)" stroke-width="1.5"/>
          <line x1="150" y1="150" x2="160" y2="240" stroke="var(--mint-text)" stroke-width="1.5"/>
          <line x1="196" y1="140" x2="150" y2="230" stroke="var(--text-dim)" stroke-width="1.5"/>
          <line x1="160" y1="240" x2="140" y2="330" stroke="var(--mint-text)" stroke-width="1.5"/>
          <line x1="150" y1="230" x2="230" y2="290" stroke="var(--text-dim)" stroke-width="1.5"/>
          <line x1="140" y1="330" x2="200" y2="380" stroke="var(--coral-text)" stroke-width="2.2"/>
          <circle cx="168" cy="66" r="4" fill="var(--text-dim)"/>
          <circle cx="150" cy="150" r="4" fill="var(--mint-text)"/>
          <circle cx="196" cy="140" r="4" fill="var(--text-dim)"/>
          <circle cx="160" cy="240" r="4" fill="var(--mint-text)"/>
          <circle cx="150" cy="230" r="4" fill="var(--text-dim)"/>
          <circle cx="140" cy="330" r="4" fill="var(--mint-text)"/>
          <circle cx="200" cy="380" r="5" fill="var(--coral-text)"/>
        </svg>
        <div class="scanline"></div>
        <div class="datatag d1 mono">ROM knie · 128°</div>
        <div class="datatag d2 mono">Belasting · 74%</div>
        <div class="datatag d3 mono">HR · 142 bpm</div>
        <div class="datatag d4 mono">Symmetrie · 96%</div>
      </div>
    <?php endif; ?>
  </div>
</header>

<div class="trust">
  <div class="wrap">
    <?php
    $fbf_trust = function_exists( 'get_field' ) ? get_field( 'vertrouwen_items' ) : false;
    if ( ! $fbf_trust ) {
      $fbf_trust = array(
        array( 'tekst' => 'Werkt samen met clubs op eredivisieniveau' ),
        array( 'tekst' => 'Gecertificeerd sportfysiotherapeut' ),
        array( 'tekst' => 'Sportmedische begeleiding op locatie' ),
        array( 'tekst' => '20+ jaar ervaring in topsport' ),
      );
    }
    foreach ( $fbf_trust as $fbf_item ) :
    ?>
    <div class="trust-item"><?php echo esc_html( $fbf_item['tekst'] ); ?></div>
    <?php endforeach; ?>
  </div>
</div>

<section id="diensten">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow"><?php echo esc_html( fbf_field( 'diensten_eyebrow', 'Diensten' ) ); ?></div>
      <h2><?php echo esc_html( fbf_field( 'diensten_titel', 'Eén doel: veilig en snel presteren' ) ); ?></h2>
      <p><?php echo esc_html( fbf_field( 'diensten_intro', 'Elke behandeling is gebouwd rond de belasting die topsport vraagt — niet rond een gemiddeld herstelschema.' ) ); ?></p>
    </div>
  </div>
  <div class="wrap">
    <div class="services reveal">
      <?php
      $fbf_diensten = function_exists( 'get_field' ) ? get_field( 'diensten' ) : false;
      if ( ! $fbf_diensten ) {
        $fbf_diensten = array(
          array( 'titel' => 'Blessurebehandeling', 'tekst' => 'Snelle, precieze diagnose van sportgerelateerde blessures, direct vertaald naar een behandelplan.' ),
          array( 'titel' => 'Return-to-play', 'tekst' => 'Gefaseerde opbouw terug naar wedstrijdbelasting, met meetbare mijlpalen per fase.' ),
          array( 'titel' => 'Performance & preventie', 'tekst' => 'Bewegingsanalyse en krachttraining om herhaling van blessures voor te blijven.' ),
          array( 'titel' => 'Wedstrijdbegeleiding', 'tekst' => 'Fysio aan de zijlijn en op uitwedstrijden, aangesloten op de medische staf van de club.' ),
        );
      }
      foreach ( $fbf_diensten as $fbf_i => $fbf_dienst ) :
      ?>
      <div class="service">
        <div class="num mono"><?php echo esc_html( str_pad( $fbf_i + 1, 2, '0', STR_PAD_LEFT ) ); ?></div>
        <h3><?php echo esc_html( $fbf_dienst['titel'] ); ?></h3>
        <p><?php echo esc_html( $fbf_dienst['tekst'] ); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="process" id="aanpak">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow"><?php echo esc_html( fbf_field( 'werkwijze_eyebrow', 'Werkwijze' ) ); ?></div>
      <h2><?php echo esc_html( fbf_field( 'werkwijze_titel', 'Vier fases, één trajectplan' ) ); ?></h2>
    </div>
    <div class="steps reveal">
      <?php
      $fbf_stappen = function_exists( 'get_field' ) ? get_field( 'werkwijze_stappen' ) : false;
      if ( ! $fbf_stappen ) {
        $fbf_stappen = array(
          array( 'titel' => 'Intake & analyse', 'tekst' => 'Bewegingsanalyse en belastingsonderzoek om de kern van de blessure te vinden.' ),
          array( 'titel' => 'Behandelplan', 'tekst' => 'Een trajectplan op maat, afgestemd op positie, seizoen en wedstrijdkalender.' ),
          array( 'titel' => 'Revalidatie', 'tekst' => 'Gefaseerde opbouw van belasting, met wekelijkse meetmomenten.' ),
          array( 'titel' => 'Return to play', 'tekst' => 'Terugkeer naar het veld, met nazorg om herval te voorkomen.' ),
        );
      }
      foreach ( $fbf_stappen as $fbf_i => $fbf_stap ) :
      ?>
      <div class="step">
        <div class="num"><?php echo esc_html( str_pad( $fbf_i + 1, 2, '0', STR_PAD_LEFT ) ); ?></div>
        <h3><?php echo esc_html( $fbf_stap['titel'] ); ?></h3>
        <p><?php echo esc_html( $fbf_stap['tekst'] ); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section id="resultaten">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow"><?php echo esc_html( fbf_field( 'resultaten_eyebrow', 'Resultaten' ) ); ?></div>
      <h2><?php echo esc_html( fbf_field( 'resultaten_titel', 'Cijfers uit de praktijk' ) ); ?></h2>
    </div>
    <div class="stats reveal">
      <?php
      $fbf_cijfers = function_exists( 'get_field' ) ? get_field( 'praktijkcijfers' ) : false;
      if ( ! $fbf_cijfers ) {
        $fbf_cijfers = array(
          array( 'waarde' => '340+', 'label' => 'Profsporters begeleid' ),
          array( 'waarde' => '6,2 wk', 'label' => 'Gem. return-to-play, hamstringblessure' ),
          array( 'waarde' => '98%', 'label' => 'Hervat op oorspronkelijk niveau' ),
        );
      }
      foreach ( $fbf_cijfers as $fbf_cijfer ) :
      ?>
      <div class="stat">
        <div class="value"><?php echo esc_html( $fbf_cijfer['waarde'] ); ?></div>
        <div class="label"><?php echo esc_html( $fbf_cijfer['label'] ); ?></div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php if ( ! function_exists( 'get_field' ) || ! get_field( 'praktijkcijfers' ) ) : ?>
    <div class="stats-note">Voorbeeldcijfers voor dit ontwerp — te vervangen door de echte praktijkresultaten van de klant.</div>
    <?php endif; ?>
  </div>
</section>

<section class="quote">
  <div class="wrap">
    <blockquote class="reveal">"<?php echo esc_html( fbf_field( 'quote_tekst', 'Bij een blessure wil je maar één ding: zo snel én zo veilig mogelijk terug op het veld. Die balans vinden we hier elke keer weer.' ) ); ?>"</blockquote>
    <cite>— <?php echo esc_html( fbf_field( 'quote_bron', 'Medische staf, eredivisieclub (illustratief citaat)' ) ); ?></cite>
  </div>
</section>

<section class="cta-final" id="contact">
  <div class="wrap cta-inner reveal">
    <h2><?php echo esc_html( fbf_field( 'cta_titel', 'Klaar voor herstel op topsportniveau?' ) ); ?></h2>
    <div class="cta-side">
      <a href="<?php echo esc_url( fbf_field( 'cta_knop1_link', '#contact' ) ); ?>" class="btn"><?php echo esc_html( fbf_field( 'cta_knop1_tekst', 'Plan een intake' ) ); ?></a>
      <a href="<?php echo esc_url( fbf_field( 'cta_knop2_link', '#' ) ); ?>" class="btn btn-ghost"><?php echo esc_html( fbf_field( 'cta_knop2_tekst', 'Bel de praktijk' ) ); ?></a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
