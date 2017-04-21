<?php
if(function_exists("register_field_group"))
{
    register_field_group(array (
            'id' => 'acf_hero',
            'title' => 'Hero',
            'fields' => array (
//                array (
//                    'key' => 'field_52a22c48221a3',
//                    'label' => 'Enable Small Hero',
//                    'name' => 'enable_small_hero',
//                    'type' => 'true_false',
//                    'instructions' => 'Use this option if you have an image which you want to appear in the center copy column on a Story page.',
//                    'message' => '',
//                    'default_value' => 0,
//                ),
                array (
                    'key' => 'field_52a3d9818d832',
                    'label' => 'Hero Type',
                    'name' => 'hero_type',
                    'type' => 'select',
                    'choices' => array (
                        'small' => 'Small Hero',
                        'cover' => 'Cover Hero',
                    ),
                    'default_value' => '',
                    'allow_null' => 1,
                    'multiple' => 0,
                ),
                array (
                    'key' => 'field_52742d44fb739',
                    'label' => __('Hero'),
                    'name' => 'hero',
                    'type' => 'flexible_content',
                    'layouts' => array (
                        array (
                            'label' => __('Image'),
                            'name' => 'image',
                            'display' => 'row',
                            'min' => '',
                            'max' => '',
                            'sub_fields' => array (
                                array (
                                    'key' => 'field_52742d6cfb73a',
                                    'label' => __('Image'),
                                    'name' => 'image',
                                    'type' => 'image',
                                    'column_width' => '',
                                    'save_format' => 'object',
                                    'preview_size' => 'thumbnail',
                                    'library' => 'all',
                                ),
                            ),
                        ),
                        array (
                            'label' => __('Video'),
                            'name' => 'video',
                            'display' => 'row',
                            'min' => '',
                            'max' => '',
                            'sub_fields' => array (
                                array (
                                    'key' => 'field_52742d8ffb73c',
                                    'label' => __('Video URL'),
                                    'name' => 'video_url',
                                    'type' => 'text',
                                    'column_width' => '',
                                    'default_value' => '',
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'formatting' => 'html',
                                    'maxlength' => '',
                                ),
                                array (
                                    'key' => 'field_5286a66eeac48',
                                    'label' => __('Caption'),
                                    'name' => 'caption',
                                    'type' => 'text',
                                    'column_width' => '',
                                    'default_value' => '',
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'formatting' => 'none',
                                    'maxlength' => '',
                                ),
                                array (
                                    'key' => 'field_5286a67ceac49',
                                    'label' => __('Credit'),
                                    'name' => 'credit',
                                    'type' => 'text',
                                    'column_width' => '',
                                    'default_value' => '',
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'formatting' => 'none',
                                    'maxlength' => '',
                                ),
                            ),
                        ),
                    ),
                    'button_label' => 'Add Row',
                    'min' => '',
                    'max' => '',
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
                    )
                ),
            ),
            'options' => array (
                'position' => 'acf_after_title',
                'layout' => 'default',
                'hide_on_screen' => array (
                ),
            ),
            'menu_order' => 30,
        ));
}
