<?php
/**
 *  Install Add-ons
 *
 *  The following code will include all 4 premium Add-Ons in your theme.
 *  Please do not attempt to include a file which does not exist. This will produce an error.
 *
 *  The following code assumes you have a folder 'add-ons' inside your theme.
 *
 *  IMPORTANT
 *  Add-ons may be included in a premium theme/plugin as outlined in the terms and conditions.
 *  For more information, please read:
 *  - http://www.advancedcustomfields.com/terms-conditions/
 *  - http://www.advancedcustomfields.com/resources/getting-started/including-lite-mode-in-a-plugin-theme/
 */

// Add-ons
// include_once('add-ons/acf-repeater/acf-repeater.php');
// include_once('add-ons/acf-gallery/acf-gallery.php');
// include_once('add-ons/acf-flexible-content/acf-flexible-content.php');
// include_once( 'add-ons/acf-options-page/acf-options-page.php' );


/**
 *  Register Field Groups
 *
 *  The register_field_group function accepts 1 array which holds the relevant data to register a field group
 *  You may edit the array as you see fit. However, this may result in errors if the array is not compatible with ACF
 */

if(function_exists("register_field_group"))
{
    register_field_group(array (
            'id' => 'acf_story-content',
            'title' => 'Story Content',
            'fields' => array (
                array (
                    'key' => 'field_52828faaf0ad5',
                    'label' => 'Story Content',
                    'name' => 'story_content',
                    'type' => 'flexible_content',
                    'layouts' => array (
                        array (
                            'label' => 'Image',
                            'name' => 'image',
                            'display' => 'row',
                            'sub_fields' => array (
                                array (
                                    'key' => 'field_52828fe8f0ad6',
                                    'label' => 'image',
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
                            'label' => 'Video',
                            'name' => 'video',
                            'display' => 'row',
                            'sub_fields' => array (
                                array (
                                    'key' => 'field_528292d7f0adc',
                                    'label' => 'Title',
                                    'name' => 'title',
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
                                    'key' => 'field_5282934cf0add',
                                    'label' => 'Video Url',
                                    'name' => 'video_url',
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
                                    'key' => 'field_5282935cf0ade',
                                    'label' => 'Credit',
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
                        array (
                            'label' => 'Pull Quote',
                            'name' => 'pull_quote',
                            'display' => 'row',
                            'sub_fields' => array (
                                array (
                                    'key' => 'field_528290fff0ada',
                                    'label' => 'Text',
                                    'name' => 'text',
                                    'type' => 'textarea',
                                    'column_width' => '',
                                    'default_value' => '',
                                    'placeholder' => '',
                                    'maxlength' => '',
                                    'formatting' => 'none',
                                ),
                                array (
                                    'key' => 'field_5282927cf0adb',
                                    'label' => 'Credit',
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
                        array (
                            'label' => 'Related',
                            'name' => 'related',
                            'display' => 'row',
                            'sub_fields' => array (
                                array (
                                    'key' => 'field_5282ac370fb35',
                                    'label' => 'Related Posts',
                                    'name' => 'related',
                                    'type' => 'relationship',
                                    'column_width' => '',
                                    'return_format' => 'id',
                                    'post_type' => array (
                                        0 => 'post',
                                    ),
                                    'taxonomy' => array (
                                        0 => 'all',
                                    ),
                                    'filters' => array (
                                        0 => 'search',
                                    ),
                                    'result_elements' => array (
                                        0 => 'post_type',
                                        1 => 'post_title',
                                    ),
                                    'max' => '',
                                ),
                                array (
                                    'key' => 'field_5282ad4c70f12',
                                    'label' => 'Position',
                                    'name' => 'position',
                                    'type' => 'select',
                                    'column_width' => '',
                                    'choices' => array (
                                        'inline' => 'Inline',
                                        'sidebar' => 'Sidebar',
                                    ),
                                    'default_value' => 'inline',
                                    'allow_null' => 0,
                                    'multiple' => 0,
                                ),
                            ),
                        ),
                    ),
                    'button_label' => 'Add Content',
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
                'position' => 'normal',
                'layout' => 'no_box',
                'hide_on_screen' => array (
                ),
            ),
            'menu_order' => 0,
        ));
}
