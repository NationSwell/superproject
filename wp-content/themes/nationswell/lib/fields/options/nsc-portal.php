<?php
if (function_exists("register_field_group")) {
    register_field_group(array(
        'id' => 'acf_password-protected-pages',
        'title' => 'password protected pages',
        'fields' => array(
            array(
                'key' => 'field_549872f1fa2ff',
                'label' => 'NSC Portal Password Page Welcome Copy',
                'name' => 'password_copy_welcome',
                'type' => 'text',
                'default_value' => 'Welcome to the NationSwell Council portal. If you are a member, please enter your password below to access information about events and fellow members.',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
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
