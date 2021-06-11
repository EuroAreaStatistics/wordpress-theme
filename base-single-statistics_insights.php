<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>
<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <!--[if IE]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <?php
      do_action('get_header');
    ?>
    <div class="wrap container-fluid" role="document">
      <div class="content row no-gutters">
        <main class="main col-md-8 list-group-box">
          <?php get_template_part('templates/page-header'); ?>
          <?php include Wrapper\template_path(); ?>
        </main>
         <div class="col-md-3 col-lg-2 offset-xs-0 offset-sm-1 offset-md-1 col-offset-half mt-5 mt-sm-5 mt-md-0">
          <?php get_template_part('templates/statistics_insights-archive'); ?>  
        </div>
      </div>
    </div>
    <?php
      do_action('get_footer');
      wp_footer();
    ?>
  </body>
</html>
