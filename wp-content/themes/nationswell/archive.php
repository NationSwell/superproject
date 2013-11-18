<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package 	WordPress
 * @subpackage 	Timber
 * @since 		Timber 0.2
 */
global $wp_query;

$term = $wp_query->queried_object;
$templates = array('archive.twig', 'index.twig');

$context = Timber::get_context();

$context['title'] = 'Archive';
if (is_day()){
    $context['title'] = 'Archive: '.get_the_date( 'D M Y' );
}
elseif (is_month()){
    $context['title'] = 'Archive: '.get_the_date( 'M Y' );
}
elseif (is_year()){
    $context['title'] = 'Archive: '.get_the_date( 'Y' );
}
elseif (is_tag()){
    $context['title'] = single_tag_title('', false);
}
elseif (is_category()){
    $context['title'] = single_cat_title('', false);
    array_unshift($templates, 'archive-'.get_query_var('cat').'.twig');
}
elseif (is_tax()){
    $context['title'] = single_term_title('', false);
    array_unshift($templates, 'archive-' . $term->taxonomy .'.twig');
}
elseif (is_post_type_archive()){
    $context['title'] = post_type_archive_title('', false);
    array_unshift($templates, 'archive-'.get_post_type().'.twig');
}

if(is_tag() || is_category() || is_tax()) {
    $context['header_image'] = get_field('header_image', $term->taxonomy . '_' . $term->term_id);
    $context['total_posts'] = $wp_query->found_posts;
}


$context['posts'] = Timber::get_posts();

Timber::render($templates, $context);
