<?php
/**
 * The Template for displaying all nsc event posts
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = new NSCEvent();
$context['post'] = $post;
$context['wp_title'] .= ' - ' . $post->post_title;


Timber::render("single-nscevent.twig", $context);