<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<div class="container" style="padding-top:150px; padding-bottom:80px; max-width:800px;">
  <?php while ( have_posts() ) : the_post(); ?>
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
      <h1 style="margin-bottom:24px;"><?php the_title(); ?></h1>
      <div class="muted" style="line-height:1.8;"><?php the_content(); ?></div>
    </article>
  <?php endwhile; ?>
</div>
<?php get_footer(); ?>
