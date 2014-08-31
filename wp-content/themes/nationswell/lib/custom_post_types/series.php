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
            'rewrite' => array( 'slug' => 'series' ),
        )
    );
    $set = get_option('post_type_rules_flased_series');
    if ($set !== true){
        flush_rewrite_rules(false);
        update_option('post_type_rules_flased_series',true);
    }

}

add_action( 'init', 'create_series_post_type' );