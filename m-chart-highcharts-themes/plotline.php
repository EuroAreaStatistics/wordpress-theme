<?php

/**
 * Theme Name: Plot line (Q4 2019)
 */

if (!function_exists('plotLine_m_chart_args')) {
  function plotLine_m_chart_args($chart_args, $post, $post_meta, $args) {
      if ($post_meta['theme'] !== basename(__FILE__, '.php')) return $chart_args;
      if (!isset($chart_args['xAxis']['categories'])) return $chart_args;
      if (!isset($chart_args['xAxis']['plotLines'])) return $chart_args;
      foreach ($chart_args['xAxis']['plotLines'] as &$plotLine) {
        if (!isset($plotLine['category'])) continue;
        $value = array_search($plotLine['category'], $chart_args['xAxis']['categories'], true);
        unset($plotLine['category']);
        if ($value !== FALSE) $plotLine['value'] = $value;
      }
      return $chart_args;
  }
}

add_filter( 'm_chart_chart_args', 'plotLine_m_chart_args', 10, 4 );

return [
  'xAxis' => [
    'plotLines' => [
      [
        "color" => "#004996",
        "width" => 1,
        "category" => "Q4 2019",
        "dashStyle" => "Dash",
        "label" => [
           "align" => "right",
           "textAlign" => "left",
           "verticalAlign" => "bottom",
           "rotation" => 0,
           "text" => "COVID-19",
           "y" => -10,
        ],
      ],
    ],
  ],
];
