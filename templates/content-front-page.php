<div class="col-12 col-lg-4 mb-4">
  <div class="card h-100">
    <?= wp_get_attachment_image( get_the_ID(), array('class' => 'img-fluid card-img-top') ); ?>
    <div class="card-body">
      <h2 class="card-title mb-5"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <div class="card-text"><?php the_excerpt(); ?></div>
    </div>
  </div>
</div>





