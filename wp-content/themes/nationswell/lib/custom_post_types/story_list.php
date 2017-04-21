<?php

add_action('init', 'create_story_list_post_type');

function create_story_list_post_type()
{
    register_post_type(
        'ns_story_list',
        array(
            'labels' => array(
                'name' => __('Story Lists'),
                'singular_name' => __('Story List')
            ),
            'public' => true,
            'has_archive' => true,
            'publicly_queryable' => true,
            'supports' => 'title',
            'exclude_from_search' => true,
        )
    );
}