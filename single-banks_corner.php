<?php 
  
  global $post;
  $terms = wp_get_post_terms( $post->ID, 'subgroup');
  $term = $terms[0]->name;
  
  if ($term == 'banks-corner-sbs') {
     get_template_part('templates/content-single', 'sbs');
  }
  
  elseif ($term == 'banks-corner-sec') {
     get_template_part('templates/content-single', 'sec');
  }

  elseif ($term == 'banks-corner-mir') {
     get_template_part('templates/content-single', 'mir');
  }

  elseif ($term == 'banks-corner-bsi') {
     get_template_part('templates/content-single', 'bsi');
  }

  else {
    get_template_part('templates/content-single', get_post_type());
  }
 
 ?>

