<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = new NationSwellPost();
$context['post'] = $post;
$context['wp_title'] .= ' - ' . $post->post_title;
$context['comment_form'] = TimberHelper::get_comment_form();
$context['sidebar_story'] = Timber::get_widgets('sidebar_story');
$is_widescreen = (get_field("content_type") == "widescreen");
$context['widescreen'] = $is_widescreen;

if ( !stripos( $post->post_content, '[newsletter]' ) && !get_field( "hide_in_story_widget" )) {
    $context['newsletter_bottom'] = do_shortcode( "[newsletter]" );
} else {
    $context['newsletter_bottom'] = "";
}

if ( isset($_COOKIE["subscribed"] )) {
    $context['prompt_signup'] = false;
} else {
    $context['prompt_signup'] = true;
}

Timber::render(array('single.twig'), $context);