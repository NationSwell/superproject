<?php
if ( function_exists( "register_field_group" )) {
    register_field_group( array(
        'id' => 'acf_ns_series',
        'title' => 'Nationswell Series',
        'fields' => array(
            array (
                'key' => 'field_112t64432yp9z',
                'label' => __('Header Image'),
                'name' => 'header_image',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_556k89334we2f',
                'label' => __('Disable Series Icon'),
                'name' => 'disable_series',
                'type' => 'true_false',
                'instructions' => 'Prevents the series icon from displaying in the header image.',
                'message' => '',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_539h00184m7k',
                'label' => 'Description',
                'name' => 'description',
                'type' => 'wysiwyg',
                'instructions' => '',
                'default_value' => '',
                'toolbar' => 'basic',
                'media_upload' => 'no',
            ),
            array(
                'key' => 'field__683g79441q0i',
                'label' => 'Series Posts',
                'name' => 'ns_series_posts',
                'type' => 'relationship',
                'return_format' => 'id',
                'post_type' => array(
                    0 => 'post',
                ),
                'taxonomy' => array(
                    0 => 'all',
                ),
                'filters' => array(
                    0 => 'search',
                ),
                'result_elements' => array(
                    0 => 'featured_image',
                    1 => 'post_type',
                    2 => 'post_title',
                ),
                'max' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'ns_series',
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
