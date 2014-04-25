<?php


function create_bi_contributors_post_type()
{
    register_post_type(
        'ns_bi_contributors',
        array(
            'labels' => array(
                'name' => __('BI Contributors'),
                'singular_name' => __('BIContributors')
            ),
            'public' => true,
            'publicly_queryable' => true,
            'has_archive' => true,
            'supports' => 'title',
            'rewrite' => array( 'slug' => 'bi-contributors' ),
            'exclude_from_search' => true,
        )
    );

}

add_action('init', 'create_bi_contributors_post_type');