<?php


function create_editors_picks_post_type()
{
    register_post_type(
        'ns_editors_picks',
        array(
            'labels' => array(
                'name' => __( 'Editor\'s Picks' ),
                'singular_name' => __( 'Editor\'s Picks' )
            ),
            'public' => true,
            'publicly_queryable' => true,
            'has_archive' => true,
            'supports' => 'title',
            'rewrite' => array( 'slug' => 'editors-picks' ),
            'exclude_from_search' => true,
        )
    );

}

add_action( 'init', 'create_editors_picks_post_type' );
