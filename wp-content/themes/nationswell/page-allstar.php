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
$context['post'] = $post;
$context['previous_years'] = get_field('previous_years');
$context['home'] = esc_url( home_url( '/' ) );



if (post_password_required($post->ID)){
    Timber::render('static-password.twig', $context);
} else {
    Timber::render(array('static-' . $post->post_name . '.twig', 'allstars-v2.twig'), $context);
}