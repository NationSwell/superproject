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
            'id' => 'acf_story-page-header',
            'title' => 'Story Page Header',
            'fields' => array (
                array (
                    'key' => 'field_527c0555270ef',
                    'label' => 'Dek',
                    'name' => 'dek',
                    'type' => 'text',
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'formatting' => 'none',
                ),
                array (
                    'key' => 'field_52742d44fb739',
                    'label' => 'Story Page Header',
                    'name' => 'story_page_header',
                    'type' => 'flexible_content',
                    'layouts' => array (
                        array (
                            'label' => 'Image',
                            'name' => 'image',
                            'display' => 'row',
                            'sub_fields' => array (
                                array (
                                    'key' => 'field_52742d6cfb73a',
                                    'label' => 'Image',
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
                                    'key' => 'field_52742d8ffb73c',
                                    'label' => 'Video URL',
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
                            ),
                        ),
                    ),
                    'button_label' => 'Add Row',
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
