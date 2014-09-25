<?php
if (function_exists("register_field_group")) {
    register_field_group(array(
        'id' => 'acf_story-tease-display',
        'title' => 'Story Tease Display',
        'fields' => array(
            array(
                'key' => 'field_5424702199616',
                'label' => 'Show Dek on Feature Tease',
                'name' => 'show_dek_on_feature_tease',
                'type' => 'true_false',
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
    ));
}
