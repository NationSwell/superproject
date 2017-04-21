<?php
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_google-apis',
        'title' => 'Google APIs',
        'fields' => array (
            array (
                'key' => 'field_529fbd12a1cdd',
                'label' => __('API Key'),
                'name' => 'google_api_key',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_529fbd27a1cde',
                'label' => __('Client Id'),
                'name' => 'google_client_id',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
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

