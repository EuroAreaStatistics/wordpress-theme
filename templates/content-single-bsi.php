<?php 

while (have_posts()) : the_post();
$fields = get_fields(); 

function array_remove_keys($array, $keys) 

  {
   
      $assocKeys = array();
      foreach($keys as $key) {
          $assocKeys[$key] = true;
      }
   
      return array_diff_key($array, $assocKeys);
  }

function to_text($a) {
  return trim(strip_tags($a));
}

function search($array, $key, $value)
      
  {
      $results = array();

      if (is_array($array)) {
          if (isset($array[$key]) && to_text($array[$key]) === $value) {
              $results[] = $array;
          }

          foreach ($array as $subarray) {
              $results = array_merge($results, search($subarray, $key, $value));
          }
      }

      return $results;
  }

foreach($fields['charts'] as $key => $value) {
  $fields['charts'][$key] = array_remove_keys($value, array('date'));
} 

// Get terms for post
 $terms = get_the_terms( $post->ID , 'subgroup' );
 
 if ( $terms != null ){
  foreach( $terms as $term ) {
    $current_term = $term->slug;
    // Get rid of the other data stored in the object, since it's not needed
    unset($term);
  } 
}



?>

<div class="p-2">
  <?php 
    if (!empty($fields['options'])) { 
      echo $fields['options']; 
    } 
  ?>
</div>

  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
         <tr>
            <th><?php echo $fields['charts_header']['charts_header_name'] ?></th>
            <th><?php echo $fields['charts_header']['charts_header_link_1'] ?></th>
            <th><?php echo $fields['charts_header']['charts_header_link_2'] ?></th>
            <th><?php echo $fields['charts_header']['charts_header_size'] ?></th>
            <th><?php echo $fields['charts_header']['charts_header_description'] ?></th>
         </tr>
      </thead>
      
      <?php 
        
        $index = 0;
        
        $unique_categories = array_unique(array_column($fields['charts'], 'category'));
        // only regard categories with different text content as different
        // array keys are shared between $unique_categories and $unique_category_texts
        $unique_category_texts = array_unique(array_map('to_text', $unique_categories));

        // all categories as tbody
        foreach($unique_category_texts as $idx => $table) {
           echo('<tbody>');
           echo('<td>' . $unique_categories[$idx]  . '</td>');
           echo('<td></td>');
           echo('<td></td>');
           echo('<td></td>');
           $term_description = search($fields['charts'], 'category', $table);
           echo('<td>' . $term_description[0]['category_description']  . '</td>');
           echo('<td></td>');

            // $table = category number 
            foreach(search($fields['charts'], 'category', $table) as $row) {
            
            echo('<tr>');
            
              foreach($row as $key => $value) {

                $index++;
                if ($key === 'title') {
                  $temp_title = $value;
                }
                
                // create DL Links
                if ($key === 'link_xml' || $key === 'link_csv') {
                  
                  if ($key === 'link_csv') {
                    
                    if ($current_term != 'banks-corner-sbs') {
                       echo('<td><a data-type="text/csv" download="'. strtolower( preg_replace('#[ -]+#', '-', $name) ) . '-' . strtolower($temp_title) .'.csv" href="https://sdw-wsrest.ecb.europa.eu/service/data/' .$value. '?format=csvdata" ><img style="height:1rem" src="' . get_stylesheet_directory_uri() . '/assets/images/download-solid.svg" /></a></td>');
                    } else {
                       echo('<td><a href="' .$value. '" ><img style="height:1rem" src="' . get_stylesheet_directory_uri() . '/assets/images/download-solid.svg" /></a></td>');
                    }
                   
                  }

                  if ($key === 'link_xml') {
                    
                    if ($current_term != 'banks-corner-sbs') {
                      echo('<td><a data-type="text/xml" download="'. strtolower( preg_replace('#[ -]+#', '-', $name) ) . '-' . strtolower($temp_title) .'.xml" href="https://sdw-wsrest.ecb.europa.eu/service/data/' .$value. '?format=genericdata" ><img style="height:1rem" src="' . get_stylesheet_directory_uri() . '/assets/images/download-solid.svg" /></a></td>');
                     } else {
                      echo('<td><a href="' .$value. '" ><img style="height:1rem" src="' . get_stylesheet_directory_uri() . '/assets/images/download-solid.svg" /></a></td>');
                    } 
                  }
                  
                }

                else if ($key === 'size_xml') {
                  
                  if ($value === 'small') {
                    echo('<td class="td-size"><div class="bc-size-small"></div></td>');
                  }

                  if ($value === 'medium') {
                    echo('<td class="td-size"><div class="bc-size-medium"></div></td>');
                  }
                  
                }  
                
                // create cell if it is not an int = category
                else if ( !(is_string($value)) ) {
                  echo('<td>' . $value . '</td>');
                }
                // create empty cell for category
                else if ($key === 'category') {
                  echo('<td></td>');
                }  

                // render all other cells
                else {
                  if (($key != 'category_description')) {
                  echo('<td>' . $value . '</td>');
                  }
                }
              
              }
            
            echo('</tr>');
            
            }

        echo('</tbody>'); 

      } 

    ?>
    
    </table>
    <?php  if (!empty($fields['link_3'])) { ?>
      <a href="https://www.bankingsupervision.europa.eu/banking/statistics/html/index.en.html"><?php echo $fields['link_3'] ?></a>
    <?php } ?>
  </div>

 
<?php endwhile; ?>
