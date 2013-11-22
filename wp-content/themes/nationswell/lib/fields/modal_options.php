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
        )
    );
}
