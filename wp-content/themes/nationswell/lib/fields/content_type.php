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
                        'photo' => 'Photo',
                        'listory' => 'Listory',
                    ),
                    'default_value' => 'story',
                    'allow_null' => 0,
                    'multiple' => 0,
                ),
                array (
                    'key' => 'field_52ab92a8a2c3a',
                    'label' => 'Story Kind',
                    'name' => 'story_kind',
                    'type' => 'select',
                    'choices' => array (
                        'original' => 'NationSwell Original',
                        'curated' => 'Curated',
                    ),
                    'default_value' => 'original',
                    'allow_null' => 0,
                    'multiple' => 0,
                ),
                array (
                    'key' => 'field_52ab92e2a2c3b',
                    'label' => 'Source',
                    'name' => 'source',
                    'type' => 'website',
                    'conditional_logic' => array (
                        'status' => 1,
                        'rules' => array (
                            array (
                                'field' => 'field_52ab92a8a2c3a',
                                'operator' => '==',
                                'value' => 'curated',
                            ),
                        ),
                        'allorany' => 'all',
                    ),
                    'website_title' => 1,
                    'internal_link' => 1,
                    'output_format' => 0,
                    'default_value' => '',
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
                'layout' => 'default',
                'hide_on_screen' => array (
                ),
            ),
            'menu_order' => 20,
        ));
}
