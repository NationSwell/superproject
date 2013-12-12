<?php
/**
 * The template for displaying Author Archive pages
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */
global $wp_query;

$data = Timber::get_context();
$data['posts'] = Timber::get_posts(false, 'NationSwellPost');

$author = new TimberUser($wp_query->query_vars['author']);
$data['author'] = $author;
$data['author']->mug_shot = get_field('mug_shot', 'user_' . $author->ID);
$data['author']->post_count = count_user_posts( $author->ID);
$data['title'] = 'Author Archives: ' . $author->name();

$data['sidebar_static'] = Timber::get_widgets('sidebar_static');

Timber::render(array('author.twig', 'archive.twig'), $data);
