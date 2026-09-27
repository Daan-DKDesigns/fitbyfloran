<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
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

<header>
  <div class="container nav">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="display:flex;align-items:center;">
      <?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
        <span class="logo-text">Fit by Floran<span>.</span></span>
      <?php endif; ?>
    </a>

    <nav class="mainnav">
      <?php
      wp_nav_menu( array(
        'theme_location' => 'primary',
        'container'      => false,
        'items_wrap'     => '<ul>%3$s</ul>',
        'fallback_cb'    => 'fbf_default_menu',
      ) );
      ?>
    </nav>

    <button class="nav-hamburger" id="navHamburger" type="button" aria-label="Open menu" aria-expanded="false">
      <svg id="hamburgerIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
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
      'items_wrap'     => '<ul>%3$s</ul>',
      'fallback_cb'    => 'fbf_default_menu_mobile',
    ) );
    ?>
  </div>
</header>
