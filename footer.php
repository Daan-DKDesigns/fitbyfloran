<?php
/**
 * De footer voor het thema.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<footer>
  <div class="wrap foot-inner">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
      <?php get_template_part( 'template-parts/logo-icon', null, array( 'size' => 22 ) ); ?>
      <div class="logo-text" style="font-size:16px;">Fit by Floran<span>.</span></div>
    </a>

    <?php
    wp_nav_menu( array(
      'theme_location' => 'primary',
      'container'      => false,
      'items_wrap'     => '<ul>%3$s</ul>',
      'fallback_cb'    => 'fbf_default_menu_footer',
    ) );
    ?>

    <div class="copyright">© <?php echo esc_html( date( 'Y' ) ); ?> Fit by Floran — alle rechten voorbehouden</div>
  </div>
</footer>

<?php
$fbf_wa_number  = fbf_get_whatsapp_number();
$fbf_wa_message = fbf_get_whatsapp_message();
$fbf_wa_url     = 'https://wa.me/' . $fbf_wa_number . '?text=' . rawurlencode( $fbf_wa_message );
?>
<a class="whatsapp-fab" href="<?php echo esc_url( $fbf_wa_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Neem contact op via WhatsApp">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    <path d="M12 3a9 9 0 0 0-7.8 13.5L3 21l4.7-1.2A9 9 0 1 0 12 3z"></path>
    <path d="M8.5 9.5c0 3.5 2.5 6 6 6" stroke-width="1.6"></path>
    <circle cx="8.5" cy="9.5" r="0.9" fill="currentColor" stroke="none"></circle>
    <circle cx="14.5" cy="15.5" r="0.9" fill="currentColor" stroke="none"></circle>
  </svg>
  <span>WhatsApp</span>
</a>

<?php wp_footer(); ?>
</body>
</html>
