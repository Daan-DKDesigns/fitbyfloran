<?php
/**
 * De header voor het thema.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<nav>
  <div class="wrap">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
      <?php get_template_part( 'template-parts/logo-icon', null, array( 'size' => 30 ) ); ?>
      <div class="logo-text">
        <span class="logo-full">Fit by Floran<span>.</span></span><span class="logo-short">Floran<span>.</span></span>
        <span class="sub">Elite performance physiotherapy</span>
      </div>
    </a>

    <?php
    wp_nav_menu( array(
      'theme_location' => 'primary',
      'container'      => false,
      'items_wrap'     => '<ul id="%1$s" class="navlinks">%3$s</ul>',
      'fallback_cb'    => 'fbf_default_menu',
    ) );
    ?>

    <div style="display:flex; align-items:center; gap:14px;">
      <button class="theme-toggle nav-desktop" id="themeToggle" type="button" aria-label="Wissel naar lichte weergave" aria-pressed="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="4"></circle>
          <line x1="12" y1="2" x2="12" y2="4.5"></line>
          <line x1="12" y1="19.5" x2="12" y2="22"></line>
          <line x1="4.2" y1="4.2" x2="6" y2="6"></line>
          <line x1="18" y1="18" x2="19.8" y2="19.8"></line>
          <line x1="2" y1="12" x2="4.5" y2="12"></line>
          <line x1="19.5" y1="12" x2="22" y2="12"></line>
          <line x1="4.2" y1="19.8" x2="6" y2="18"></line>
          <line x1="18" y1="6" x2="19.8" y2="4.2"></line>
        </svg>
      </button>
      <a href="#contact" class="btn">Plan een intake</a>
      <button class="nav-hamburger" id="navHamburger" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="mobileMenu">
        <svg id="hamburgerIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
      </button>
    </div>

    <div class="mobile-menu" id="mobileMenu">
      <?php
      wp_nav_menu( array(
        'theme_location' => 'primary',
        'container'      => false,
        'items_wrap'     => '%3$s',
        'fallback_cb'    => 'fbf_default_menu_mobile',
      ) );
      ?>
      <div class="mobile-menu-toggle">
        <span>Lichte weergave</span>
        <button class="theme-toggle" id="themeToggleMobile" type="button" aria-label="Wissel naar lichte weergave" aria-pressed="false">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="4"></circle>
            <line x1="12" y1="2" x2="12" y2="4.5"></line>
            <line x1="12" y1="19.5" x2="12" y2="22"></line>
            <line x1="4.2" y1="4.2" x2="6" y2="6"></line>
            <line x1="18" y1="18" x2="19.8" y2="19.8"></line>
            <line x1="2" y1="12" x2="4.5" y2="12"></line>
            <line x1="19.5" y1="12" x2="22" y2="12"></line>
            <line x1="4.2" y1="19.8" x2="6" y2="18"></line>
            <line x1="18" y1="6" x2="19.8" y2="4.2"></line>
          </svg>
        </button>
      </div>
    </div>
  </div>
</nav>
