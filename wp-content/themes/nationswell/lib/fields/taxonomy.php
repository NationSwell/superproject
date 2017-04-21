<?php
if(function_exists("register_field_group"))
{
    register_field_group(array (
            'id' => 'acf_taxonomy-fields',
            'title' => 'Taxonomy Fields',
            'fields' => array (
                array (
                    'key' => 'field_54e27635897f4',
                    'label' => '',
                    'name' => 'display_desc',
                    'type' => 'checkbox',
                	'choices' => array(
					'1'	=> 'Display category description?'
					),
                	'default_value' => 0,
					'layout' => 'horizontal',
                ),
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
                    'key' => 'field_54e27635897f3',
                    'label' => 'Display custom title',
                    'name' => 'custom_title',
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
                
                 array(
                	'key' => 'field_54e27635897f5',
                	'label' => 'Partner options',
                	'name' => 'sponsored_category',
                	'type' => 'checkbox',
                	'choices' => array(
						'1'	=> 'This is a sponsored category or a category being published in partnership with a third party'
					),
                	'default_value' => 0,
					'layout' => 'horizontal',
				
            	),
                array(
                	'key' => 'field_54e27635897f6',
                	'label' => 'Category type',
                	'name' => 'category_type',
                	'type' => 'radio',
					'instructions' => 'Please choose the label that describes the type of this category.',
                	'message' => '',
                	'default_value' => 'In partnership with',
					'choices' => array(
						'Presented by'	=> 'Presented by',
						'In partnership with'	=> 'In partnership with',
						'Sponsored by'	=> 'Sponsored by',
					),
					'conditional_logic' => array(
                    	'status' => 1,
                    	'rules' => array(
                        	array(
                            	'field' => 'field_54e27635897f5',
                            	'operator' => '==',
                            	'value' => '1',
                        	),
                    	),
                    	'allorany' => 'all',
                	),
            	),
            	array(
                	'key' => 'field_54e27635897f7',
                	'label' => 'Sponsor/Partner name',
                	'name' => 'category_sponsor_name',
                	'type' => 'text',
                	'conditional_logic' => array(
                    	'status' => 1,
                    	'rules' => array(
                        	array(
                            	'field' => 'field_54e27635897f5',
                            	'operator' => '==',
                            	'value' => '1',
                        	),
                    	),
                    	'allorany' => 'all',
                	),
                	'default_value' => '',
                	'placeholder' => '',
                	'prepend' => '',
                	'append' => '',
                	'formatting' => 'html',
                	'maxlength' => '',
            	),
            	array(
                	'key' => 'field_54e27635897f8',
                	'label' => 'Sponsor/Partner link',
                	'name' => 'category_sponsor_link',
                	'type' => 'text',
                	'conditional_logic' => array(
                    	'status' => 1,
                    	'rules' => array(
                       	 array(
                            	'field' => 'field_54e27635897f5',
                            	'operator' => '==',
                            	'value' => '1',
                        	),
                   	 ),
                    'allorany' => 'all',
                	),
                	'default_value' => '',
                	'placeholder' => '',
                	'prepend' => '',
                	'append' => '',
                	'formatting' => 'html',
                	'maxlength' => '',
            	),
            	array(
                	'key' => 'field_54e27635897f9',
                	'label' => 'Sponsor/Partner Image',
                	'name' => 'category_sponsor_image',
                	'type' => 'image',
                	'conditional_logic' => array(
                    	'status' => 1,
                    	'rules' => array(
                        	array(
                            	'field' => 'field_54e27635897f5',
                            	'operator' => '==',
                            	'value' => '1',
                       		),
                    	),
                    	'allorany' => 'all',
                	),
                	'save_format' => 'id',
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
