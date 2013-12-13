<?php
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_rally-org',
        'title' => 'Rally.org',
        'fields' => array (
            array (
                'key' => 'field_52ab9c4b41f9f',
                'label' => __('Drive'),
                'name' => 'rally_drive',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_52ab9c5c41fa0',
                'label' => __('Auth Token'),
                'name' => 'rally_auth_token',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_52ab9ca541fa1',
                'label' => __('Frequency'),
                'name' => 'rally_frequency',
                'type' => 'number',
                'instructions' => __('The frequency at which Rally.org data is synced.'),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => 60,
                'max' => '',
                'step' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 0,
    ));
}
