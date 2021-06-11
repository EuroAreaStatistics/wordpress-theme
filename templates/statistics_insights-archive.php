  <?php

  use Roots\Sage\Extras;
/*
Template Name: Archives
*/
?>

<div class="list-group-box"><h3 class="p-2 pt-3 text-center"><?php echo pll_translate_string( 'Previous Insights', pll_current_language() ); ?></h3>

<div id="accordion">
<?php foreach(Extras\posts_by_year('statistics_insights') as $year => $foo) : ?>


   <div class="card text-white bg-success border-light text-center">
  
      <div class="card-header text-center">
        <a class="btn btn-link" data-toggle="collapse" href="#collapse<?php echo $year; ?>">
        <?php echo $year; ?></a>    
    </div>
    <div id="collapse<?php echo $year; ?>" class="collapse">
      
        <ul class="list-group list-group-flush">
            <?php foreach($foo as $post) : setup_postdata($post); ?>
              <li class="list-group-item list-group-item-action">
                <a href="<?php the_permalink(); ?>"><?php the_field('pubdate_short',false, false); ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
    
    </div>
  </div>
  <?php endforeach; ?>
</div>
</div>

