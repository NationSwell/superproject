<?php

if (function_exists("register_field_group")) {
    register_field_group(
        array(
            'id' => 'acf_modals',
            'title' => 'Modals',
            'fields' => array(
                array(
                    'key' => 'field_528ecf1821ebf',
                    'label' => __('Enabled Join Us Modal'),
                    'name' => 'modal_joinus_enabled',
                    'type' => 'true_false',
                    'message' => '',
                    'default_value' => 1,
                ),
                array (
                    'key' => 'field_529d3c02a8bce',
                    'label' => 'Modal Header',
                    'name' => 'modal_joinus_header',
                    'type' => 'text',
                    'default_value' => 'Join Us',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                    'conditional_logic' => array (
                        'status' => 1,
                        'rules' => array (
                            array (
                                'field' => 'field_528ecf1821ebf',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                        'allorany' => 'all',
                    ),
                ),
                array (
                    'key' => 'field_529d3c3ba8bcf',
                    'label' => 'Modal Body Text',
                    'name' => 'modal_joinus_body_text',
                    'type' => 'text',
                    'default_value' => 'Meet the people renewing America. Join the movement.',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                    'conditional_logic' => array (
                        'status' => 1,
                        'rules' => array (
                            array (
                                'field' => 'field_528ecf1821ebf',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                        'allorany' => 'all',
                    ),
                ),
                array (
                    'key' => 'field_529d3c53a8bd0',
                    'label' => 'Modal Opt Out Text',
                    'name' => 'modal_joinus_opt_out_text',
                    'type' => 'text',
                    'default_value' => 'Already following and subscribing to us?',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                    'conditional_logic' => array (
                        'status' => 1,
                        'rules' => array (
                            array (
                                'field' => 'field_528ecf1821ebf',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                        'allorany' => 'all',
                    ),
                ),
                array (
                    'key' => 'field_529d3c84a8bd1',
                    'label' => 'Modal Opt Out Button Text',
                    'name' => 'modal_joinus_opt_out_button_text',
                    'type' => 'text',
                    'default_value' => 'Don\'t ask again.',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                    'conditional_logic' => array (
                        'status' => 1,
                        'rules' => array (
                            array (
                                'field' => 'field_528ecf1821ebf',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                        'allorany' => 'all',
                    ),
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
