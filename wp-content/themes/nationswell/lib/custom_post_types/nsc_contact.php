<?php


function create_nsccontact_post_type()
{
    register_post_type(
        'nsccontact',
        array(
            'labels' => array(
                'name' => __( 'Nationswell Council Contacts' ),
                'singular_name' => __( 'Nationswell Council Contact' )
            ),
            'public' => true,
            'publicly_queryable' => true,
            'has_archive' => true,
            'supports' => 'title',
            'rewrite' => array( 'slug' => 'nsccontact' ),
        )
    );
    flush_rewrite_rules(false);

}

add_action( 'init', 'create_nsccontact_post_type' );