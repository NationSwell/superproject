<?php
// Enable Widget Areas
if (function_exists('register_sidebar')) {
    register_sidebar(
        array(
            'name' => 'Story Sidebar',
            'id' => 'sidebar-story',
            'description' => 'Widget Area',
        )
    );

    register_sidebar(
        array(
            'name' => 'Homepage Sidebar 1',
            'id' => 'sidebar-homepage-1',
            'description' => 'Widget Area',
        )
    );

    register_sidebar(
        array(
            'name' => 'Homepage Sidebar 2',
            'id' => 'sidebar-homepage-2',
            'description' => 'Widget Area',
        )
    );

    register_sidebar(
        array(
            'name' => 'Homepage Sidebar 3',
            'id' => 'sidebar-homepage-3',
            'description' => 'Widget Area',
        )
    );
}