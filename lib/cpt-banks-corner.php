<?php

add_action( 'init', function() {
  register_extended_post_type( 'banks_corner', [

    # Add the post type to the site's main RSS feed:
    'has_archive' => true,
    'show_in_feed' => false,
    'show_in_rest' => true,
    'rest_base' => 'banks-corner',

    # Show all posts on the post type archive:
    'archive' => [
      'nopaging' => true,
    ],

    # Add some custom columns to the admin screen:
    'admin_cols' => [
      'banks_corner_subgroup' => [
        'taxonomy' => 'subgroup'
      ],
    ],

    # Add a dropdown filter to the admin screen:
    'admin_filters' => [
      'banks_corner_subgroup' => [
        'taxonomy' => 'subgroup'
      ],
    ],

  ], 

  [

    # Override the base names used for labels:
    'singular' => 'banks-corner',
    'plural'   => 'banks-corner',
    'slug'     => 'banks-corners',

  ] );


  register_extended_taxonomy( 'subgroup', 'banks_corner', [

    'show_in_rest' => true

  ] );

} );
