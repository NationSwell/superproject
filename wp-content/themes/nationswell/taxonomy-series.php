<?php
/**
 * The template for displaying Series Archive pages
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */
global $wp_query;

$data = Timber::get_context();

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ));

$data['series'] = array(
    'name' => $term->name,
    'count' => $wp_query->found_posts
);
$data['posts'] = Timber::get_posts();

Timber::render('series.twig', $data);
