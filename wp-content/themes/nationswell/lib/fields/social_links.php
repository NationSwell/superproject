<?php
if (function_exists("register_field_group")) {
    register_field_group(
        array(
            'id' => 'acf_nationswell-social-links',
            'title' => 'NationSwell Social Links',
            'fields' => array(
                array(
                    'key' => 'field_5290cf1df0362',
                    'label' => 'NationSwell Facebook',
                    'name' => 'nationswell_facebook',
                    'type' => 'text',
                    'default_value' => 'https://www.facebook.com/nationswell',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5290cf2ff0363',
                    'label' => 'NationSwell Twitter',
                    'name' => 'nationswell_twitter',
                    'type' => 'text',
                    'default_value' => 'https://twitter.com/nationswell',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5290cf48f0364',
                    'label' => 'NationSwell Instagram',
                    'name' => 'nationswell_instagram',
                    'type' => 'text',
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5290cf58f0365',
                    'label' => 'NationSwell Tubmlr',
                    'name' => 'nationswell_tubmlr',
                    'type' => 'text',
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5290cfa2f0366',
                    'label' => 'NationSwell Google+',
                    'name' => 'nationswell_google',
                    'type' => 'text',
                    'default_value' => '',
                    'placeholder' => '',
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
                'layout' => 'default',
                'hide_on_screen' => array(),
            ),
            'menu_order' => 0,
        )
    );
}
