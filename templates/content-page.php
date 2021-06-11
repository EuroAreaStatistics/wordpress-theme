<div class="entry-content px-2 mt-lg-5">
  <?php the_content(); ?>
</div>
<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
