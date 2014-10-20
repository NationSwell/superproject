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
    $set = get_option('post_type_rules_flased_nsccontact');
    if ($set !== true){
        flush_rewrite_rules(false);
        update_option('post_type_rules_flased_nsccontact',true);
    }

}

add_action( 'init', 'create_nsccontact_post_type' );