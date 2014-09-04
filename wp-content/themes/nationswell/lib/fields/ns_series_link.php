<?php
if (function_exists("register_field_group")) {
    register_field_group(
        array(
            'id' => 'acf_link-to-an-ns-series',
            'title' => 'Link to an NS Series',
            'fields' => array(
                array(
                    'key' => 'field_468yh89201w01',
                    'label' => __('Nationswell Series Link'),
                    'name' => 'ns_series_link',
                    'type' => 'relationship',
                    'return_format' => 'object',
                    'post_type' => array(
                        0 => 'ns_series',
                    ),
                    'taxonomy' => array(
                        0 => 'all',
                    ),
                    'filters' => array(
                        0 => 'search',
                    ),
                    'result_elements' => array(
                        0 => 'post_type',
                        1 => 'post_title',
                    ),
                    'max' => 1,
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
        )
    );
}
