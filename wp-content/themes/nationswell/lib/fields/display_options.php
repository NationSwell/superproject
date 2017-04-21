<?php
if (function_exists("register_field_group")) {
    register_field_group(
        array(
            'id' => 'acf_display-options',
            'title' => 'Display Options',
            'fields' => array(
                array(
                    'key' => 'field_528feda284038',
                    'label' => 'Hide on Home page',
                    'name' => 'hide_on_home_page',
                    'type' => 'true_false',
                    'instructions' => 'Prevents the story from appearing on the home page',
                    'message' => '',
                    'default_value' => 0,
                ),
                array(
                    'key' => 'field_420twdd759102',
                    'label' => 'Hide In-Story Newsletter Signup',
                    'name' => 'hide_in_story_widget',
                    'type' => 'true_false',
                    'instructions' => 'Hides the newsletter signup field appended to the end of the article.',
                    'message' => '',
                    'default_value' => 0,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'post',
                        'order_no' => 0,
                        'group_no' => 0,
                    ),
                ),
            ),
            'options' => array(
                'position' => 'normal',
                'layout' => 'default',
                'hide_on_screen' => array(),
            ),
            'menu_order' => 0,
        )
    );
}
