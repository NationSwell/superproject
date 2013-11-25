<?php
if(function_exists("register_field_group"))
{
    register_field_group(array (
            'id' => 'acf_content-type',
            'title' => 'Content Type',
            'fields' => array (
                array (
                    'key' => 'field_5286879ca3e12',
                    'label' => __('Content Type'),
                    'name' => 'content_type',
                    'type' => 'select',
                    'choices' => array (
                        'story' => 'Story',
                        'video' => 'Video',
                        'audio' => 'Audio',
                        'slideshow' => 'Slideshow',
                    ),
                    'default_value' => 'story',
                    'allow_null' => 0,
                    'multiple' => 0,
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
            'menu_order' => 20,
        ));
}
