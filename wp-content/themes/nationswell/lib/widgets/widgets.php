<?php
// Enable Widget Areas
if (function_exists('register_sidebar')) {
    register_sidebar(
        array(
            'name' => 'Story Sidebar',
            'id' => 'sidebar_story',
            'description' => 'Widget Area',
        )
    );

    register_sidebar(
        array(
            'name' => 'Homepage Sidebar 1',
            'id' => 'sidebar_homepage_1',
            'description' => 'Widget Area',
        )
    );

    register_sidebar(
        array(
            'name' => 'Homepage Sidebar 2',
            'id' => 'sidebar_homepage_2',
            'description' => 'Widget Area',
        )
    );

    register_sidebar(
        array(
            'name' => 'Homepage Sidebar 3',
            'id' => 'sidebar_homepage_3',
            'description' => 'Widget Area',
        )
    );

    register_sidebar(
        array(
            'name' => 'Information Page Sidebar',
            'id' => 'sidebar_static',
            'description' => 'Widget Area',
        )
    );

}