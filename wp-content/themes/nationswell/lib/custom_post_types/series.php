<?php


function create_series_post_type()
{
    register_post_type(
        'ns_series',
        array(
            'labels' => array(
                'name' => __( 'Nationswell Series' ),
                'singular_name' => __( 'Mationswell Series' )
            ),
            'public' => true,
            'publicly_queryable' => true,
            'has_archive' => true,
            'supports' => 'title',
            'rewrite' => array( 'slug' => 'ns-series' ),
        )
    );
    flush_rewrite_rules();

}

add_action( 'init', 'create_series_post_type' );