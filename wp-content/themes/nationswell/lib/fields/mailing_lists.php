<?php
if (function_exists("register_field_group")) {
    register_field_group(array(
        'id' => 'acf_mailing-lists',
        'title' => 'Mailing Lists',
        'fields' => array(
            array(
                'key' => 'field_528ea7f983c37',
                'label' => __('NationSwell MailChimp Daily'),
                'name' => 'nationswell_mailchimp_daily',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => 'http://nationswell.us6.list-manage1.com/subscribe/post?u=5f8740745b&id=6efe0731ab',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
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
