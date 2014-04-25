<?php
if(function_exists("register_field_group"))
{
    register_field_group(array (
            'id' => 'acf_dek',
            'title' => 'Dek',
            'fields' => array (
                array (
                    'key' => 'field_5286a473ab5fc',
                    'label' => __('Dek'),
                    'name' => 'dek',
                    'type' => 'text',
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
            ),
            'location' => array (
                array (
                    array (
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'post',
                        'order_no' => 0,
                        'group_no' => 0,
                    ),
                ),
            ),
            'options' => array (
                'position' => 'acf_after_title',
                'layout' => 'no_box',
                'hide_on_screen' => array (
                ),
            ),
            'menu_order' => 0,
        ));
}
