<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$fbf_email      = fbf_contact_email();
$fbf_telefoon   = fbf_contact_phone();
$fbf_tel        = fbf_tel_href( $fbf_telefoon );
$fbf_wa_url     = fbf_whatsapp_url();
$fbf_instagram  = fbf_field( 'instagram_url', '', 'option' );
$fbf_linkedin   = fbf_field( 'linkedin_url', '', 'option' );
?>

<footer>
  <div class="container">
    <div class="footer-top">
      <div>
        <?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
          <span class="logo-text">Fit by Floran<span>.</span></span>
        <?php endif; ?>
        <p class="muted" style="margin-top:14px;">Fit by Floran &ndash; High Performance Physiotherapy</p>
      </div>
      <div>
        <h4>Contact</h4>
        <ul class="footer-contact">
          <?php if ( $fbf_email ) : ?>
          <li><a href="mailto:<?php echo esc_attr( $fbf_email ); ?>"><?php echo fbf_icoon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php echo esc_html( $fbf_email ); ?></span></a></li>
          <?php endif; ?>
          <?php if ( $fbf_telefoon ) : ?>
          <li><a href="<?php echo esc_url( $fbf_tel ); ?>"><?php echo fbf_icoon( 'telefoon' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php echo esc_html( $fbf_telefoon ); ?></span></a></li>
          <?php endif; ?>
          <li><a href="<?php echo esc_url( $fbf_wa_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo fbf_icoon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span>Stuur een WhatsApp</span></a></li>
          <?php if ( $fbf_instagram ) : ?>
          <li><a href="<?php echo esc_url( $fbf_instagram ); ?>" target="_blank" rel="noopener noreferrer"><?php echo fbf_icoon( 'instagram' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span>Instagram</span></a></li>
          <?php endif; ?>
          <?php if ( $fbf_linkedin ) : ?>
          <li><a href="<?php echo esc_url( $fbf_linkedin ); ?>" target="_blank" rel="noopener noreferrer"><?php echo fbf_icoon( 'linkedin' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span>LinkedIn</span></a></li>
          <?php endif; ?>
        </ul>
      </div>
      <div>
        <h4>Informatie</h4>
        <div class="muted">
          <a href="<?php echo esc_url( home_url( '/privacyverklaring' ) ); ?>">Privacyverklaring</a><br>
          <a href="<?php echo esc_url( home_url( '/algemene-voorwaarden' ) ); ?>">Algemene voorwaarden</a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> Fit by Floran &ndash; High Performance Physiotherapy</span>
      <span>Meer dan herstellen. Presteren op je hoogste niveau.</span>
      <span class="footer-credit">Website: <a href="https://dkdesigns.nl/" target="_blank" rel="noopener">DKDesigns</a></span>
    </div>
  </div>
</footer>

<a class="whatsapp" href="<?php echo esc_url( $fbf_wa_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Stuur Floran een WhatsApp-bericht">
  <?php echo fbf_icoon( 'whatsapp', 28 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
  <span class="whatsapp__label"><?php echo esc_html( fbf_field( 'whatsapp_knoptekst', 'Vragen? App me', 'option' ) ); ?></span>
</a>

<?php wp_footer(); ?>
</body>
</html>
