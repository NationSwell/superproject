<?php
if(function_exists("register_field_group"))
{
    register_field_group(array (
            'id' => 'acf_taxonomy-fields',
            'title' => 'Taxonomy Fields',
            'fields' => array (
                array (
                    'key' => 'field_528a754c81c99',
                    'label' => __('Header Image'),
                    'name' => 'header_image',
                    'type' => 'image',
                    'save_format' => 'object',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                ),
            ),
            'location' => array (
                array (
                    array (
                        'param' => 'ef_taxonomy',
                        'operator' => '==',
                        'value' => 'all',
                        'order_no' => 0,
                        'group_no' => 0,
                    ),
                ),
            ),
            'options' => array (
                'position' => 'normal',
                'layout' => 'no_box',
                'hide_on_screen' => array (
                ),
            ),
            'menu_order' => 0,
        ));
}
