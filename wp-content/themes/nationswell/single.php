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
$is_photo_essay = (get_field("content_type") == "photoessay");
$context[photo-esay] = $is_photo_essay;

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

Timber::render($is_photo_essay ? 'photo-essay.twig' : array('single-' . $post->post_type . '.twig', 'single.twig'), $context);