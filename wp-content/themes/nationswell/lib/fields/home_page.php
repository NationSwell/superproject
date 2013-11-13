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
            'id' => 'acf_home-page',
            'title' => 'Home Page',
            'fields' => array (
                array (
                    'key' => 'field_527ac8ad0f111',
                    'label' => 'Featured',
                    'name' => 'featured',
                    'type' => 'relationship',
                    'return_format' => 'id',
                    'post_type' => array (
                        0 => 'all',
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
                    'max' => 3,
                ),
                array (
                    'key' => 'field_527ac9320f112',
                    'label' => 'Series Carousel',
                    'name' => 'series_carousel',
                    'type' => 'flexible_content',
                    'layouts' => array (
                        array (
                            'label' => 'Series',
                            'name' => 'series',
                            'display' => 'row',
                            'sub_fields' => array (
                                array (
                                    'key' => 'field_527bf7bed7678',
                                    'label' => 'Series',
                                    'name' => 'series',
                                    'type' => 'taxonomy',
                                    'column_width' => '',
                                    'taxonomy' => 'series',
                                    'field_type' => 'radio',
                                    'allow_null' => 0,
                                    'load_save_terms' => 0,
                                    'return_format' => 'object',
                                    'multiple' => 0,
                                ),
                            ),
                        ),
                    ),
                    'button_label' => 'Add Series',
                ),
                array (
                    'key' => 'field_527acdd00f113',
                    'label' => 'Stories Carousel',
                    'name' => 'stories_carousel',
                    'type' => 'relationship',
                    'return_format' => 'id',
                    'post_type' => array (
                        0 => 'all',
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
            ),
            'location' => array (
                array (
                    array (
                        'param' => 'page_type',
                        'operator' => '==',
                        'value' => 'front_page',
                        'order_no' => 0,
                        'group_no' => 0,
                    ),
                ),
            ),
            'options' => array (
                'position' => 'normal',
                'layout' => 'no_box',
                'hide_on_screen' => array (
                    0 => 'the_content',
                ),
            ),
            'menu_order' => 0,
        ));
}
