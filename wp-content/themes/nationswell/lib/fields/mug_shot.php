<?php
if(function_exists("register_field_group"))
{
    register_field_group(array (
            'id' => 'acf_mug-shot',
            'title' => 'Mug Shot',
            'fields' => array (
                array (
                    'key' => 'field_5283dc174a34b',
                    'label' => __('Mug Shot'),
                    'name' => 'mug_shot',
                    'type' => 'image',
                    'save_format' => 'object',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                ),
            ),
            'location' => array (
                array (
                    array (
                        'param' => 'ef_user',
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
