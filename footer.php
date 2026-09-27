<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$fbf_wa_number  = function_exists( 'get_field' ) ? get_field( 'whatsapp_nummer', 'option' ) : '';
$fbf_wa_number  = $fbf_wa_number ? preg_replace( '/[^0-9]/', '', $fbf_wa_number ) : '31634280140';
$fbf_wa_message = function_exists( 'get_field' ) ? get_field( 'whatsapp_bericht', 'option' ) : '';
$fbf_wa_message = $fbf_wa_message ?: 'Hallo, ik wil graag een gratis intake plannen';
$fbf_wa_url     = 'https://wa.me/' . $fbf_wa_number . '?text=' . rawurlencode( $fbf_wa_message );
$fbf_email      = function_exists( 'get_field' ) ? get_field( 'contact_email', 'option' ) : '';
$fbf_email      = $fbf_email ?: 'fitbyfloran@hotmail.com';
$fbf_telefoon   = function_exists( 'get_field' ) ? get_field( 'contact_telefoon', 'option' ) : '';
$fbf_telefoon   = $fbf_telefoon ?: '06 3428 0140';
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
        <div class="muted"><?php echo esc_html( $fbf_email ); ?><br><?php echo esc_html( $fbf_telefoon ); ?></div>
        <div class="social">
          <a href="#" aria-label="Instagram">&#9673;</a>
          <a href="#" aria-label="LinkedIn">in</a>
        </div>
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
      <span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> Fit by Floran &ndash; High Performance Physiotherapy</span>
      <span>Meer dan herstellen. Presteren op je hoogste niveau.</span>
    </div>
  </div>
</footer>

<a class="whatsapp" href="<?php echo esc_url( $fbf_wa_url ); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
  <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
    <path d="M12 3a9 9 0 0 0-7.8 13.5L3 21l4.7-1.2A9 9 0 1 0 12 3z"></path>
    <path d="M8.5 9.5c0 3.5 2.5 6 6 6" stroke-width="1.6"></path>
  </svg>
</a>

<?php wp_footer(); ?>
</body>
</html>
