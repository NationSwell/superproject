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
            'supports' => 'title',
            'rewrite' => array( 'slug' => 'nscevent' ),
        )
    );
    $set = get_option('post_type_rules_flased_nscevent');
    if ($set !== true){
        flush_rewrite_rules(false);
        update_option('post_type_rules_flased_nscevent',true);
    }

}

add_action( 'init', 'create_nscevent_post_type' );