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
        <div class="footer-contact muted">
          <a href="mailto:<?php echo esc_attr( $fbf_email ); ?>"><?php echo esc_html( $fbf_email ); ?></a>
          <?php if ( $fbf_tel ) : ?>
            <a href="<?php echo esc_url( $fbf_tel ); ?>"><?php echo esc_html( $fbf_telefoon ); ?></a>
          <?php else : ?>
            <span><?php echo esc_html( $fbf_telefoon ); ?></span>
          <?php endif; ?>
        </div>
        <?php if ( $fbf_instagram || $fbf_linkedin ) : ?>
        <div class="social">
          <?php if ( $fbf_instagram ) : ?>
            <a href="<?php echo esc_url( $fbf_instagram ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">&#9673;</a>
          <?php endif; ?>
          <?php if ( $fbf_linkedin ) : ?>
            <a href="<?php echo esc_url( $fbf_linkedin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">in</a>
          <?php endif; ?>
        </div>
        <?php endif; ?>
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
    </div>
  </div>
</footer>

<a class="whatsapp" href="<?php echo esc_url( $fbf_wa_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
  <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
    <path d="M12 3a9 9 0 0 0-7.8 13.5L3 21l4.7-1.2A9 9 0 1 0 12 3z"></path>
    <path d="M8.5 9.5c0 3.5 2.5 6 6 6" stroke-width="1.6"></path>
  </svg>
</a>

<?php wp_footer(); ?>
</body>
</html>
