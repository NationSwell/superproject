<?php /* Template name: AllStars (Minisite) */ ?>

<?php
/**
 * The template for displaying a summit splash page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/views/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = new TimberPost();

$context['page_content'] = wpautop($post->post_content);
$context['form'] = gravity_form( get_field('nomination_form_id'), $display_title = true, $display_description = false, $display_inactive = false, $field_values = null, $ajax = false, $tabindex, $echo = false );
$context['previous_years'] = get_field('previous_years');
$context['home'] = esc_url( home_url( '/' ) );
$context['site_url'] = get_site_url();
$context['footer_links'] = wp_get_nav_menu_items('Footer Links');


//Get category term by its ID
$context['term'] = new TimberTerm($post->custom['category']);
if( !empty($context['term']->category_sponsor_image) ){
	$context['category_sponsor_image_src'] = wp_get_attachment_image_src($context['term']->category_sponsor_image,'thumbnail');
	$context['category_sponsor_image_meta_alt']= get_post_meta($context['term']->category_sponsor_image, '_wp_attachment_image_alt', true);
}

// Get allstar_finalists_will_receive content
if( !empty($post->custom['allstar_finalists_will_receive']) ){
	$post->custom['allstar_finalists_will_receive_hash'] = array();
	for($x=0;$x<$post->custom['allstar_finalists_will_receive']; $x++){
		$post->custom['allstar_finalists_will_receive_hash'][$x]['allstar_finalists_will_receive_description']=$post->custom['allstar_finalists_will_receive_'.$x.'_description'];
		if( !empty($post->custom['allstar_finalists_will_receive_'.$x.'_icon'] ) ){
			$post->custom['allstar_finalists_will_receive_hash'][$x]['allstar_finalists_will_receive_icon']= wp_get_attachment_image_src($post->custom['allstar_finalists_will_receive_'.$x.'_icon'],'full');
			$post->custom['allstar_finalists_will_receive_hash'][$x]['allstar_finalists_will_receive_icon_meta']= wp_get_attachment_metadata($post->custom['allstar_finalists_will_receive_'.$x.'_icon']);
			$post->custom['allstar_finalists_will_receive_hash'][$x]['allstar_finalists_will_receive_icon_image_alt'] = get_post_meta( $post->custom['allstar_finalists_will_receive_'.$x.'_icon'], '_wp_attachment_image_alt', true);
		}
	}
}

// Get allstars_in_the_news content
if( !empty($post->custom['allstars_in_the_news']) ){
	$post->custom['allstars_in_the_news_hash'] = array();
	for($x=0;$x<$post->custom['allstars_in_the_news']; $x++){
		$post->custom['allstars_in_the_news_hash'][$x]['allstars_in_the_news_title']=$post->custom['allstars_in_the_news_'.$x.'_title'];
		$post->custom['allstars_in_the_news_hash'][$x]['allstars_in_the_news_excerpt']=$post->custom['allstars_in_the_news_'.$x.'_excerpt'];
		$post->custom['allstars_in_the_news_hash'][$x]['allstars_in_the_news_link']=$post->custom['allstars_in_the_news_'.$x.'_link'];
		if( !empty($post->custom['allstars_in_the_news_'.$x.'_featured_image'] ) ){
			$post->custom['allstars_in_the_news_hash'][$x]['allstars_in_the_news_featured_image']= wp_get_attachment_image_src($post->custom['allstars_in_the_news_'.$x.'_featured_image'],'thumbnail');
			$post->custom['allstars_in_the_news_hash'][$x]['allstars_in_the_news_featured_image_meta']= wp_get_attachment_metadata($post->custom['allstars_in_the_news_'.$x.'_featured_image']);
			$post->custom['allstars_in_the_news_hash'][$x]['allstars_in_the_news_featured_image_image_alt'] = get_post_meta( $post->custom['allstars_in_the_news_'.$x.'_featured_image'], '_wp_attachment_image_alt', true);
		}
	}
}

// Assign full post data
$context['post'] = $post;

if (post_password_required($post->ID)){
    Timber::render('static-password.twig', $context);
} else {
    Timber::render('allstars-v2.twig', $context);
}