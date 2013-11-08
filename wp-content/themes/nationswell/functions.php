<?php
add_theme_support('post-formats');
add_theme_support('post-thumbnails');
add_theme_support('menus');

add_filter('get_twig', 'add_to_twig');
add_filter('timber_context', 'add_to_context');

add_action('wp_enqueue_scripts', 'load_scripts');

define('THEME_URL', get_template_directory_uri());
function add_to_context($data){
    /* this is where you can add your own data to Timber's context object */
    $data['qux'] = 'I am a value set in your functions.php file';
    $data['menu'] = new TimberMenu();
    return $data;
}

function add_to_twig($twig){
    /* this is where you can add your own fuctions to twig */
    $twig->addExtension(new Twig_Extension_StringLoader());
    $twig->addFilter('myfoo', new Twig_Filter_Function('myfoo'));
    return $twig;
}

function myfoo($text){
    $text .= ' bar!';
    return $text;
}

function load_scripts(){
    wp_enqueue_script('jquery');
}

// Custom Taxonomies
include_once('taxonomies/series.php');

// Timber
include_once('lib/plugins/timber/timber.php');

// Custom Fields
include_once('lib/plugins/advanced-custom-fields/acf.php');

function my_register_fields() {
    include_once('lib/plugins/acf-flexible-content/flexible-content.php');
    include_once('fields/attachment.php');
    include_once('fields/home_page.php');
    include_once('fields/story_header.php');
}
add_action('acf/register_fields', 'my_register_fields');


class NationSwellPost extends TimberPost {
    private $story_header_cache = null;


    function story_header() {
        if($this->story_header_cache == null) {

            $this->story_header_cache = array();
            while(has_sub_field("story_page_header", $this->ID)) {
                $layout = get_row_layout();
                $item = array(
                    'type' => $layout
                );
                if($layout == "image") { // layout: Content
                    $item = array_merge(get_sub_field('image'), $item);
                    $item['credit'] = get_field('credit', $item['id']);
                }
                elseif($layout == "video") { // layout: File
                    $item['video_url'] = get_sub_field('video_url');
                }

                $this->story_header_cache[] = $item;
            }
        }

        return $this->story_header_cache;
    }
}
