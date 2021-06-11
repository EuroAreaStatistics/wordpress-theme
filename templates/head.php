<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
  
  <script>
    jQuery(document).ready(function($) {

    $("p").filter(function(){
      return $.trim(this.innerHTML) === "&nbsp;"
    }).remove();
    
    });
  </script>

</head>
