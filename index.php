<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<div class="container" style="padding-top:150px; padding-bottom:80px;">
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
      <h1><?php the_title(); ?></h1>
      <div><?php the_content(); ?></div>
    </article>
  <?php endwhile; else : ?>
    <p>Geen content gevonden.</p>
  <?php endif; ?>
</div>
<?php get_footer(); ?>
