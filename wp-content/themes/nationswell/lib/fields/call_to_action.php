<?php
if (function_exists("register_field_group")) {
    register_field_group(
        array(
            'id' => 'acf_call-to-action',
            'title' => 'Call to Action',
            'fields' => array(
                array(
                    'key' => 'field_528bcb5146eda',
                    'label' => __('Type'),
                    'name' => 'type',
                    'type' => 'select',
                    'required' => 1,
                    'choices' => array(
                        'freeform' => 'Freeform',
                        'petition' => 'Change.org Petition',
                        'donation' => 'Rally Donation',
                        'subscribe' => 'MailChimp Signup',
                    ),
                    'default_value' => '',
                    'allow_null' => 0,
                    'multiple' => 0,
                ),
                array(
                    'key' => 'field_528bcfb546edb',
                    'label' => __('Tout Heading'),
                    'name' => 'tout_heading',
                    'type' => 'text',
                    'instructions' => __('Heading the appears in the Call to Action Sidebar Tout'),
                    'default_value' => '',
                    'placeholder' => 'Show your Support',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_528bd0d346edc',
                    'label' => __('Tout Sub Heading'),
                    'name' => 'tout_sub_heading',
                    'type' => 'text',
                    'instructions' => __('Sub heading the appears in the Call to Action Sidebar Tout'),
                    'default_value' => '',
                    'placeholder' => 'Donate to the New Energy Economy',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_528bf225d4221',
                    'label' => __('Heading'),
                    'name' => 'heading',
                    'type' => 'text',
                    'instructions' => __('This appears in the Panel'),
                    'default_value' => '',
                    'placeholder' => 'Donate to Change.org',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_528bd2c346ede',
                    'label' => __('Description'),
                    'name' => 'description',
                    'type' => 'wysiwyg',
                    'instructions' => __(
                        'Describe this action to the user. This field appears in the Take Action Panel'
                    ),
                    'conditional_logic' => array(
                        'status' => 1,
                        'rules' => array(
                            array(
                                'field' => 'field_528bcb5146eda',
                                'operator' => '==',
                                'value' => 'freeform',
                            ),
                            array(
                                'field' => 'field_528bcb5146eda',
                                'operator' => '==',
                                'value' => 'donation',
                            ),
                        ),
                        'allorany' => 'any',
                    ),
                    'default_value' => '',
                    'toolbar' => 'basic',
                    'media_upload' => 'no',
                ),
                array(
                    'key' => 'field_528bd11746edd',
                    'label' => __('Image'),
                    'name' => 'image',
                    'type' => 'image',
                    'instructions' => __('Image the appears in the Take Action Panel'),
                    'conditional_logic' => array(
                        'status' => 1,
                        'rules' => array(
                            array(
                                'field' => 'field_528bcb5146eda',
                                'operator' => '==',
                                'value' => 'freeform',
                            ),
                            array(
                                'field' => 'field_528bcb5146eda',
                                'operator' => '==',
                                'value' => 'donation',
                            ),
                        ),
                        'allorany' => 'any',
                    ),
                    'save_format' => 'object',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                ),
                array(
                    'key' => 'field_528bd34946edf',
                    'label' => __('External LInk'),
                    'name' => 'external_link',
                    'type' => 'text',
                    'instructions' => __('A link to an external web page. This field appears in the Take Action Panel'),
                    'conditional_logic' => array(
                        'status' => 1,
                        'rules' => array(
                            array(
                                'field' => 'field_528bcb5146eda',
                                'operator' => '==',
                                'value' => 'freeform',
                            ),
                        ),
                        'allorany' => 'all',
                    ),
                    'default_value' => '',
                    'placeholder' => 'http://www.redcross.org',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_528bd7735938b',
                    'label' => __('Rally Id'),
                    'name' => 'rally_id',
                    'type' => 'text',
                    'instructions' => __(
                        'The Rally ID from https://rally.org/ You can get this from the URL of a rally page.'
                    ),
                    'conditional_logic' => array(
                        'status' => 1,
                        'rules' => array(
                            array(
                                'field' => 'field_528bcb5146eda',
                                'operator' => '==',
                                'value' => 'donation',
                            ),
                        ),
                        'allorany' => 'all',
                    ),
                    'default_value' => '',
                    'placeholder' => '03QPrMvQzn5',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_528bd8175938c',
                    'label' => __('Change.org URL'),
                    'name' => 'change_url',
                    'type' => 'text',
                    'instructions' => __('The URL of a Petition on Change.org'),
                    'conditional_logic' => array(
                        'status' => 1,
                        'rules' => array(
                            array(
                                'field' => 'field_528bcb5146eda',
                                'operator' => '==',
                                'value' => 'petition',
                            ),
                        ),
                        'allorany' => 'all',
                    ),
                    'default_value' => '',
                    'placeholder' => 'http://www.change.org/petitions/nationswell-create-a-call-to-action',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_528bd87f5938d',
                    'label' => __('MailChimp ID'),
                    'name' => 'mailchimp_id',
                    'type' => 'text',
                    'instructions' => __(
                        'The form action string from MailChimp. This is a long URL that you need to get out of an embeddable MailChimp subscribe form.'
                    ),
                    'conditional_logic' => array(
                        'status' => 1,
                        'rules' => array(
                            array(
                                'field' => 'field_528bcb5146eda',
                                'operator' => '==',
                                'value' => 'subscribe',
                            ),
                        ),
                        'allorany' => 'all',
                    ),
                    'default_value' => '',
                    'placeholder' => 'http://ronikdesign.us5.list-manage.com/subscribe/post?u=b98ffb95799b26d50c42d8be2&id=34499b765e',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_528bddd2d2efd',
                    'label' => __('Freeform Type'),
                    'name' => 'freeform_type',
                    'type' => 'select',
                    'instructions' => __('This determines the Icon that appears along with the Take Action Panel'),
                    'required' => 1,
                    'conditional_logic' => array(
                        'status' => 1,
                        'rules' => array(
                            array(
                                'field' => 'field_528bcb5146eda',
                                'operator' => '==',
                                'value' => 'freeform',
                            ),
                        ),
                        'allorany' => 'all',
                    ),
                    'choices' => array(
                        'link' => 'Link',
                        'purchase' => 'Purchase',
                    ),
                    'default_value' => '',
                    'allow_null' => 0,
                    'multiple' => 0,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'ns_call_to_action',
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
        )
    );
}
