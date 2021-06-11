<?php

/**
 * Theme Name: Area Range
 */

if (!function_exists('area_range_m_chart_args')) {
  function area_range_m_chart_args( $chart_args, $post, $post_meta, $args ) {
    if ($post_meta['theme'] !== basename(__FILE__, '.php')) return $chart_args;
    if (count($chart_args['series']) !== 3) return $chart_args;
    $chart_args['series'][0]['zIndex'] = 1;
    $chart_args['series'][0]['color'] = '#004996';
    $chart_args['series'][0]['marker']['enabled'] = false;
    $chart_args['series'][1]['data'] = array_map(function ($d1, $d2) { return [$d1, $d2]; }, $chart_args['series'][1]['data'], $chart_args['series'][2]['data']);
    $chart_args['series'][1]['type'] = "arearange";
    $chart_args['series'][1]['lineWidth'] = 0;
    $chart_args['series'][1]['linkedTo'] = ":previous";
    $chart_args['series'][1]['color'] = $chart_args['series'][0]['color'];
    $chart_args['series'][1]['fillOpacity'] = 0.3;
    $chart_args['series'][1]['zIndex'] = 0;
    // disable hiding of non-euro-area series
    unset($chart_args['series'][1]['visible']);
    unset($chart_args['series'][2]);
    return $chart_args;
  }
}

add_filter( 'm_chart_chart_args', 'area_range_m_chart_args', 10, 4 );

return [
  'title' => [
     'text' => null,
   ],
   'tooltip' => [
     'shared' => true,
   ],
  'plotOptions' => [
    'series' => [
      'marker' => [ 'enabled' => false ],
      'dataLabels' => [ 'enabled' => false ],
    ],
  ],
];
