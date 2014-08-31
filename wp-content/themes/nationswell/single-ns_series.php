<?php
/**
 * The template for displaying Series pages.

 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package 	WordPress
 * @subpackage 	Timber
 * @since 		Timber 0.2
 */

$context = Timber::get_context();
$context['series'] = new NationSwellSeries();
error_log("SERIES IMG: " . $context['series']->header_image());
$context['posts'] = $context['series']->series_posts();
$context['sidebar_static'] = Timber::get_widgets('sidebar_static');


Timber::render('series.twig', $context);
