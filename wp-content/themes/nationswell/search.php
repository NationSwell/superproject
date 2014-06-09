<?php
/**
 * Search results page
 * 
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package 	WordPress
 * @subpackage 	Timber
 * @since 		Timber 0.1
 */


    global $wp_query;

	$templates = array('search.twig', 'archive.twig', 'index.twig');
	$data = Timber::get_context();
	if ($wp_query->is_author)
	{
		$author_found = $wp_query->queried_object;
	}
	$data['author'] = $author_found;
    $data['total_results'] = $wp_query->found_posts;
	$data['title'] = 'Search results for '. get_search_query();
	$data['posts'] = Timber::get_posts(array(), 'NationSwellPost');
    $data['sidebar_static'] = Timber::get_widgets('sidebar_static');
	
	Timber::render($templates, $data);
