<?php
if (function_exists("register_field_group")) {
    register_field_group(array(
        'id' => 'acf_touts',
        'title' => 'Tout Options',
        'fields' => array(
            array(
                'key' => 'field_528e25e88c006',
                'label' => __('Tout Heading'),
                'name' => 'tout_heading',
                'type' => 'text',
                'instructions' => __('This appears in story touts wherever stories are listed.'),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => 20,
            ),
            array(
                'key' => 'field_528e2a6d8c007',
                'label' => __('Tout Dek'),
                'name' => 'tout_dek',
                'type' => 'text',
                'instructions' => __('This appears in story touts wherever stories are listed'),
                'default_value' => '',
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
            'layout' => 'no_box',
            'hide_on_screen' => array(),
        ),
        'menu_order' => 0,
    ));
}
