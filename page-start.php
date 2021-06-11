<?php
/**
 * Template Name: Start
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', 'page-start'); ?>
<?php endwhile; ?>
