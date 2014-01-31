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
            array (
                'key' => 'field_52961750301b1',
                'label' => 'Flyout Header Text',
                'name' => 'flyout_header_text',
                'type' => 'text',
                'conditional_logic' => array (
                    'status' => 1,
                    'rules' => array (
                        array (
                            'field' => 'field_5293ab9ca6467',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'default_value' => 'Go Social!',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_52961774301b2',
                'label' => 'Flyout Message Text',
                'name' => 'flyout_message_text',
                'type' => 'text',
                'conditional_logic' => array (
                    'status' => 1,
                    'rules' => array (
                        array (
                            'field' => 'field_5293ab9ca6467',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'default_value' => 'Like NationSwell on Facebook',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_52cb112aad84b',
                'label' => 'Flyout Opt Out Button Text',
                'name' => 'flyout_opt_out_button_text',
                'type' => 'text',
                'default_value' => 'don\'t show again',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_52d04111b7b8e',
                'label' => 'Opt Out Expiration',
                'name' => 'flyout_facebook_opt_out_expiration',
                'instructions' => 'The number of days that a user won\'t see a flyout if they click opt-out',
                'type' => 'number',
                'conditional_logic' => array (
                    'status' => 1,
                    'rules' => array (
                        array (
                            'field' => 'field_5293ab9ca6467',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'default_value' => '5',
                'placeholder' => 'x days',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
            array (
                'key' => 'field_529617ac301b3',
                'label' => 'Facebook Like Url',
                'name' => 'facebook_like_url',
                'type' => 'text',
                'conditional_logic' => array (
                    'status' => 1,
                    'rules' => array (
                        array (
                            'field' => 'field_5293ab9ca6467',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'default_value' => 'http://nationswell.com',
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
            'layout' => 'default',
            'hide_on_screen' => array(),
        ),
        'menu_order' => 0,
    ));
}
