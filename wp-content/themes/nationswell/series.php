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

$args = array(
    'post_type' => 'post',
    'tax_query' => array(
        array(
            'taxonomy' => 'series'
        )
    )
);

$data = Timber::get_context();
$data['posts'] = Timber::get_posts($args);

Timber::render(array('series.twig', 'archive.twig'), $data);
