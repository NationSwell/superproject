<?php
if (function_exists("register_field_group")) {
    register_field_group(
        array(
            'id' => 'acf_council_event',
            'title' => 'NSC Event',
            'fields' => array(

                array(
                    'key' => 'field_619dp347s7752',
                    'label' => 'Date',
                    'name' => 'event_date',
                    'type' => 'date_picker',
                    'instructions' => 'The date and time of this event.',
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_892lo223w9006',
                    'label' => 'Time',
                    'name' => 'event_time',
                    'type' => 'text',
                    'instructions' => 'The time of day this event will occur.',
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_100fp496o1138',
                    'label' => 'Location',
                    'name' => 'location',
                    'type' => 'text',
                    'instructions' => 'The location of this event.',
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_349te699q6883',
                    'label' => 'Event Description',
                    'name' => 'description',
                    'type' => 'wysiwyg',
                    'instructions' => '',
                    'default_value' => '',
                    'toolbar' => 'basic',
                    'media_upload' => 'no',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'nscevent',
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