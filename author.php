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
function get_next_page_link($current) {
	return remove_query_arg('ajax-more', get_pagenum_link($current));
}

$page = max($wp_query->query_vars['paged'], 1);
$data['more'] = $wp_query->max_num_pages > $page ? get_next_page_link($page+1) : false;
$data['posts'] = Timber::get_posts(false, 'NationSwellPost');

$author = new TimberUser($wp_query->query_vars['author']);
$data['author'] = $author;
$data['author']->mug_shot = get_field('mug_shot', 'user_' . $author->ID);
$data['author']->post_count = count_user_posts( $author->ID);
$data['title'] = 'Author Archives: ' . $author->name();

$data['sidebar_static'] = Timber::get_widgets('sidebar_static');

$more = isset($_GET['ajax-more']);

Timber::render($more ? 'archive-more.twig' : array('author.twig', 'archive.twig'), $data);
