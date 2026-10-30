<?php
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
<a class="skip-link" href="#inhoud"><?php esc_html_e( 'Naar de inhoud', 'fitbyfloran' ); ?></a>

<header class="site-header">
    <div class="container site-header__inner">

        <div class="site-header__logo">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> - home">
                    <span class="logo-text">
                        <?php bloginfo( 'name' ); ?>
                    </span>
                </a>
            <?php endif; ?>
        </div>

        <nav class="mainnav" aria-label="<?php esc_attr_e( 'Hoofdnavigatie', 'fitbyfloran' ); ?>">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'mainnav__list',
                'fallback_cb'    => 'fbf_default_menu',
                'depth'          => 2,
            ) );
            ?>
        </nav>

        <button
            class="nav-hamburger"
            id="navHamburger"
            type="button"
            aria-label="<?php esc_attr_e( 'Menu openen', 'fitbyfloran' ); ?>"
            aria-expanded="false"
            aria-controls="mobileMenu"
        >
            <svg
                class="nav-hamburger__icon"
                id="hamburgerIcon"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                aria-hidden="true"
            >
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

    </div>

    <div class="mobile-menu" id="mobileMenu" aria-hidden="true">
        <nav aria-label="<?php esc_attr_e( 'Mobiele navigatie', 'fitbyfloran' ); ?>">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'mobile-menu__list',
                'fallback_cb'    => 'fbf_default_menu',
                'depth'          => 2,
            ) );
            ?>
        </nav>
        <?php
        $fbf_menu_tel  = fbf_tel_href( fbf_contact_phone() );
        $fbf_menu_mail = fbf_contact_email();
        ?>
        <div class="mobile-menu__contact">
            <span class="mobile-menu__contact-titel"><?php esc_html_e( 'Direct contact', 'fitbyfloran' ); ?></span>
            <a href="<?php echo esc_url( fbf_whatsapp_url() ); ?>" target="_blank" rel="noopener noreferrer"><?php echo fbf_icoon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span>WhatsApp</span></a>
            <?php if ( $fbf_menu_tel ) : ?>
            <a href="<?php echo esc_url( $fbf_menu_tel ); ?>"><?php echo fbf_icoon( 'telefoon' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php esc_html_e( 'Bellen', 'fitbyfloran' ); ?></span></a>
            <?php endif; ?>
            <?php if ( $fbf_menu_mail ) : ?>
            <a href="mailto:<?php echo esc_attr( $fbf_menu_mail ); ?>"><?php echo fbf_icoon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php esc_html_e( 'E-mail', 'fitbyfloran' ); ?></span></a>
            <?php endif; ?>
        </div>
    </div>
</header>
