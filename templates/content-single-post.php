<?php 
// default

while (have_posts()) : the_post();

?>

<div class="wrap container" role="document">
  <div class="content">
    <main class="col-sm-12">
      <div class="entry-content px-2 mt-lg-5">
        <?php the_content(); ?>
      </div>
    </main>
  </div>
</div>

<?php endwhile; ?>
