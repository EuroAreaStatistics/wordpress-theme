<?php

namespace Roots\Sage\MChart;

use Roots\Sage\Setup;

function filter_m_chart_chart_args( $chart_args, $post, $post_meta, $args ) {

/* requires Highcharts >= 6.0.0
// enable CSV export for Highcharts from m-chart plugin
  wp_enqueue_script( 'highcharts-export-data' );
  $chart_args['exporting']['enabled'] = true;
*/

// hide all other series if there are series whose names begin wtih 'Euro area'
// change the color of the 'Euro area' series to blue
  $series = array_column($chart_args['series'], 'name');
  $euro = preg_grep('/^Euro area/', $series);
  if (count($euro)) {
    foreach ($chart_args['series'] as $k => &$v) {
      if (!isset($euro[$k])) {
        $v['visible'] = false;
      } else {
        $v['color'] = '#004996';
     }
    }
  }

  $options = @json_decode(stripslashes($post_meta['options']), true);
  if (is_array($options)) $chart_args = array_replace_recursive($chart_args, $options);
  return $chart_args;
}

add_filter( 'm_chart_chart_args', __NAMESPACE__ . '\\filter_m_chart_chart_args', 10, 4 );

if (!array_key_exists('options', m_chart()->chart_meta_fields)) m_chart()->chart_meta_fields['options'] = '';

function action_m_chart_admin_footer_javascript() {
  ?>
  (function($) {
      var init = m_chart_highcharts_admin.init;
      // m_chart_admin.init() is called before m_chart_highcharts_admin.init()
      m_chart_highcharts_admin.init = function () {
        // add options textarea
        $('#m-chart .settings').append($('#tmpl-m-chart-options').html());
        var textareas = $('#m-chart .settings textarea');
        // include options in form parameters
        m_chart_admin.$setting_inputs = m_chart_admin.$setting_inputs.add(textareas);
        // refresh chart if options are changed
        if (m_chart_admin.performance !== 'no-preview') {
          textareas.on('change', function() {
            m_chart_admin.refresh_chart();
          });
        }
        // call original init function
        return init.call(this);
      };
  })(jQuery);
  <?php
}

add_action( 'm_chart_admin_footer_javascript',  __NAMESPACE__ . '\\action_m_chart_admin_footer_javascript' );

function filter_m_chart_settings_template( $template, $library ) {
  if ($library !== 'highcharts') return $template;
  if ($template !== WP_PLUGIN_DIR.'/m-chart-highcharts-library/components/templates/highcharts-settings.php') return $template;
  return __DIR__.'/template-highcharts-settings.php';
}

add_filter( 'm_chart_settings_template',  __NAMESPACE__ . '\\filter_m_chart_settings_template', 10, 2 );

function filter_wp_kses_allowed_html( $tags, $context ) {
  if ($context === 'strip') {
    $tags['span']['style'] = true;
    if (!isset($tags['b'])) $tags['b'] = [];
    if (!isset($tags['br'])) $tags['br'] = [];
  }
  return $tags;
}

add_filter( 'wp_kses_allowed_html',  __NAMESPACE__ . '\\filter_wp_kses_allowed_html', 10, 2 );

function filter_safecss_filter_attr_allow_css( $allow_css, $css_test_string ) {
  return true;
}

add_filter( 'safecss_filter_attr_allow_css', __NAMESPACE__ . '\\filter_safecss_filter_attr_allow_css', 10, 2 );
