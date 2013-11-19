<?php

add_action('init', 'create_post_type');

function create_post_type()
{
    register_post_type(
        'ns_call_to_action',
        array(
            'labels' => array(
                'name' => __('Calls to Action'),
                'singular_name' => __('Call to Action')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => false
        )
    );
}

