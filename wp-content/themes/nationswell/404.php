<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
<<<<<<< HEAD
$context['popular_posts'] = Timber::get_posts(get_field('popular_posts', 'option'), 'NationSwellPost');
=======
>>>>>>> dev
Timber::render('404.twig', $context);