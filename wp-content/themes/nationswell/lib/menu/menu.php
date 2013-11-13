<?php
// Register Navigation Menus
function custom_navigation_menus()
{
    register_nav_menus(
        array(
            'menu_main' => 'Main Menu',
            'menu_footer' => 'Footer Menu',
            'menu_topic' => 'Topic Menu',
        )
    );
}

// Hook into the 'init' action
add_action('init', 'custom_navigation_menus');
?>