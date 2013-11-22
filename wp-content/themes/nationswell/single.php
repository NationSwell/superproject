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

Timber::render(array('single-' . $post->post_type . '.twig', 'single.twig'), $context);