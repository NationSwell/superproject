<?php
if (function_exists("register_field_group")) {
    register_field_group(
        array(
            'id' => 'acf_social-sharing',
            'title' => 'Social Sharing',
            'fields' => array(
                array(
                    'key' => 'field_528d27a2afe91',
                    'label' => __('Facebook Share Text'),
                    'name' => 'facebook_share',
                    'type' => 'textarea',
                    'instructions' => __(
                        'Text entered here will appear in the facebook share box when a user clicks on a facebook share button.'
                    ),
                    'default_value' => '',
                    'placeholder' => 'Check out this Awesome Story on NationSwell',
                    'maxlength' => '',
                    'formatting' => 'none',
                ),
                array(
                    'key' => 'field_528d27f0afe92',
                    'label' => __('Twitter Share Text'),
                    'name' => 'twitter_share',
                    'type' => 'textarea',
                    'default_value' => '',
                    'placeholder' => 'Check out this Awesome Story on NationSwell',
                    'maxlength' => 140,
                    'formatting' => 'none',
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
        )
    );
}
