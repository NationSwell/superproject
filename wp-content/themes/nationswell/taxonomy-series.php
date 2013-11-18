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
$data = Timber::get_context();
$data['posts'] = Timber::get_posts();

Timber::render('series.twig', $data);
