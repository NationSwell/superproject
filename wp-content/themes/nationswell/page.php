<?php
/**
 * The template for displaying all pages.
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
/* Hack for buddypress to render contents and assign it's own template */
if ( function_exists('is_buddypress') && is_buddypress() ) {
	global $wp_query;
	$wp_query->in_the_loop=true; // Strange Hack due to Timber... see Buddypress - bp_do_theme_compat()
	ob_start();
	the_content();
	$context['buddypress_content'] = ob_get_contents();
	ob_end_clean();
	$context['post'] = $post = new TimberPost();
	$context['post']->post_name = $post->post_name = 'buddypress';
}else{
	$context['post'] = $post =  new TimberPost();
}
Timber::render(array('page-' . $post->post_name . '.twig', 'page.twig'), $context);