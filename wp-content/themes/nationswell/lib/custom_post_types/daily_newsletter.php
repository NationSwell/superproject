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
            'publicly_queryable' => true,
            'has_archive' => true,
            'supports' => 'title',
            'rewrite' => array( 'slug' => 'daily-newsletter' ),
        )
    );
}

function my_rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry,
    // when you add a post of this CPT.
    my_cpt_init();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}

add_action( 'after_switch_theme', 'my_rewrite_flush' );