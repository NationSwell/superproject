<?php
if ( function_exists( "register_field_group" )) {
    register_field_group( array(
        'id' => 'acf_editors_picks_posts',
        'title' => 'Editor\'s Picks Posts',
        'fields' => array(
            array(
                'key' => 'field__793f26591dq4p',
                'label' => 'Editor\'s Picks Posts',
                'name' => 'editors_picks_posts',
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
                    'value' => 'ns_editors_picks',
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
