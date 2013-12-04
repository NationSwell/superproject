<?php

define('VERSION', file_get_contents(get_template_directory() . '/version.txt'));

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
    $data['version'] = VERSION;

    /* this is where you can add your own data to Timber's context object */
    $data['menu_main'] = new TimberMenu('menu_main');
    $data['menu_footer'] = new TimberMenu('menu_footer');
    $data['menu_topic'] = new TimberMenu('menu_topic');

    // Global Site Options
    $data['modal_joinus_enabled'] = get_field('modal_joinus_enabled', 'option');
    $data['flyout_social_enabled'] = get_field('flyout_social_enabled', 'option');
    $data['nationswell_mailchimp_daily'] = get_field('nationswell_mailchimp_daily', 'option');
    $data['nationswell_facebook'] = get_field('nationswell_facebook', 'option');
    $data['nationswell_twitter'] = get_field('nationswell_twitter', 'option');
    $data['nationswell_instagram'] = get_field('nationswell_instagram', 'option');
    $data['nationswell_tumblr'] = get_field('nationswell_tumblr', 'option');
    $data['nationswell_google'] = get_field('nationswell_google', 'option');
    $data['site_tag_line'] = get_field('site_tag_line', 'option');
    $data['facebook_button_expanded_text'] = get_field('facebook_button_expanded_text', 'option');
    $data['twitter_button_expanded_text'] = get_field('twitter_button_expanded_text', 'option');
    $data['twitter_button_bingo_text'] = get_field('twitter_button_bingo_text', 'option');
    $data['facebook_button_bingo_text'] = get_field('facebook_button_bingo_text', 'option');
    $data['take_action_header_text'] = get_field('take_action_header_text', 'option');
    $data['more_stories_heading_prefix'] = get_field('more_stories_heading_prefix', 'option');
    $data['load_more_button_text'] = get_field('load_more_button_text', 'option');
    $data['nav_search_placeholder_text'] = get_field('nav_search_placeholder_text', 'option');
    $data['nav_subscribe_placeholder_text'] = get_field('nav_subscribe_placeholder_text', 'option');
    $data['byline_prefix_text'] = get_field('byline_prefix_text', 'option');
    $data['category_prefix_text'] = get_field('category_prefix_text', 'option');
    $data['take_action_privacy_policy_text'] = get_field('take_action_privacy_policy_text', 'option');
    $data['flyout_header_text'] = get_field('flyout_header_text', 'option');
    $data['flyout_message_text'] = get_field('flyout_message_text', 'option');
    $data['facebook_like_url'] = get_field('facebook_like_url', 'option');
    $data['main_menu_header'] = get_field('main_menu_header', 'option');

    $data['take_action_thanks_header'] = get_field('take_action_thanks_header', 'option');
    $data['take_action_thanks_text'] = get_field('take_action_thanks_text', 'option');
    $data['take_action_thanks_subscribe_text'] = get_field('take_action_thanks_subscribe_text', 'option');

    $data['modal_joinus_header'] = get_field('modal_joinus_header', 'option');
    $data['modal_joinus_body_text'] = get_field('modal_joinus_body_text', 'option');
    $data['modal_joinus_opt_out_text'] = get_field('modal_joinus_opt_out_text', 'option');
    $data['modal_joinus_opt_out_button_text'] = get_field('modal_joinus_opt_out_button_text', 'option');

    $data['facebook_admin'] = get_field('facebook_admin', 'option');


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
    include_once('lib/fields/modal_options.php');
    include_once('lib/fields/display_options.php');
    include_once('lib/fields/flyout_options.php');
    include_once('lib/fields/social_links.php');
    include_once('lib/fields/site_text.php');
    include_once('lib/fields/story_list.php');
    include_once('lib/fields/widget_popular.php');
    include_once('lib/fields/daily_newsletter_posts.php');
    include_once('lib/fields/facebook_admin.php');
}

add_action('acf/register_fields', 'my_register_fields');

// Shortcodes
include_once('lib/shortcodes/placeholder.php');

include_once('lib/classes/ChangeOrgApi.php');
include_once('lib/classes/ChangeOrgPetition.php');
include_once('lib/classes/CallToAction.php');
include_once('lib/classes/NationSwellPost.php');
include_once('lib/classes/MailChimpFeed.php');


// Configure Menus
include_once('lib/menu/menu.php');

// Custom Widgets
include_once('lib/widgets/widgets.php');
include_once('lib/widgets/widget-joinus.php');
include_once('lib/widgets/widget-subscribe.php');
include_once('lib/widgets/widget-story.php');
include_once('lib/widgets/widget-popular.php');
include_once('lib/widgets/widget-stories.php');
include_once('lib/widgets/widget-contact.php');


// Plugin Activation
include_once('lib/tgm-plugin-activation/tgm-config.php');

// Custom Post Types
include_once('lib/custom_post_types/call_to_action.php');
include_once('lib/custom_post_types/story_list.php');
include_once('lib/custom_post_types/daily_newsletter.php');

// Remove the SEO MetaBox from Custom Post Types
function prefix_remove_wp_seo_meta_box() {
    remove_meta_box( 'wpseo_meta', 'ns_story_list', 'normal' );
    remove_meta_box( 'wpseo_meta', 'ns_call_to_action', 'normal' );
    remove_meta_box( 'wpseo_meta', 'guest-author', 'normal' );
    remove_meta_box( 'wpseo_meta', 'ns_daily_newsletter', 'normal' );
}
add_action( 'add_meta_boxes', 'prefix_remove_wp_seo_meta_box', 100000 );



// Change.org
global $change_org_api;

$change_org_api_key = '937ae45924510660d19d71f3622aee68810b8e8969c418da92afdde2e618be8f';
$change_org_secret = '9955d60df46358b12c33646352e54c50a28ea2f54fdc45fe4d7457307d847cf5';
$email = 'mark@ronikdesign.com';
$source = 'nationswell.com';
$description = 'Meet the People Renewing America. Join the Movement.';
$change_org_api= new ChangeOrgApi($change_org_api_key, $change_org_secret, $email, $source, $description);

function is_petition($cta_id) {
    return get_post_meta($cta_id, 'type', true) === 'petition';
}

function save_petition_data($cta_id) {
    global $change_org_api;

    if ($_POST['post_type'] === 'ns_call_to_action' && is_petition($cta_id)) {
        $petition = new ChangeOrgPetition($cta_id);
        $change_org_api->fetch($petition);
    }
}

add_action( 'acf/save_post', 'save_petition_data', 20);

function copy_from_post($keys) {
    $result = array();
    foreach($keys as $key) {
        if(isset($_POST[$key])) {
            $result[$key] = $_REQUEST[$key];
        }
    }
    return $result;
}

function handle_sign_petition() {
    global $change_org_api;

    $cta_id = (int)$_REQUEST['cta_id'];

    if(is_petition($cta_id)) {
        $petition = new ChangeOrgPetition($cta_id);

        $signer = copy_from_post(array('email','first_name', 'last_name', 'city', 'postal_code', 'country_code', 'reason'));

        $response = $change_org_api->sign($petition, $signer);

        http_response_code($response['response_code']);
        unset($response['response_code']);

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
        'jobs' => 'Jobs',
        'main_menu_story_list' => 'Main Menu'
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