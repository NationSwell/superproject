<?php

add_action('init', 'create_daily_newsletter_post_type');

function create_daily_newsletter_post_type()
{
    register_post_type(
        'ns_daily_newsletter',
        array(
            'labels' => array(
                'name' => __('Daily Newsletters'),
                'singular_name' => __('Daily Newsletter')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => 'title'
        )
    );
}