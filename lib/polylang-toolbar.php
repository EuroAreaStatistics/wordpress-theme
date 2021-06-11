<?php

add_action( 'admin_bar_menu', 'pll_toolbar', 900 );

function pll_toolbar($wp_admin_bar) {
  if (!function_exists('pll_the_languages')) return;
  $translations = pll_the_languages(['raw' => 1]);
  if (!is_array($translations)) return;
  $items = [];
  foreach ($translations as $lang => $options)  {
    if ($options['current_lang']) {
      $wp_admin_bar->add_node([
        'id' => 'pll',
        'title' => $options['name'],
      ]);
    } else if (!$options['no_translation']) {
      $items[] = [
        'id' => 'pll-'.$lang,
        'title' => $options['name'],
        'href' => $options['url'],
        'parent' => 'pll',
      ];
    }
  }
  foreach ($items as $item) {
    $wp_admin_bar->add_node($item);
  }
}
