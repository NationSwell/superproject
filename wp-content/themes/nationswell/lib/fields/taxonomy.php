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
                array (
                    'key' => 'field_54e27635897f2',
                    'label' => 'Video Url',
                    'name' => 'video_url',
                    'type' => 'text',
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'html',
                    'maxlength' => '',
                ),
                array (
                    'key' => 'field_54e2764c0670c',
                    'label' => 'Video Caption',
                    'name' => 'video_caption',
                    'type' => 'text',
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'html',
                    'maxlength' => '',
                ),
                array (
                    'key' => 'field_54e276720670d',
                    'label' => 'Video Credit',
                    'name' => 'video_credit',
                    'type' => 'text',
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'html',
                    'maxlength' => '',
                ),
                array (
                    'key' => 'field_192w533t72d11',
                    'label' => __('Disable Series Icon'),
                    'name' => 'disable_series',
                    'type' => 'true_false',
                    'instructions' => 'Prevents the series icon from displaying in the header image.',
                    'message' => '',
                    'default_value' => 0,
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
