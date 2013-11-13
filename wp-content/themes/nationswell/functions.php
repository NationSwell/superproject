<?php

add_theme_support('post-formats');
add_theme_support('post-thumbnails');
add_theme_support('menus');

add_filter('get_twig', 'add_to_twig');
add_filter('timber_context', 'add_to_context');

add_action('wp_enqueue_scripts', 'load_scripts');

define('THEME_URL', get_template_directory_uri());
function add_to_context($data)
{
    /* this is where you can add your own data to Timber's context object */
    $data['qux'] = 'I am a value set in your functions.php file';
    $data['menu'] = new TimberMenu();

    return $data;
}

function add_to_twig($twig)
{
    /* this is where you can add your own fuctions to twig */
    $twig->addExtension(new Twig_Extension_StringLoader());
    $twig->addFilter('myfoo', new Twig_Filter_Function('myfoo'));

    return $twig;
}

function myfoo($text)
{
    $text .= ' bar!';

    return $text;
}

function load_scripts()
{
    wp_enqueue_script('jquery');
}

// Custom Taxonomies
include_once('lib/taxonomies/series.php');

function my_register_fields()
{
    include_once('lib/fields/attachment.php');
    include_once('lib/fields/home_page.php');
    include_once('lib/fields/story_header.php');
    include_once('lib/fields/story_content.php');
}

add_action('acf/register_fields', 'my_register_fields');

// Shortcodes
include_once('lib/shortcodes/placeholder.php');

include_once('lib/classes/NationSwellPost.php');

// Configure Menus
include_once('lib/menu/menu.php');

// Configure Sidebar
include_once('lib/sidebar/sidebar.php');

// Custom Widgets
include_once('lib/widgets/widgets.php');

// Plugin Activation
include_once('lib/tgm-plugin-activation/tgm-config.php');
