<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <p><a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a><p>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

function add_image_class($class){
    $class .= ' img-fluid';
    return $class;
}

add_filter('get_image_tag_class', __NAMESPACE__ . '\\add_image_class', 6);

function posts_by_year($post_type) {
  // array to use for results
  $years = array();

  // get posts from WP
  $posts = get_posts(array(
    'numberposts' => -1,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => $post_type,
    'post_status' => wp_get_current_user()->has_cap('edit_posts') ? ['publish', 'draft'] : 'publish',
  ));

  // loop through posts, populating $years arrays
  foreach($posts as $post) {
    $years[date('Y', strtotime($post->post_date))][] = $post;
  }

  // reverse sort by year
  krsort($years);

  return $years;
}

add_filter('posts_by_year', __NAMESPACE__ . '\\posts_by_year');



// ADD
// SCRIPTS AND STYLES
// ------------------
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\theme_enqueue_styles', 10 );

function theme_enqueue_styles() {

  // CSS
  wp_enqueue_style( 'font-roboto', 'https://fonts.googleapis.com/css?family=Roboto', [], null );
  wp_enqueue_style( 'main', get_template_directory_uri() . '/assets/build/css/main.css' );

  // Javascript
  wp_enqueue_script( 'popper', get_template_directory_uri() . '/external/js/popper.min.js', ['jquery'], '1.12.9' );
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/external/js/bootstrap.min.js', ['popper'], '4.0.0' );

  downgrade_highcharts();
}
  
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\downgrade_highcharts', 10 );
function downgrade_highcharts() {
  // downgrade to Highcharts 4.1.10
  if (wp_script_is( 'highcharts', 'registered' )) {
    wp_deregister_script( 'highcharts' );
    wp_register_script( 'highcharts', get_template_directory_uri() . '/external/js/highcharts-release/highcharts.js', ['jquery'], '4.1.10' );
    if (wp_script_is( 'highcharts-more',  'registered' )) {
      wp_deregister_script( 'highcharts-more' );
      wp_register_script( 'highcharts-more', get_template_directory_uri() . '/external/js/highcharts-release/highcharts-more.js', ['jquery', 'highcharts'], '4.1.10' );
    }
    if (wp_script_is( 'highcharts-exporting',  'registered' )) {
      wp_deregister_script( 'highcharts-exporting' );
      wp_register_script( 'highcharts-exporting',get_template_directory_uri() . '/external/js/highcharts-release/modules/exporting.js', ['highcharts', 'jquery'], '4.1.10' );
    }
// Drop-in fix for Highcharts issue #8477 on older Highcharts versions. The
// issue is fixed since Highcharts v6.1.1.
    wp_add_inline_script( 'highcharts', <<<JS
Highcharts.wrap(Highcharts.Axis.prototype, 'getPlotLinePath', function(proceed) {
  var path = proceed.apply(this, Array.prototype.slice.call(arguments, 1));
  if (path) {
    path.flat = false;
  }
  return path;
});
JS
    );
  }

}

// Add body class to Visual Editor to match class used live
function mytheme_mce_settings( $initArray ){
 $initArray['body_class'] = 'entry-content';
 return $initArray;
}
add_filter( 'tiny_mce_before_init', __NAMESPACE__ . '\\mytheme_mce_settings' );

// add empty css for Visual Editor 
add_editor_style( 'assets/build/css/custom-editor-style.css');


// EZB

// Enable the option edit in rest
add_filter( 'acf/rest_api/field_settings/edit_in_rest', '__return_true' );


function custom_menu_page_removing() {
  if (!current_user_can( 'update_core' )) remove_menu_page( 'index.php' );                  //Dashboard
  //remove_menu_page( 'edit.php' );                   //Posts
  //remove_menu_page( 'upload.php' );                 //Media
  //remove_menu_page( 'edit.php?post_type=page' );    //Pages
  remove_menu_page( 'edit-comments.php' );          //Comments
  //remove_menu_page( 'themes.php' );                 //Appearance
  //remove_menu_page( 'plugins.php' );                //Plugins
  //remove_menu_page( 'users.php' );                  //Users
  //remove_menu_page( 'tools.php' );                  //Tools
  //remove_menu_page( 'options-general.php' );        //Settings
}
add_action( 'admin_menu', __NAMESPACE__ . '\\custom_menu_page_removing' );


add_filter('acf/fields/taxonomy/result/name=category', __NAMESPACE__ . '\\my_post_object_result', 10, 4);


// get_page_by_slug
function get_page_by_slug($page_slug, $output = OBJECT, $post_type = 'page' ) { 
  global $wpdb; 
   $page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s AND post_status = 'publish'", $page_slug, $post_type ) ); 
     if ( $page ) 
        return get_post($page, $output); 
    return null; 
  }

// 

function filter_acf_the_content( $value ) { 
    $order   = array("/[\r\n]+/","\r\n ","\r\n", "\n", "\r");
    $replace = '<br />';
    $newstr = str_replace($order, $replace, $value);
    return $newstr; 
}; 

if (function_exists('pll_register_string')) {
  pll_register_string("si", "Insights");
  pll_register_string("si", "Explainer");
  pll_register_string("si", "References");
  pll_register_string("si", "Download");
  pll_register_string("si", "Previous Insights");
}

// disable login captcha for whitelisted IPs
if (isset($aio_wp_security)) {
  if ( $aio_wp_security->configs->get_value('aiowps_lockdown_enable_whitelisting') == '1' ) {
    if (\AIOWPSecurity_Utility_IP::is_ip_whitelisted(\AIOWPSecurity_Utility_IP::get_user_ip_address(), $aio_wp_security->configs->get_value('aiowps_lockdown_allowed_ip_addresses'))) {
      $aio_wp_security->configs->set_value('aiowps_enable_login_captcha', '0');
    }
  }
}

function admin_notice__editing() {
  $screen = get_current_screen();
  if (!$screen || $screen->base !== 'post') return;
    ?>
    <div class="notice notice-warning">
        <p>Copy the current site to the live server <a href="https://dvlp.euro-area-statistics.org/edit/golive.php" target="_blank" rel="noopener noreferrer">here</a> BEFORE editing content.</p>
    </div>
    <?php
}
add_action( 'admin_notices', __NAMESPACE__ . '\\admin_notice__editing' );

function raw_wysiwyg_content($result, $wprestserver, $request ) {
  $params = $request->get_query_params();
  if (isset($params['context']) && $params['context'] === 'edit') {
    // leave shortcodes as is in HTML code
    remove_all_shortcodes();
    // do not change quotes (breaks shortcodes)
    add_filter('run_wptexturize', '\\__return_false');
    // // below removes formatting needed for ECB translation editor
    // remove_all_filters( 'acf_the_content' );
  }
  return null;
}
add_filter( 'rest_pre_dispatch', __NAMESPACE__ . '\\raw_wysiwyg_content', 10, 3);

function admin_bar_item ( \WP_Admin_Bar $admin_bar ) {
  if (!is_admin()) return; // get_post retreives wrong post on preview (last insight in archive ...)
  if (is_admin()) {
    $screen = get_current_screen();
    if (!$screen || $screen->base !== 'post') return;
    if (!in_array($screen->post_type, ['statistics_insights', 'banks_corner'], true)) return;
  }
  $post = get_post();
  if (!$post) return;
  $link = is_admin() ? get_sample_permalink($post->ID)[1] : $post->post_name;
  if ($post->post_type === 'statistics_insights') {
       $dvlp = '/classic/statistics-insights/' . $link;
       $live = '/statistics-insights/' . $link;
  } else if ($post->post_type === 'banks_corner') {
       $link = preg_replace('/^en-/', '', $link);
       $dvlp = '/classic/banks-corner/' . $link;
       $live = '/classic/banks-corner/' . $link;
  }
 if (isset($dvlp)) {
    $admin_bar->add_menu([
        'id'    => 'dvlp-link',
        'parent' => null,
        'group'  => null,
        'title' => 'dvlp',
        'href'  => 'https://dvlp.euro-area-statistics.org' . $dvlp,
        'meta' => [
            'target' => '_blank',
        ],
    ]);
  }
 if (isset($live)) {
    $admin_bar->add_menu([
        'id'    => 'live-link',
        'parent' => null,
        'group'  => null,
        'title' => 'live',
        'href'  => 'https://www.euro-area-statistics.org' . $live,
        'meta' => [
            'target' => '_blank',
        ],
    ]);
  }
}
add_action( 'admin_bar_menu',  __NAMESPACE__ . '\\admin_bar_item', 500 );
