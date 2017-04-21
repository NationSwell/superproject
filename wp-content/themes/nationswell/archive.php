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

$term = isset($wp_query->queried_object) ? $wp_query->queried_object : false;
$templates = array('archive.twig', 'index.twig');

$context = Timber::get_context();

$context['title'] = 'Topics';
$category_array = get_the_category();
//print_r($category_array);
foreach ($category_array as $cat) {
    //does this cat have a parent?
    $cat_id = $cat->term_id;
}

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

if($term && (is_tag() || is_category() || is_tax())) {
    $context['header_image'] = get_field('header_image', $term->taxonomy . '_' . $term->term_id);

    $context['video_url'] = get_field('video_url', $term->taxonomy . '_' . $term->term_id);
    $context['video_caption'] = get_field('video_caption', $term->taxonomy . '_' . $term->term_id);
    $context['video_credit'] = get_field('video_credit', $term->taxonomy . '_' . $term->term_id);
    $context['custom_title'] = get_field('custom_title', $term->taxonomy . '_' . $term->term_id);
    $context['display_desc'] = get_field('display_desc', $term->taxonomy . '_' . $term->term_id);
    
    $context['sponsored_category'] = get_field('sponsored_category', $term->taxonomy . '_' . $term->term_id);
    $context['category_type'] = get_field('category_type', $term->taxonomy . '_' . $term->term_id);
    $context['category_sponsor_name'] = get_field('category_sponsor_name', $term->taxonomy . '_' . $term->term_id);
    $context['category_sponsor_link'] = get_field('category_sponsor_link', $term->taxonomy . '_' . $term->term_id);
    $category_sponsor_image_id = get_field('category_sponsor_image', $term->taxonomy . '_' . $term->term_id);
    $category_sponsor_image_array =  wp_get_attachment_image_src($category_sponsor_image_id,$size = 'medium');
    //print_r($category_sponsor_image_array);
    $context['category_sponsor_image'] = $category_sponsor_image_array[0];

    $context['description'] = $term->description;
    $context['category_url'] = get_category_link( $cat_id );
    $context['term_facebook_link'] = term_facebook_link( $term );
    $context['term_twitter_link'] = term_twitter_link( $term );
    $context['total_posts'] = $wp_query->found_posts;
}

if($term && is_tax()) {
    $context['series_enabled'] = !(get_field('disable_series', $term->taxonomy . '_' . $term->term_id));
}

function term_facebook_link($current_term) {
    return 'http://www.facebook.com/sharer.php?u=' . urlencode(get_term_link($current_term));
}

function term_twitter_link($current_term) {

    return 'https://twitter.com/share?url='
    . urlencode(get_term_link($current_term)) . '&text=' . $current_term->name . '&via=nationswell';
}

function get_next_page_link($current) {
    return remove_query_arg('ajax-more', get_pagenum_link($current));
}

$page = max($wp_query->query_vars['paged'], 1);
$context['more'] = $wp_query->max_num_pages > $page ? get_next_page_link($page + 1) : false;
$context['posts'] = Timber::get_posts(false, 'NationSwellPost');

$context['sidebar_static'] = Timber::get_widgets('sidebar_static');



$more = isset($_GET['ajax-more']);

Timber::render($more ?'archive-more.twig' : $templates, $context);
