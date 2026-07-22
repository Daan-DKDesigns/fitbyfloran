<?php
/**
 * Template voor gewone pagina's (bijv. Privacyverklaring, Algemene voorwaarden).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="wrap" style="padding-top:80px; padding-bottom:80px; max-width:800px;">
  <?php while ( have_posts() ) : the_post(); ?>
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
      <h1 style="margin-bottom:24px;"><?php the_title(); ?></h1>
      <div style="color:var(--text-dim); line-height:1.8;">
        <?php the_content(); ?>
      </div>
    </article>
  <?php endwhile; ?>
</div>

<?php get_footer(); ?>
