<?php
/**
 * Template Name: Banks Corner
 */
?>

<div class="row">
    <div class="col-12">
      <div class="row">
        <div class="col-12">
          <div class="row">
            
             <div class="col-12">
             <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('templates/content', 'page'); ?>
              <?php endwhile; ?>
            </div>

            <div class="col-12 pb-4">

              <?php
              $paged_setting = (is_front_page()) ? 'page' : 'paged';
              $paged = (get_query_var($paged_setting)) ? get_query_var($paged_setting) : 1;
              $posts_per_page = -1;

              $archive_banks_corner = new WP_Query(array(
                'post_type' => 'banks_corner',
                'post_status' => 'publish',
                'posts_per_page' => $posts_per_page,
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'ASC'
              ));
              ?>

              <?php if (!$archive_banks_corner->have_posts()) : ?>
                <div class="alert alert-warning">
                  <?php _e('Sorry, no results were found.', 'sage'); ?>
                </div>
              <?php endif; ?>
                
                
                <ul class="list-group px-2">
                  <?php while ($archive_banks_corner->have_posts()) : $archive_banks_corner->the_post(); ?>
                    <li class="list-group-item"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                  <?php endwhile; ?>
                </ul>
                
            
            </div>
              
          </div>
        
        </div>
      </div>
    </div>
</div>

<?php the_posts_navigation(); ?>
