<?php


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
            'publicly_queryable' => true,
            'has_archive' => true,
            'supports' => 'title',
            'rewrite' => array( 'slug' => 'daily-newsletter' ),
            'exclude_from_search' => true,
        )
    );

    flush_rewrite_rules();
}

//add_action( 'after_switch_theme', 'create_daily_newsletter_post_type' );
add_action('init', 'create_daily_newsletter_post_type');
