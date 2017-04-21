<?php /* Template name: Summit splash */ ?>

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
$context['post'] = $post;
$context['where'] = get_field('where');
$context['when'] = get_field('when');
$context['mailchimp_list_id'] = get_field('mailchimp_list_id');
$context['mailchimp_user_id'] = get_field('mailchimp_user_id');
$background_image = get_field('background_image');
$context['background_image_url'] = $background_image[url];
$context['background_image_alt'] = $background_image[alt];
$context['previous_years'] = get_field('previous_years');
$context['email_sign_up_copy'] = get_field('email_sign_up_copy');
$context['current_year'] = date("Y");
$context['home'] = esc_url( home_url( '/' ) );

if (post_password_required($post->ID)){
    Timber::render('static-password.twig', $context);
} else {
    print_r($context['background_image']);
    Timber::render(array('static-' . $post->post_name . '.twig', 'summit-splash.twig'), $context);
}