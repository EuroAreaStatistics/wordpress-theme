<?php 
  function wds_get_ID_by_page_name($page_name)
{
     global $wpdb;
     $page_name_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name ='".$page_name."'");
     return $page_name_id;
}
 ?>
<div class="entry-content">
  <?php $page = wds_get_ID_by_page_name('banks-corner'); ?>
  <h4><a href="<?php echo get_the_permalink(pll_get_post($page)); ?>"><?php echo get_the_title(pll_get_post($page))?></a></h4>
  <?php the_content(); ?>
</div>
<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
