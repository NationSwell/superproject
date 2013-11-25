<?php
if (function_exists("register_field_group")) {
    register_field_group(array(
        'id' => 'acf_flyout-options',
        'title' => 'Flyout Options',
        'fields' => array(
            array(
                'key' => 'field_5293ab9ca6467',
                'label' => 'Enable Social Flyout',
                'name' => 'flyout_social_enabled',
                'type' => 'true_false',
                'message' => '',
                'default_value' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options',
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
