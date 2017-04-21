<?php

if (function_exists("register_field_group")) {
    register_field_group(array(
        'id' => 'acf_story-list',
        'title' => 'Story List',
        'fields' => array(
            array(
                'key' => 'field_5295f6914bceb',
                'label' => 'Story List',
                'name' => 'story_list',
                'type' => 'relationship',
                'return_format' => 'object',
                'post_type' => array(
                    0 => 'post',
                ),
                'taxonomy' => array(
                    0 => 'all',
                ),
                'filters' => array(
                    0 => 'search',
                ),
                'result_elements' => array(
                    0 => 'featured_image',
                    1 => 'post_type',
                    2 => 'post_title',
                ),
                'max' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'ns_story_list',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array(
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array(),
        ),
        'menu_order' => 0,
    ));
}
