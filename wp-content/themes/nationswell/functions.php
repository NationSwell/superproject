<?php

$level = error_reporting();
$story_widget_status;
define( "MAILCHIMP_API_KEY","99983ece6b5ad94f7c4f026238381f4d-us6" );

// I'm not sure I like this approach to version management.
define('VERSION', intval( file_get_contents( get_template_directory() . '/version.txt' ) ) );
error_reporting(0);
@ini_set('display_errors', 0);

add_theme_support( 'post-formats' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'menus' );

add_filter( 'get_twig', 'add_to_twig' );
add_filter( 'timber_context', 'add_to_context' );

add_action( 'wp_enqueue_scripts', 'load_scripts' );
add_action( 'wp_head', 'nocache_headers' );

define( 'THEME_URL', get_template_directory_uri() );

define( 'BP_MESSAGES_AUTOCOMPLETE_ALL', true );


add_filter( 'wpseo_opengraph_title', 'yoast_wpseo_title');

function yoast_wpseo_title( $title ) {

    if( is_single() ) {
        $post = new NationSwellPost();
        return $post->tout_title();
    }

    return $title;
}

function add_to_context( $data ) {
    $data['js_main'] = 'combined' . (WP_DEBUG ? '.min' : '.min') . '.js';
    $data['version'] = VERSION;
	$cdn = 'http://nmelp3rtl8l2tnuwd2blzv3ecu.wpengine.netdna-cdn.com';
    $data['static_dir'] = '/static/' . VERSION;

    /* this is where you can add your own data to Timber's context object */
    $data['menu_main'] = new TimberMenu('menu_main');
    $menu_post = new TimberMenu('menu_main_stories');
    $data['menu_main_menu'] = $menu_post;
    $menu_post_items = $menu_post->items;

    $data['menu_footer'] = new TimberMenu( 'menu_footer' );
    $data['menu_topic'] = new TimberMenu( 'menu_topic' );
    $data['is_editor'] = current_user_can('edit_posts');

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
        'tweet_rep_privacy_policy_text',

        'flyout_header_text',
        'flyout_message_text',
        'flyout_opt_out_button_text',
        'flyout_facebook_opt_out_expiration',

        'facebook_like_url',
        'main_menu_header',

        'take_action_thanks_header',
        'take_action_thanks_text',
        'cta_button_text',
        'take_action_thanks_subscribe_text',
        'share_take_action_button_text',
        'share_take_action_text',

        'modal_joinus_header',
        'modal_joinus_body_text',
        'modal_joinus_opt_out_text',
        'modal_joinus_opt_out_button_text',
        'modal_joinus_subscribe_button_text',
        'modal_joinus_opt_out_expiration',
        'modal_joinus_close_expiration',
        'modal_joinus_subscribe_expiration',

        'password_copy_welcome',

        'facebook_admin'
    );

    foreach( $options as $option ) {
        $data[$option] = get_field( $option, 'option' );
    }

    /* Add buddypress global to context and global counters for nav */
	global $bp;
	if( function_exists('is_buddypress') &&!empty($bp)){
		$data['bp'] = $bp;
		$data['loggedin_user_user_nicename'] = $bp->loggedin_user->userdata->user_nicename;
		
		//new messages
		$data['bp_new_message_count'] = $new_message_count = (int) messages_get_unread_count();
		
		//new mentions
		$data['bp_new_mention_count'] = $new_mention_count = (int) bp_get_user_meta( $bp->loggedin_user->id, 'bp_new_mention_count', true );
	
		//total notifications
		$data['bp_total_new_count'] = $new_mention_count + $new_message_count;
		
		$data['bp_unread_notification_count'] = $unread_notification_count = bp_notifications_get_unread_notification_count($bp->loggedin_user->id);
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

function register_acf_fields()
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
    include_once('lib/fields/story_tease_display.php');
    include_once('lib/fields/call_to_action.php');
    include_once('lib/fields/call_to_action_link.php');
    include_once('lib/fields/ns_series_link.php');
    include_once('lib/fields/tout_options.php');
    include_once('lib/fields/ns_series.php');

    include_once('lib/fields/mailing_lists.php');
    include_once('lib/fields/modal_options.php');
    include_once('lib/fields/display_options.php');
    include_once('lib/fields/flyout_options.php');
    include_once('lib/fields/social_links.php');
    include_once('lib/fields/site_text.php');
    include_once('lib/fields/story_list.php');
    include_once('lib/fields/widget_popular.php');
    include_once('lib/fields/daily_newsletter_posts.php');
    include_once('lib/fields/editors_picks_posts.php');
    include_once('lib/fields/bi_contributors_posts.php');
    include_once('lib/fields/facebook_admin.php');
    include_once('lib/fields/council_contact.php');
    include_once('lib/fields/council_event.php');
    include_once('lib/fields/options/change_org.php');
    include_once('lib/fields/options/google.php');
    include_once('lib/fields/options/rally.php');
    include_once('lib/fields/options/nsc-portal.php');

    include_once('lib/fields/story_sponsorship.php');
}

add_action('acf/include_fields', 'register_acf_fields');

include_once('lib/classes/ChangeOrgApi.php');
include_once('lib/classes/ChangeOrgPetition.php');
include_once('lib/classes/RallyApi.php');
include_once('lib/classes/CallToAction.php');
include_once('lib/classes/NationSwellVideo.php');
include_once('lib/classes/NationSwellPost.php');
include_once('lib/classes/NationSwellSeries.php');
include_once('lib/classes/MailChimpFeed.php');
include_once('lib/classes/EditorsPicksFeed.php');
include_once('lib/classes/BIContributorsFeed.php');
include_once('lib/classes/NSCEvent.php');
include_once('lib/classes/NSCOpportunity.php');


// Shortcodes
include_once('lib/shortcodes/placeholder.php');

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
include_once('lib/widgets/widget-text.php');
include_once('lib/widgets/widget-voting.php');
//partners widget added 6/9/2016 @cloudred
include_once('lib/widgets/widget-partners.php');

// Plugin Activation
//include_once('lib/tgm-plugin-activation/tgm-config.php');

// Custom Post Types
include_once('lib/custom_post_types/call_to_action.php');
include_once('lib/custom_post_types/story_list.php');
include_once('lib/custom_post_types/daily_newsletter.php');
include_once('lib/custom_post_types/editors_picks.php');
include_once('lib/custom_post_types/bi_contributors.php');
include_once('lib/custom_post_types/series.php');
include_once('lib/custom_post_types/nsc_contact.php');
include_once('lib/custom_post_types/nsc_event.php');

// Remove the SEO MetaBox from Custom Post Types
function prefix_remove_wp_seo_meta_box() {
    remove_meta_box( 'wpseo_meta', 'ns_story_list', 'normal' );
    remove_meta_box( 'wpseo_meta', 'ns_call_to_action', 'normal' );
    remove_meta_box( 'wpseo_meta', 'guest-author', 'normal' );
    remove_meta_box( 'wpseo_meta', 'ns_daily_newsletter', 'normal' );
    remove_meta_box( 'wpseo_meta', 'ns_editors_picks', 'normal' );
    remove_meta_box( 'wpseo_meta', 'ns_bi_contributors', 'normal' );
    remove_meta_box( 'wpseo_meta', 'nsccontact', 'normal' );
    remove_meta_box( 'wpseo_meta', 'nscevent', 'normal' );
    remove_meta_box( 'wpseo_meta', 'opportunity', 'normal' );
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

function trunc($phrase, $max_words) {
   	$phrase_array = explode(' ',$phrase);
	if(count($phrase_array) > $max_words && $max_words > 0)
     	$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
   	return $phrase;
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

    if(function_exists('get_field')){

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
                define( "NEWSLETTER_ID","8eaa257d1b" );

                $cta_id = (int)$_REQUEST['cta_id'];

                if(is_petition($cta_id)) {
                    $petition = new ChangeOrgPetition($cta_id);

                    $signer = copy_from_post(array('email','first_name', 'last_name', 'city', 'postal_code', 'country_code', 'reason'));
                    try {
                        ns_mailchimp_subscribe( NEWSLETTER_ID, $signer['email'], true );
                    } catch (Mailchimp_Error $e) {
                        //do nothing and fail silently
                    }
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
}

add_action('init', 'init_change_org_api');

// Change.org
global $rally_api;

function init_rally_api()
{

    global $rally_api;

    if (function_exists('get_field')) {

        $drive = get_field('rally_drive', 'option');
        $auth_token = get_field('rally_auth_token', 'option');
        if (!empty($drive) && !empty($auth_token)) {
            $rally_api = new RallyApi($drive, $auth_token);

            $frequency = get_field('rally_frequency', 'option');
            if (!empty($frequency) || $frequency > 0) {
                $rally_api->set_frequency($frequency);
            }
        }
    }

}

add_action('init', 'init_rally_api');

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

add_action('generate_rewrite_rules', 'ns_add_rewrites');

function ns_add_rewrites($content) {
    global $wp_rewrite;
    $ns_new_non_wp_rules = array(
        'static/\d+/(css|img|fonts|js)/(.*)'          => 'wp-content/themes/nationswell/$1/$2',
    );

    $wp_rewrite->non_wp_rules = array_merge($wp_rewrite->non_wp_rules, $ns_new_non_wp_rules);

    return $content;
}

add_filter('gtc_list_item', 'gtc_add_tracking_list_item');
function gtc_add_tracking_list_item ($html)
{

    if(preg_match('/href="([^"]+)">([^<]+)/', $html, $matches))
    {
        $url = $matches[1];
        $title = $matches[2];
        return '<li><a href="' . $url . '" data-track=\'{}\'>' . $title . '</a></li>';
    }

    return $html;
}

add_filter('gtc_list_output', 'gtc_modify_list_output');

function gtc_modify_list_output($html) {
    return preg_replace('/<ol>/', '<ol data-module=\'{"name": "sidebar:popular"}\'>', $html, 1);
}


 add_action( 'wp_ajax_subscribe_action', 'subscribe_callback' );
 add_action( 'wp_ajax_nopriv_subscribe_action', 'subscribe_callback' );

function subscribe_callback() {
    
    $email = sanitize_email( $_POST['EMAIL'] );
    $listID = sanitize_text_field( $_POST['listid'] );	
    define( "NEWSLETTER_ID","8eaa257d1b" );
	try
	{
		if ( !empty( $listID ))
	    {
	    	try
	    	{
	    		ns_mailchimp_subscribe( NEWSLETTER_ID, $email, true );
	    		$response = ns_mailchimp_subscribe( $listID, $email, false );
	    	}
	    	catch (Mailchimp_List_AlreadySubscribed $e)
			{
	        	$response = ns_mailchimp_subscribe( $listID, $email, false );
                setcookie("subscribed","yes",time()+3600*24*999,"/");
			}
	    }
	    else {
	    	$response = ns_mailchimp_subscribe( NEWSLETTER_ID, $email, false );
	    }
	}
	catch (Mailchimp_List_AlreadySubscribed $e)
	{
		$response = array (
			"status" => "error",
			"message" => "You are already subscribed."
		);
        setcookie("subscribed","yes",time()+3600*24*999,"/");
	}
	catch (Mailchimp_Email_NotExists $e)
	{
		$response = array (
			"status" => "error",
			"message" => "That e-mail address does not exist."
		);
	}
	catch (Mailchimp_ValidationError $e)
	{
		$response = array (
			"status" => "error",
			"message" => "Please enter a valid e-mail address."
		);
	}
	catch (Mailchimp_Error $e)
	{
		$response = array (
			"status" => "error",
			"message" => "Please enter a valid e-mail address and retry."
		);
	}
    wp_send_json( $response);
    exit();
}

function ns_mailchimp_subscribe( $list, $emailaddr, $welcome ) {
    include_once 'Mailchimp.php';

    $params = array(
  	"id" => $list, 
   	"email" => array( 'email' => $emailaddr ), 
 	"merge_vars" => array(), 
    "email_type" => 'html', 
    "double_optin" => false,  
    "replace_interests" => false, 
    "send_welcome" => $welcome
    );
    
    $mail_chimp = new Mailchimp( MAILCHIMP_API_KEY );          			
    return $mail_chimp->call( 'lists/subscribe', $params );
}

add_action( 'wp_ajax_support_action', 'ns_supportmsg_callback' );
add_action( 'wp_ajax_nopriv_support_action', 'ns_supportmsg_callback' );

function ns_supportmsg_callback() {
    define('APP_URL', "https://script.google.com/macros/s/AKfycbz91ZsJLH_zCCWz6z-Do6rDwTAe5VyYUwHwnyYNm2WGHdTXrDo/exec");
    define('URL_PARAMS', "?sheet=" . urlencode(sanitize_text_field( $_POST['wsname'] )) . "&first=" . urlencode(sanitize_text_field( $_POST['first_name'] )) . "&last=" .
        urlencode(sanitize_text_field( $_POST['last_name'] )) . "&email=" . sanitize_email( $_POST['email'] ) . "&message=" . urlencode(sanitize_text_field( $_POST['message'] )));
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => APP_URL . URL_PARAMS
    ));

    $ss_response = curl_exec($curl);
    if ($ss_response)
    {
        curl_close($curl);
        exit();
    } else {
        curl_close($curl);
        exit();
    }
}

function google_analytics_tracking_code(){

    ?>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-45799105-1', 'nationswell.com');
        ga('require', 'displayfeatures');

        // Optimizely Universal Analytics Integration code
        window.optimizely = window.optimizely || [];
        window.optimizely.push(['activateUniversalAnalytics']);
        ga('send', 'pageview');

    </script>

<?php
}

add_action( 'wp_head', 'google_analytics_tracking_code' );


function pubexchange_widget()	{
	?>
		<script>(function(d, s, id) {
		var js, pjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "http://cdn.pubexchange.com/modules/partner/nation_swell";
		pjs.parentNode.insertBefore(js, pjs);
		}(document, 'script', 'pubexchange-jssdk'));</script>
	<?php
}

add_action( 'wp_footer','pubexchange_widget' );

function ns_tynt() {
	?>
	<!-- BEGIN Tynt Script -->
	<script type="text/javascript">
	if(document.location.protocol=='http:'){
	 var Tynt=Tynt||[];Tynt.push('cE3vDq33er44VJacwqm_6r');
	 (function(){var s=document.createElement('script');s.async="async";s.type="text/javascript";s.src='http://tcr.tynt.com/ti.js';var h=document.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);})();
	}
	</script>
	<!-- END Tynt Script -->
	<?php
}
add_action( 'wp_head', 'ns_tynt' );

function ns_get_joinus_cookie() {

    if ( isset($_COOKIE["subscribed"] )) {
        $GLOBALS["story_widget_status"] = "disabled";
    } else {
        $GLOBALS["story_widget_status"] = "enabled";
    }
}
add_action('init', 'ns_get_joinus_cookie');

function ns_newsletter_shortcode() {

    if ($GLOBALS["story_widget_status"] == "disabled") {
        return;
    } else {

        return "<div class=\"story-signup\" data-module='{\"name\": \"story:subscribe\"}'>
        <header>
            <div class=\"indicator indicator-story-signup icon icon_envelope\"></div>
        </header>
        <p>" . get_field( 'embedded_subscribe_copy', 'option' ) . "</p>
            <form action=\"\" method=\"post\" name=\"mc-embedded-subscribe-form\" class=\"mc-form validate\" target=\"_blank\" novalidate>
                <div class=\"mc-field-group cf\">
                    <div class=\"form-fields\">
                        <input type=\"email\" value=\"\" placeholder=\"Enter your email address\" name=\"EMAIL\" class=\"required email text-input\" id=\"mc-email\">
                        <input type=\"hidden\" name=\"listid\" value=\"\">
                        <label for=\"mc-email\" class=\"mc-email-status\"></label>
                        <input type=\"submit\" value=\"" . get_field( 'embedded_subscribe_button_text','option' ) . "\" name=\"subscribe\" id=\"mc-embedded-subscribe\" class=\"btn btn--solid\" data-modal-disable=\"" . get_field( 'modal_joinus_subscribe_expiration','option' ) . "\">
                    </div>
                </div>
            </form>
        </div>";
    }
}
add_shortcode( 'newsletter', 'ns_newsletter_shortcode' );

function voting_shortcode() {
  return "" . do_shortcode('[gravityform id="3" title="false" description="false" ajax="true"]') ."";
}
add_shortcode( 'voting_widget', 'voting_shortcode' );

class GW_Submission_Limit {
    var $_args;
	var $_notification_event;
	private static $forms_with_individual_settings = array();
    function __construct($args) {
	    // make sure we're running the required minimum version of Gravity Forms
	    if( ! property_exists( 'GFCommon', 'version' ) || ! version_compare( GFCommon::$version, '1.8', '>=' ) )
		    return;
        $this->_args = wp_parse_args( $args, array(
            'form_id' => false,
            'limit' => 1,
            'limit_by' => 'ip', // 'ip', 'user_id', 'role', 'embed_url', 'field_value'
            'time_period' => 60 * 60 * 24, // integer in seconds or 'day', 'month', 'year' to limit to current day, month, or year respectively
            'limit_message' => __( 'Sorry, you have reached the submission limit for this form.' ),
	        'apply_limit_per_form' => true,
	        'enable_notifications' => false
        ) );
        if( ! is_array( $this->_args['limit_by'] ) ) {
            $this->_args['limit_by'] = array( $this->_args['limit_by'] );
        }
	    if( $this->_args['form_id'] ) {
		    self::$forms_with_individual_settings[] = $this->_args['form_id'];
	    }
        add_action( 'init', array( $this, 'init' ) );
    }
	function init() {
		add_filter( 'gform_pre_render', array( $this, 'pre_render' ) );
		add_filter( 'gform_validation', array( $this, 'validate' ) );
		if( $this->_args['enable_notifications'] ) {
			$this->enable_notifications();
			add_action( 'gform_after_submission', array( $this, 'maybe_send_limit_reached_notifications' ), 10, 2 );
		}
	}
    function pre_render( $form ) {
        if( ! $this->is_applicable_form( $form ) || ! $this->is_limit_reached( $form['id'] ) ) {
	        return $form;
        }
        
        ob_start();
        if ($form['id'] == 4) {
	        require_once( get_template_directory() . '/allstar_voted-widget.php' );
        } else {
	        require_once( get_template_directory() . '/allstar_voted.php' );
	      }
        $message = ob_get_clean();
        $submission_info = rgar( GFFormDisplay::$submission, $form['id'] );
        // if no submission, hide form
        // if submission and not valid, hide form
        // unless 'field_value' limiter is applied
        if( ( ! $submission_info || ! rgar( $submission_info, 'is_valid' ) ) && ! $this->is_limited_by_field_value() ) {
	        add_filter( 'gform_get_form_filter_' . $form['id'], create_function( '', 'return \'' . $message . '\';' ) );
        }
        return $form;
    }
    function validate( $validation_result ) {
        if( ! $this->is_applicable_form( $validation_result['form'] ) || ! $this->is_limit_reached( $validation_result['form']['id'] ) ) {
            return $validation_result;
        }
        $validation_result['is_valid'] = false;
        if( $this->is_limited_by_field_value() ) {
	        $field_ids = array_map( 'intval', $this->get_limit_field_ids() );
            foreach( $validation_result['form']['fields'] as &$field ) {
                if( in_array( $field['id'], $field_ids ) ) {
                    $field['failed_validation'] = true;
                    $field['validation_message'] = do_shortcode( $this->_args['limit_message'] );
                }
            }
        }
        return $validation_result;
    }
    public function is_limit_reached($form_id) {
        global $wpdb;
        $where = array();
        $join = array();
	    $where[] = 'l.status = "active"';
        foreach( $this->_args['limit_by'] as $limiter ) {
            switch( $limiter ) {
                case 'role': // user ID is required when limiting by role
                case 'user_id':
                    $where[] = $wpdb->prepare( 'l.created_by = %s', get_current_user_id() );
                    break;
                case 'embed_url':
                    $where[] = $wpdb->prepare( 'l.source_url = %s', GFFormsModel::get_current_page_url());
                    break;
                case 'field_value':
                    $values = $this->get_limit_field_values( $form_id, $this->get_limit_field_ids() );
                    // if there is no value submitted for any of our fields, limit is never reached
                    if( empty( $values ) ) {
                         return false;
                    }
					foreach( $values as $field_id => $value ) {
						$table_slug = sprintf( 'ld%s', str_replace( '.', '_', $field_id ) );
						$join[]     = "INNER JOIN {$wpdb->prefix}rg_lead_detail {$table_slug} ON {$table_slug}.lead_id = l.id";
						//$where[]    = $wpdb->prepare( "CAST( {$table_slug}.field_number as unsigned ) = %f AND {$table_slug}.value = %s", $field_id, $value );
						$where[]    = $wpdb->prepare( "\n( ( {$table_slug}.field_number BETWEEN %s AND %s ) AND {$table_slug}.value = %s )", doubleval( $field_id ) - 0.001, doubleval( $field_id ) + 0.001, $value );
					}
                    break;
                default:
                    $where[] = $wpdb->prepare( 'ip = %s', GFFormsModel::get_ip() );
            }
        }
	    if( $this->_args['apply_limit_per_form'] ) {
		    $where[] = $wpdb->prepare( 'l.form_id = %d', $form_id );
	    }
        $time_period = $this->_args['time_period'];
        $time_period_sql = false;
        if( $time_period === false ) {
            // no time period
        } else if( intval( $time_period ) > 0 ) {
            $time_period_sql = $wpdb->prepare( 'date_created BETWEEN DATE_SUB(utc_timestamp(), INTERVAL %d SECOND) AND utc_timestamp()', $this->_args['time_period'] );
        } else {
            switch( $time_period ) {
                case 'per_day':
                case 'day':
                    $time_period_sql = 'DATE( date_created ) = DATE( utc_timestamp() )';
                break;
                case 'per_month':
                case 'month':
                    $time_period_sql = 'MONTH( date_created ) = MONTH( utc_timestamp() )';
                break;
                case 'per_year':
                case 'year':
                    $time_period_sql = 'YEAR( date_created ) = YEAR( utc_timestamp() )';
                break;
            }
        }
        if( $time_period_sql ) {
            $where[] = $time_period_sql;
        }
        $where = implode( ' AND ', $where );
        $join = implode( "\n", $join );
        $sql = "SELECT count( l.id )
                FROM {$wpdb->prefix}rg_lead l
                $join
                WHERE $where";
        $entry_count = $wpdb->get_var( $sql );
        return $entry_count >= $this->get_limit();
    }
    public function is_limited_by_field_value() {
        return in_array( 'field_value', $this->_args['limit_by'] );
    }
    public function get_limit_field_ids() {
	    $limit = $this->_args['limit'];
	    if( is_array( $limit ) ) {
		    $field_ids = array( call_user_func( 'array_shift', array_keys( $this->_args['limit'] ) ) );
	    } else {
		    $field_ids = $this->_args['fields'];
	    }
        return $field_ids;
    }
    public function get_limit_field_values( $form_id, $field_ids ) {
	    $form   = GFAPI::get_form( $form_id );
	    $values = array();
	    foreach( $field_ids as $field_id ) {
		    $field      = GFFormsModel::get_field( $form, $field_id );
		    $input_name = 'input_' . str_replace( '.', '_', $field_id );
		    $value      = GFFormsModel::prepare_value( $form, $field, rgpost( $input_name ), $input_name, null );
		    if( ! rgblank( $value ) ) {
			    $values[ $field_id ] = $value;
		    }
	    }
        return $values;
    }
    public function get_limit() {
        $limit = $this->_args['limit'];
        if( $this->is_limited_by_field_value() ) {
            $limit = is_array( $limit ) ? array_shift( $limit ) : intval( $limit );
        } else if( in_array( 'role', $this->_args['limit_by'] ) ) {
            $limit = rgar( $limit, $this->get_user_role() );
        }
        return intval( $limit );
    }
    public function get_user_role() {
        $user = wp_get_current_user();
        $role = reset( $user->roles );
        return $role;
    }
	public function enable_notifications() {
		if( ! class_exists( 'GW_Notification_Event' ) ) {
			_doing_it_wrong( 'GW_Inventory::$enable_notifications', __( 'Inventory notifications require the \'GW_Notification_Event\' class.' ), '1.0' );
		} else {
			$event_slug = implode( array_filter( array( "gw_submission_limit_limit_reached", $this->_args['form_id'] ) ) );
			$event_name = GFForms::get_page() == 'notification_edit' ? __( 'Submission limit reached' ) : __( 'Event name is only populated on Notification Edit view; saves a DB call to get the form on every ' );
			$this->_notification_event = new GW_Notification_Event( array(
				'form_id'    => $this->_args['form_id'],
				'event_name' => $event_name,
				'event_slug' => $event_slug
				//'trigger'    => array( $this, 'notification_event_listener' )
			) );
		}
	}
	public function maybe_send_limit_reached_notifications( $entry, $form ) {
		if( $this->is_applicable_form( $form ) && $this->is_limit_reached( $form['id'] ) ) {
			$this->send_limit_reached_notifications( $form, $entry );
		}
	}
	public function send_limit_reached_notifications( $form, $entry ) {
		$this->_notification_event->send_notifications( $this->_notification_event->get_event_slug(), $form, $entry, true );
	}
	function is_applicable_form( $form ) {
		$form_id          = isset( $form['id'] ) ? $form['id'] : $form;
		$is_global_form   = empty( $this->_args['form_id'] ) && ! in_array( $form_id, self::$forms_with_individual_settings );
		$is_specific_form = $form_id == $this->_args['form_id'];
		return $is_global_form || $is_specific_form;
	}
}
class GWSubmissionLimit extends GW_Submission_Limit { }

new GW_Submission_Limit( array(
    'form_id' => 3,
    'limit_by' => 'ip',
    'limit' => 1,
    'time_period' => 'per_day'
) );

new GW_Submission_Limit( array(
    'form_id' => 4,
    'limit_by' => 'ip',
    'limit' => 1,
    'time_period' => 'per_day'
) );


add_filter( 'gform_confirmation', 'custom_confirmation', 10, 4 );
function custom_confirmation( $confirmation, $form, $entry, $ajax ) {
    if( $form['id'] == '3' ) {
        ob_start();
        require_once( get_template_directory() . '/allstar_voted.php' );
        $confirmation = ob_get_clean();
    } 
    if( $form['id'] == '4' ) {
        ob_start();
        require_once( get_template_directory() . '/allstar_voted-widget.php' );
        $confirmation = ob_get_clean();
    } 
    return $confirmation;
}

add_action( 'show_user_profile', 'ns_extra_email_field' );
add_action( 'edit_user_profile', 'ns_extra_email_field' );

function ns_extra_email_field( $user ) { ?>

    <h3>E-mail To Display</h3>

    <table class="form-table">

        <tr>
            <th><label for="email-display">E-mail Address</label></th>

            <td>
                <input type="text" name="email_display" id="email_display" value="<?php echo esc_attr( get_the_author_meta( 'email_display', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description">Please enter your E-mail to display to visitors.</span>
            </td>
        </tr>

    </table>
<?php
}

add_action( 'personal_options_update', 'ns_save_extra_email_field' );
add_action( 'edit_user_profile_update', 'ns_save_extra_email_field' );

function ns_save_extra_email_field( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    update_usermeta( $user_id, 'email_display', $_POST['email_display'] );
}


add_action( 'wp_ajax_initialize_nscdirectory', 'ns_nscdirectory_callback' );
add_action( 'wp_ajax_nopriv_initialize_nscdirectory', 'ns_nscdirectory_callback' );

function ns_nscdirectory_callback() {

    $contactData = get_transient( 'nsc_portal_contact_data' );

    if ( false === ( $contactData ) ) {
        // It wasn't there, so regenerate the data and save the transient
        $query = array(
            'posts_per_page' => -1,
            'post_type' => 'nsccontact',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_key' => 'nsc_surname',
        );
        $contactPosts = get_posts( $query );
        $contactData = array();
        foreach($contactPosts as $contact) {
            $contactData[] = array (
                "name" => $contact->post_title,
                "surname" => get_field("nsc_surname", $contact),
                "bio" => get_field("nsc_bio", $contact),
                "image" => get_field("nsc_image", $contact),
                "interests" => get_field("nsc_interests", $contact),
                "email" => get_field("nsc_email", $contact),
                "linkedin" => get_field("nsc_linkedin", $contact),
                "phone" => get_field("nsc_phone", $contact),
                "twitter" => get_field("nsc_twitter", $contact)
            );
        }
        set_transient( 'nsc_portal_contact_data', $contactData, 12 * HOUR_IN_SECONDS );
    }

    wp_send_json( $contactData );
    exit();
}

add_action( 'wp_ajax_initialize_nscevents', 'ns_nscevents_callback' );
add_action( 'wp_ajax_nopriv_initialize_nscevents', 'ns_nscevents_callback' );

function ns_nscevents_callback() {
    $events = array();
    $events["upcoming"] = NSCEvent::getUpcomingEvents();
    $events["past"] = NSCEvent::getPastEvents();
    wp_send_json( $events );
    exit();
}


add_action( 'wp_ajax_initialize_nscupdates', 'ns_nscupdates_callback' );
add_action( 'wp_ajax_nopriv_initialize_nscupdates', 'ns_nscupdates_callback' );

function ns_nscupdates_callback() {
    $updatesData = array();
    $updatesPosts = get_posts( array(
                'numberposts' => -1,
                'category_name' => 'nsc-updates'
    ));

    foreach ($updatesPosts as $update) {
        $updatesData[] = array(
            "title" => $update->post_title,
            'dek'   => get_field("dek", $update),
            'url'   => get_permalink($update),
            'thumbnail_url' => wp_get_attachment_url( get_post_thumbnail_id($update->ID) )
        );
    }
    error_log(print_r($updatesData, TRUE));
    wp_send_json( $updatesData );
    exit();

}

function clear_portal_transient($post_id, $post) {

    if ($post->post_type != 'nsccontact') {
        return;
    }
    delete_transient('nsc_portal_contact_data');
}

add_action('save_post', 'clear_portal_transient', 1, 2);
	


add_image_size( 'member-thumb', 380, 380, true );
add_image_size( 'event-thumb', 400, 260, true );
add_image_size( 'quote-thumb', 650, 450, true );

function get_latest_stylesheet() {
	$stylesheet = "style.css";

	foreach (glob(get_stylesheet_directory() . "/style_*.css") as $filename) {
		$filename = basename($filename);
		if ($filename > $stylesheet)
			$stylesheet = $filename;
	}

	return dirname(get_stylesheet_uri()) . "/" . $stylesheet;
}



// Add Conditional Widgets support (UI & Logic) for post type 'post' and taxonomy 'series'

add_filter('conditional_widgets_type_tax_pairs', 'add_conditional_widget_type_tax_pairs',0);

function add_conditional_widget_type_tax_pairs( $my_pair_array ) {
	$my_pair = array('type'=>'post','tax'=>'series');
	$my_pair_array[] = $my_pair;
	return $my_pair_array;
}

add_action('wp_logout','nsc_login');
function nsc_login(){
  if( function_exists('bp_is_active') ) {
  	wp_redirect( '/nationswell-council/' );
  } else {
  	wp_redirect( home_url() );
  }
  exit();
}

//hide admin bar from non-admin users
add_filter('show_admin_bar', '__return_false');
if ( ! current_user_can( 'manage_options' ) ) {
    show_admin_bar( false );
}

//add custom placeholder avatar
add_filter( 'avatar_defaults', 'new_default_avatar' );

function new_default_avatar ( $avatar_defaults ) {
		//Set the URL where the image file for your avatar is located
		$new_avatar_url = get_bloginfo( 'template_directory' ) . '/img/ns-gravatar.jpg';
		//Set the text that will appear to the right of your avatar in Settings>>Discussion
		$avatar_defaults[$new_avatar_url] = 'NationSwell Default';
		return $avatar_defaults;
}

//restrict to logged in users
function restrictPages(){
	if(!is_user_logged_in()){
		// restrict pages
		global $post;
		switch($post->post_name){
			case'faq':
				loginPageRedirect();
			break;
		}
		// restrict buddypress pages
		if( ( function_exists('is_buddypress') && is_buddypress() ) ){
			// allow some public pages to non logged in users
			if (function_exists('bp_is_register_page') && function_exists('bp_is_activation_page') ){
				if ( bp_is_register_page() || bp_is_activation_page() ){ return;}
			}
			loginPageRedirect();
		}
	}else{
		// restrict buddypress pages to specific role
		if( ( function_exists('is_buddypress') && is_buddypress() ) ){
			$current_user = wp_get_current_user();
			$roles = $current_user->roles;
			foreach($roles as $role){
				switch($role){
					case'administrators':
					case'editor':
					case'member':
						return;
					break;
				}
			}
			wp_redirect( home_url() );
			die();
		}
	}
}
add_action( 'wp', 'restrictPages');

function loginPageRedirect(){
	// redirect to login page
	$redirect_url = site_url('nationswell-council');
	header( 'Location: ' . $redirect_url );
	die();
}

/**
 * Redirect user after successful login.
 *
 * @param string $redirect_to URL to redirect to.
 * @param string $request URL the user is coming from.
 * @param object $user Logged user's data.
 * @return string
 */
function user_login_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) ) {
			// redirect them to the default place
			return $redirect_to;
		} elseif(home_url() ==  $redirect_to) {
			if( function_exists('bp_is_active') ) {
				return bp_get_root_domain().'/members/'.$user->data->user_nicename.'/activity/';
			}else{
				return home_url();
			}
		}else{
			return $redirect_to;
		}
	} else {
		return $redirect_to;
	}
}
add_filter( 'login_redirect', 'user_login_redirect', 10, 3 );

// modify the buddypress nav links
function bp_custom_setup_nav() {
    global $bp;
	// Add events
    $args = array(
            'name' => __('Events', 'buddypress'),
            'slug' => 'nsc-events',
            'default_subnav_slug' => 'nsc-events',
            'position' => 51,
            'screen_function' => 'bp_custom_event_screen',
            'item_css_id' => 'user-events'
    );
    bp_core_new_nav_item( $args );

	// Add events
    $args = array(
            'name' => __('Service Opportunities', 'buddypress'),
            'slug' => 'opportunity',
            'default_subnav_slug' => 'opportunity',
            'position' => 52,
            'screen_function' => 'bp_custom_service_opportunities_screen',
            'item_css_id' => 'user-service-opportunities'
    );

    bp_core_new_nav_item( $args );
    //Change name
    $bp->bp_nav['activity']['name'] = 'Announcements';
    $bp->bp_nav['messages']['name'] = 'Your Messages';
    //Remove links
    unset($bp->bp_nav['profile']);
    unset($bp->bp_nav['friends']);
    unset($bp->bp_nav['notifications']);
    unset($bp->bp_nav['settings']);

    // Reorder messages componet sub tabs
    $messagesNavHash =  $bp->bp_options_nav['messages'];
    unset($bp->bp_options_nav['messages']);
    $bp->bp_options_nav['messages']['compose'] = $messagesNavHash['compose'];
    $bp->bp_options_nav['messages']['inbox'] = $messagesNavHash['inbox'];
    $bp->bp_options_nav['messages']['starred'] = $messagesNavHash['starred'];
    $bp->bp_options_nav['messages']['sentbox'] = $messagesNavHash['sentbox'];
	$bp->bp_options_nav['messages']['notices'] = $messagesNavHash['notices'];
}
add_action( 'bp_setup_nav', 'bp_custom_setup_nav', 99 );

// Override message tab link
function bp_custom_message_nav() {
	global $bp;
	$bp->bp_nav['messages']['name'] = 'Your Messages';
}
add_action( 'bp_screens', 'bp_custom_message_nav',99 );

// calback function for events nav item
function bp_custom_event_screen() {
    add_action( 'bp_template_content', 'bp_custom_event_screen_content' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

// the function hooked to bp_template_content, this hook is in plugns.php
function bp_custom_event_screen_content() {
	get_template_part( 'buddypress/events/listing-nscevent' );
}

// calback function for service-opportunities nav item
function bp_custom_service_opportunities_screen(){
    add_action( 'bp_template_content', 'bp_custom_service_opportunities_screen_content' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

// the function hooked to bp_template_content, this hook is in plugns.php
function bp_custom_service_opportunities_screen_content() {
	get_template_part( 'buddypress/service-opportunities/listing-service-opportunities' );
}
//adjustments to default wordpress login screen
function ns_default_login_adjust() { 
	echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/css/custom-login.css" />'; 
}
add_action( 'login_enqueue_scripts', 'ns_default_login_adjust' );
function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return get_bloginfo( 'name' );
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );


/** changing default wordpres email settings */
 
add_filter('wp_mail_from', 'ns_mail_from');
add_filter('wp_mail_from_name', 'ns_mail_from_name');
 
function ns_mail_from($old) {
 return get_bloginfo('admin_email');
}
function ns_mail_from_name($old) {
 return get_bloginfo( 'name' );
}
/*
function wp_password_change_notification($user) {
	$user = get_userdata( $user_id );

	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	$message  = sprintf(__('New user registration on your site %s:'), $blogname) . "\r\n\r\n";
	$message .= sprintf(__('Username: %s'), $user->user_login) . "\r\n\r\n";
	$message .= sprintf(__('E-mail: %s'), $user->user_email) . "\r\n";

	@wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $blogname), $message);

	if ( empty($plaintext_pass) )
		return;

	$message  = sprintf(__('Username: %s'), $user->user_login) . "\r\n";
	$message .= sprintf(__('Password: %s'), $plaintext_pass) . "\r\n";
	$message .= 'To log into the admin area please us the following address ' . wp_login_url() . "\r\n";

	wp_mail($user->user_email, sprintf(__('[%s] Your username and password'), $blogname), $message);

}*/

function bp_update_user_wp_data() {
	global $bp;
    if(!empty($_REQUEST['profile-wp-edit-submit'])){
    	$first_name =sanitize_text_field($_REQUEST['first_name']);
		$last_name =sanitize_text_field($_REQUEST['last_name']);
		$user_id = wp_update_user( array( 'ID' => $bp->displayed_user->id, 'first_name' => $first_name,'last_name' => $last_name,'description' => sanitize_text_field($_REQUEST['description']),'nickname'=>$first_name.' '.$last_name  ) );
		if ( is_wp_error( $user_id ) ) {
			$messagetype = 'error';
			$message=_('Sorry, could not save your information');
		} else {
			$messagetype = 'updated';
			$message=_('Changes saved');
		}
		echo('<div id="message" class="bp-template-notice '.$messagetype.'"><p>'.$message.'</p></div>');
    }
}
add_filter( 'bp_before_profile_edit_content', 'bp_update_user_wp_data' );


//Remove the rich text editor from bio field
function bio_remove_rich_text( $field_id = null ) {
    if ( ! $field_id ) {
        $field_id = xprofile_get_field_id_from_name( 'bio' );
    }
 
    $field = xprofile_get_field( $field_id );
  
    if ( $field ) {
        $enabled = false;
    }
}
add_filter( 'bp_xprofile_is_richtext_enabled_for_field', 'bio_remove_rich_text' );




/**
 * Sync xprofile buddypress field "bio" to standard WP "Biographical Info" field
 */
function xprofile_sync_bio_bp_to_wp( $user_id = 0 ) {
	  // Bail if profile syncing is disabled.
	  if ( bp_disable_profile_sync() ) {
		return true;
	  }
	
	  if ( empty( $user_id ) ) {
		$user_id = bp_loggedin_user_id();
	  }
	
	  if ( empty( $user_id ) ) {
		return false;
	  }
	  $bio = xprofile_get_field_data('bio',$user_id);
	  bp_update_user_meta( $user_id, 'description', $bio ); 
}

add_action('xprofile_updated_profile','xprofile_sync_bio_bp_to_wp');


/**
 * Sync standard WP "Biographical Info" field to xprofile buddypress field "bio"
 */
function xprofile_sync_bio_wp_to_bp( $user_id ) {
  //echo "STOP!";
  //break;
  // Bail if profile syncing is disabled.
  if ( bp_disable_profile_sync() ) {
    return false;
  }
  $user_info = get_userdata($user_id);
  $bio = $user_info->description;
  //usage: xprofile_set_field_data( $field, $user_id, $value, $is_required );
  xprofile_set_field_data( 'bio', $user_id, $bio );
}
add_action('profile_update', 'xprofile_sync_bio_wp_to_bp',10,2);



/**
 * Output the Members directory search form.
 */
function bp_directory_members_custom_search_form() {
	global $wpdb;

	$profilefields = $wpdb->get_results( "SELECT id, name FROM ".$wpdb->prefix."bp_xprofile_fields where parent_id =0");
	$fieldsHash = array();
	foreach ( $profilefields as $profilefield ) {
		$fieldsHash[$profilefield->name]=$profilefield->id;
	}

	$query_arg = bp_core_get_component_search_query_arg( 'members' );
	if ( ! empty( $_REQUEST[ $query_arg ] ) ) {
		$search_value = stripslashes( $_REQUEST[ $query_arg ] );
	} else {
		$search_value = __('Search by name, title, or company','buddypress');
	}

	$search_form_html = '<form action="'.$bp->root_domain . '/' . BP_MEMBERS_SLUG.'" method="post" id="search-members-form"><label for="members_search"><input type="text" name="' . esc_attr( $query_arg ) . '" id="members_search" placeholder="'. esc_attr( $search_value ) .'" /></label>';
	// Council branch
	$search_form_html .= bp_create_custom_search_form_dropdowns($fieldsHash['Council branch'], 'Location', 'council_branch');
	// Industry
	$search_form_html .= bp_create_custom_search_form_dropdowns($fieldsHash['Industry'], 'Industry', 'industry');
	// NationSwell topics
	$search_form_html .= bp_create_custom_search_form_dropdowns($fieldsHash['NationSwell topics'], 'NationSwell topics', 'nationswell_topics');
	// Interested in
	$search_form_html .= bp_create_custom_search_form_dropdowns($fieldsHash['Interested in'], 'Interested in', 'interested_in');

	$search_form_html .='<input type="submit" id="members_search_submit" name="members_search_submit" value="' . __( 'Search', 'buddypress' ) . '" />';
	$search_form_html .= '<a href="'.$bp->root_domain . '/' . BP_MEMBERS_SLUG .'" class="reset">';
	$search_form_html .= __('Clear','buddypress');
	$search_form_html .= '</a>';
	$search_form_html .= '<input type="hidden" name="upage" id="upage" value="1" />';
	$search_form_html .= '</form>';
	/**
	 * Filters the Members component search form.
	 *
	 * @since 1.9.0
	 *
	 * @param string $search_form_html HTML markup for the member search form.
	 */
	echo apply_filters( 'bp_directory_members_search_form', $search_form_html );
}

function bp_create_custom_search_form_dropdowns($field_id, $field_name, $field_key){
	global $wpdb;
	$search_form_html = '';
	if( !empty($field_id) ){
		$search_form_html .='<label for="'.$field_key.'"><select id="'.$field_key.'" name="'.$field_key.'">';
		$options = $wpdb->get_results( "SELECT id, name FROM ".$wpdb->prefix."bp_xprofile_fields where type='option' and parent_id =".$field_id." order by name");
		$search_form_html .= '<option value="">'.__($field_name).'</option>';
		foreach ( $options as $option ) {
			if($_REQUEST[$field_key]==$option->name){
				$search_form_html .= '<option value="'.$option->name.'" selected="selected">'.__($option->name).'</option>';
			}else{
				$search_form_html .= '<option value="'.$option->name.'">'.__($option->name).'</option>';
			}
		}
		$search_form_html .='</select></label>';
	}
	return $search_form_html;
}

// MAKE SLUGS FROM TEXT
function slugify($text) {
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}

function ns_custom_scripts(){
	// Register and Enqueue a Stylesheet
	// get_template_directory_uri will look up parent theme location
	wp_register_style( 'chosen', get_template_directory_uri() . '/css/chosen.min.css');
	wp_enqueue_style( 'chosen' );

	// Register and Enqueue a Script
	// get_stylesheet_directory_uri will look up child theme location
	wp_register_script( 'chosen', get_stylesheet_directory_uri() . '/js/src/vendor/chosen.jquery.min.js', array('jquery'));
	wp_enqueue_script( 'chosen' );
}

add_action('wp_enqueue_scripts', 'ns_custom_scripts');

// Hack to remove component name off profile pages
function ns_bp_page_title($page_title){
	if ( function_exists('is_buddypress') && is_buddypress() ) {
		global $bp;
		if($bp->current_component == 'profile'){
			$blogname = get_bloginfo( 'name', 'display' );
			return $bp->displayed_user->userdata->display_name.' | '.$blogname;
		}
	}
	return $page_title;
}
add_filter( 'wp_title', 'ns_bp_page_title', 100, 3 );

function ns_profile_link( $link ) {
   if( !empty($link) ) {
       $link .= 'profile';
	}
   return $link;
}
add_filter( 'bp_get_activity_user_link', 'ns_profile_link', 15, 1 );
add_filter( 'bp_get_member_permalink', 'ns_profile_link', 15, 1 );
//add_filter( 'bp_core_get_user_domain', 'ns_profile_link', 15, 1 );

function ns_core_get_userlink ($string, $user_id) {
	$url = bp_core_get_user_domain($user_id);
	$user_info = get_userdata($user_id);
	$name = $user_info->display_name;
	$link = '<a href ="' . $url . 'profile">' . $name . '</a>';
	return $link;
}
add_filter ('bp_core_get_userlink', 'ns_core_get_userlink', 10, 2);


/********* Login/password reset pages hook callbacks *****************/
// define the login_footer callback 
function ns_login_footer( $wp_print_footer_scripts, $int ) { 
	echo '<div class="custom-login-footer">';
	echo '<a href="/nationswell-council/">';
	echo __('Back to Member Login','buddypress');
	echo '</a>';
	echo '</div>';
	echo '<script>
		jQuery( document ).ready(function() {
			if (jQuery("body").hasClass("login-action-lostpassword")) {
				jQuery(".custom-login-footer").prependTo("p.submit");
			} else {
				jQuery(".custom-login-footer").css("display","none");
			}
		});
	</script>';
}; 
         
// add the action 
add_action( 'login_footer', 'ns_login_footer', 10, 2 ); 


/** Sort alphabetical member name listings by lastname */
function alphabetize_by_last_name( $bp_user_query ) {
    if ( 'alphabetical' == $bp_user_query->query_vars['type'] )
        $bp_user_query->uid_clauses['orderby'] = "ORDER BY substring_index(u.display_name, ' ', -1)";
}
add_action ( 'bp_pre_user_query', 'alphabetize_by_last_name' );


//**********************************************
//----- Custom hook for gravity forms used in AllStar voting widget
//set the dropdown containing the candidates with the current candidate if we're looking at the endividual post
//more: https://www.gravityhelp.com/documentation/article/using-dynamic-population/

add_filter( 'gform_field_value_candidate', 'allstars_population_function' );
function allstars_population_function( $value ) {
    $candidate = get_the_title();
	return $candidate;
}

//**** END custom gravity forms hook ***************/