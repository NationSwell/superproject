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
    $data['js_main'] = 'combined' . (WP_DEBUG ? '' : '.min') . '.js';

    /* this is where you can add your own data to Timber's context object */
    $data['menu_main'] = new TimberMenu('menu_main');
    $menu_post = new TimberMenu('menu_main_stories');
    $data['menu_main_menu'] = $menu_post;
    $menu_post_items = $menu_post->items;

    $data['menu_footer'] = new TimberMenu('menu_footer');
    $data['menu_topic'] = new TimberMenu('menu_topic');

    if(!empty($menu_post) && !empty($menu_post_items)) {

        $menu_post_ids = array();
        foreach($menu_post_items as $post) {
            array_push($menu_post_ids, $post->object_id);
        }
        $data['menu_main_stories'] = Timber::get_posts($menu_post_ids, 'NationSwellPost');
    }

    $data['ns_wp_title'] = wp_title('|',false,'right');
    
    
    // Global Site Options
    $options = array(
        'google_api_key',
        'google_client_id',
        'modal_joinus_enabled',
        'flyout_social_enabled',
        'nationswell_mailchimp_daily',
        'nationswell_facebook',
        'nationswell_twitter',
        'nationswell_instagram',
        'nationswell_tumblr',
        'nationswell_google',
        'site_tag_line',
        'facebook_button_expanded_text',
        'twitter_button_expanded_text',
        'twitter_button_bingo_text',
        'facebook_button_bingo_text',
        'take_action_header_text',
        'more_stories_heading_prefix',
        'load_more_button_text',
        'nav_search_placeholder_text',
        'nav_subscribe_placeholder_text',
        'byline_prefix_text',
        'category_prefix_text',
        'take_action_privacy_policy_text',
        'flyout_header_text',
        'flyout_message_text',
        'facebook_like_url',
        'main_menu_header',

        'take_action_thanks_header',
        'take_action_thanks_text',
        'take_action_thanks_subscribe_text',
        'share_take_action_button_text',

        'modal_joinus_header',
        'modal_joinus_body_text',
        'modal_joinus_opt_out_text',
        'modal_joinus_opt_out_button_text',

        'facebook_admin'
    );

    foreach($options as $option) {
        $data[$option] = get_field($option, 'option');
    }

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
    include_once('lib/fields/change_org.php');
    include_once('lib/fields/options/google.php');
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


// For 4.3.0 <= PHP <= 5.4.0
if (!function_exists('http_response_code'))
{
    function http_response_code($new_code = NULL)
    {
        static $code = 200;
        if($new_code !== NULL)
        {
            header('X-PHP-Response-Code: '. $new_code, true, $new_code);
            if(!headers_sent())
            {
                $code = $new_code;
            }
        }
        return $code;
    }
}

function getAttribute($attrib, $tag){
    //get attribute from html tag
    $re = '/' . preg_quote($attrib) . '=([\'"])?((?(1).+?|[^\s>]+))(?(1)\1)/is';
    if (preg_match($re, $tag, $match)) {
        return urldecode($match[2]);
    }
    return false;
}

function truncate($input, $maxWords, $maxChars, $link)
{
    $words = preg_split('/\s+/', $input);
    $words = array_slice($words, 0, $maxWords);
    $words = array_reverse($words);

    $chars = 0;
    $truncated = array();

    while(count($words) > 0)
    {
        $fragment = trim(array_pop($words));
        $chars += strlen($fragment);

        if($chars > $maxChars) break;

        $truncated[] = $fragment;
    }

    $result = implode($truncated, ' ');

    return $result . (($input == $result) ? '' : ((isset($link)) ? '<a href="'. $link .'">&hellip;</a>' : '&hellip;'));
}


// Change.org
global $change_org_api;

function init_change_org_api() {
    global $change_org_api;

    $change_org_api_key = get_field('change_api_key', 'option');
    $change_org_secret = get_field('change_secret', 'option');
    $email = get_field('change_email', 'option');

    if(!empty($change_org_api_key) && !empty($change_org_secret) && !empty($email)) {
        $source = 'nationswell.com';
        $description = get_field('change_description', 'option');

        $change_org_api = new ChangeOrgApi($change_org_api_key, $change_org_secret, $email, $source, $description);

        $frequency = get_field('change_frequency', 'option');
        if(!empty($frequency) || $frequency > 0) {
            $change_org_api->set_frequency($frequency);
        }
    }

    if(isset($change_org_api)) {
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
    }
}

add_action('init', 'init_change_org_api');

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