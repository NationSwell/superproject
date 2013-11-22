<?php

if (WP_DEBUG && WP_DEBUG_DISPLAY)
{
    ini_set('error_reporting', E_ALL & ~E_STRICT & ~E_DEPRECATED);
}

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
    $data['menu_main'] = new TimberMenu('menu_main');
    $data['menu_footer'] = new TimberMenu('menu_footer');
    $data['menu_topic'] = new TimberMenu('menu_topic');

    $data['nationswell_mailchimp_daily'] = get_field('nationswell_mailchimp_daily', 'option');

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

function setup_series_query($query) {
    // not an admin page and it is the main query
    if (is_tax('series') && $query->is_main_query()){
        // show 50 posts on series pages
        $query->set('posts_per_page', 50);
    }
}

add_action('pre_get_posts', 'setup_series_query');

include_once('lib/taxonomies/series.php');

function my_register_fields()
{
    include_once('lib/fields/attachment.php');
    include_once('lib/fields/taxonomy.php');
    include_once('lib/fields/home_page.php');
    include_once('lib/fields/mug_shot.php');
    include_once('lib/fields/social_accounts.php');
    include_once('lib/fields/social_sharing.php');
    include_once('lib/fields/dek.php');
    include_once('lib/fields/content_type.php');
    include_once('lib/fields/hero.php');
    include_once('lib/fields/story_content.php');
    include_once('lib/fields/call_to_action.php');
    include_once('lib/fields/call_to_action_link.php');
    include_once('lib/fields/tout_options.php');

    include_once('lib/fields/mailing_lists.php');
}

add_action('acf/register_fields', 'my_register_fields');

// Shortcodes
include_once('lib/shortcodes/placeholder.php');

include_once('lib/classes/ChangeOrgApi.php');
include_once('lib/classes/ChangeOrgPetition.php');
include_once('lib/classes/CallToAction.php');
include_once('lib/classes/NationSwellPost.php');


// Configure Menus
include_once('lib/menu/menu.php');

// Custom Widgets
include_once('lib/widgets/widgets.php');
include_once('lib/widgets/widget-joinus.php');
include_once('lib/widgets/widget-subscribe.php');
include_once('lib/widgets/widget-story.php');

// Plugin Activation
include_once('lib/tgm-plugin-activation/tgm-config.php');

// Custom Post Types
include_once('lib/custom_post_types/call_to_action.php');


// Change.org
global $change_org_api;

$change_org_api_key = '937ae45924510660d19d71f3622aee68810b8e8969c418da92afdde2e618be8f';
$change_org_secret = '9955d60df46358b12c33646352e54c50a28ea2f54fdc45fe4d7457307d847cf5';
$source = 'nationswell.com';
$description = 'Meet the People Renewing America. Join the Movement.';
$change_org_api= new ChangeOrgApi($change_org_api_key, $change_org_secret, $source, $description);

function is_petition($cta_id) {
    return get_post_meta($cta_id, 'type', true) === 'petition';
}

function save_petition_data($cta_id) {
    global $change_org_api;

    if ($_POST['post_type'] === 'ns_call_to_action' && is_petition($cta_id)) {
        $petition = new ChangeOrgPetition($cta_id, $change_org_api);
        $petition->fetch();
    }
}

add_action( 'acf/save_post', 'save_petition_data', 20);

function handle_sign_petition() {
    global $change_org_api;

    $cta_id = (int)$_REQUEST['cta_id'];

    if(is_petition($cta_id)) {
        $petition = new ChangeOrgPetition($cta_id, $change_org_api);
        $response = $petition->sign();
        wp_send_json($response);
    }
    else {
        http_response_code(404);
    }
    die();
}

add_action('wp_ajax_sign_petition', 'handle_sign_petition');
add_action('wp_ajax_nopriv_sign_petition', 'handle_sign_petition');


// Automatically Create the Inital Pages for the Site and set the Homepage to be the Front Page
if (isset($_GET['activated']) && is_admin()){
    add_action('init', 'create_initial_pages');
}

function create_initial_pages() {
    $pages = array(
        'home' => 'Home',
        'about' => 'About',
        'contact' => 'Contact',
        'advertise' => 'Advertise',
        'termsofservice' => 'Terms of Service',
        'privacy' => 'Privacy Policy',
        'jobs' => 'Jobs'
    );
    foreach($pages as $key => $value) {
        $id = get_page_by_title($value);
        $page = array(
            'post_type'   => 'page',
            'post_title'  => $value,
            'post_name'   => $key,
            'post_status' => 'publish',
            'post_author' => 1,
            'post_parent' => ''
        );
        if (!isset($id)) {
            $post_id = wp_insert_post($page);
            update_post_meta($post_id, '_wp_page_template', 'page-static.php');

            if($value == 'Home') {
                update_option( 'show_on_front', 'page' );
                update_option( 'page_on_front', $post_id);
            }

        }
    };
}