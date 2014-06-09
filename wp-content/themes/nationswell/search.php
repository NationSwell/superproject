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
	function get_next_page_link($current) {
	return remove_query_arg('ajax-more', get_pagenum_link($current));
	}
	$page = max($wp_query->query_vars['paged'], 1);
	$data['more'] = $wp_query->max_num_pages > $page ? get_next_page_link($page+1) : false;
    $data['total_results'] = $wp_query->found_posts;
	$data['title'] = 'Search results for '. get_search_query();
	$data['posts'] = Timber::get_posts(array(), 'NationSwellPost');
    $data['sidebar_static'] = Timber::get_widgets('sidebar_static');
    
    $more = isset($_GET['ajax-more']);
	
	Timber::render($more ? 'search-more.twig' : $templates, $data);
