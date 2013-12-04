<?php
if (function_exists("register_field_group")) {
    register_field_group(array(
        'id' => 'acf_facebook-admin',
        'title' => 'Facebook Admin',
        'fields' => array(
            array(
                'key' => 'field_529eb42a37425',
                'label' => 'Facebook Admin',
                'name' => 'facebook_admin',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_529eb43737426',
                        'label' => 'Facebook Admin Id',
                        'name' => 'facebook_user_id',
                        'type' => 'text',
                        'column_width' => '',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'none',
                        'maxlength' => '',
                    ),
                ),
                'row_min' => '',
                'row_limit' => '',
                'layout' => 'table',
                'button_label' => 'Add Row',
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
            'layout' => 'default',
            'hide_on_screen' => array(),
        ),
        'menu_order' => 0,
    ));
}
