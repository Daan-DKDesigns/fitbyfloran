<?php
/**
 * Fallback template (verplicht bestand voor elk WordPress-thema).
 * De voorpagina gebruikt front-page.php; dit bestand vangt overige gevallen op.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="wrap" style="padding-top:80px; padding-bottom:80px;">
  <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
      <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
        <h1><?php the_title(); ?></h1>
        <div><?php the_content(); ?></div>
      </article>
    <?php endwhile; ?>
  <?php else : ?>
    <p><?php esc_html_e( 'Geen content gevonden.', 'fitbyfloran' ); ?></p>
  <?php endif; ?>
</div>

<?php get_footer(); ?>
