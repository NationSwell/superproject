<?php
if(function_exists("register_field_group"))
{
    register_field_group(array (
            'id' => 'acf_social-accounts',
            'title' => 'Social Accounts',
            'fields' => array (
                array (
                    'key' => 'field_527417470e5a9',
                    'label' => __('Twitter'),
                    'name' => 'twitter_username',
                    'type' => 'text',
                    'default_value' => '',
                    'placeholder' => 'username',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array (
                    'key' => 'field_527417530e5aa',
                    'label' => __('Facebook'),
                    'name' => 'facebook_username',
                    'type' => 'text',
                    'default_value' => '',
                    'placeholder' => 'username',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array (
                    'key' => 'field_5274175c0e5ab',
                    'label' => __('Instagram'),
                    'name' => 'instagram',
                    'type' => 'text',
                    'default_value' => '',
                    'placeholder' => 'username',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array (
                    'key' => 'field_5274176a0e5ac',
                    'label' => __('Google+'),
                    'name' => 'google',
                    'type' => 'text',
                    'default_value' => '',
                    'placeholder' => 'https://plus.google.com/xxxxxxxxxx/',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array (
                    'key' => 'field_5283e100bce59',
                    'label' => __('Tumblr'),
                    'name' => 'tumblr',
                    'type' => 'text',
                    'default_value' => '',
                    'placeholder' => 'http://example.tumblr.com',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'html',
                    'maxlength' => '',
                ),
            ),
            'location' => array (
                array (
                    array (
                        'param' => 'ef_user',
                        'operator' => '==',
                        'value' => 'all',
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
            'menu_order' => 20,
        ));
}
