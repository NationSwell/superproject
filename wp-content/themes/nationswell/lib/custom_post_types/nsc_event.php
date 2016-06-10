<?php


function create_nscevent_post_type()
{
    register_post_type(
        'nscevent',
        array(
            'labels' => array(
                'name' => __( 'Nationswell Council Events' ),
                'singular_name' => __( 'Mationswell Council Event' )
            ),
            'public' => true,
            'publicly_queryable' => true,
            'has_archive' => true,
            'supports' => array('title','thumbnail'),
            'rewrite' => array( 'slug' => 'nscevent' ),
        )
    );
    flush_rewrite_rules(false);

}

add_action( 'init', 'create_nscevent_post_type' );