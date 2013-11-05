<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['wp_title'] .= ' - ' . $post->post_title;
$context['comment_form'] = TimberHelper::get_comment_form();


$story_header = array();
while(has_sub_field("story_page_header")) {
    $layout = get_row_layout();
    $item = array(
        'type' => $layout
    );
    if($layout == "image") { // layout: Content
        $item = array_merge(get_sub_field('image'), $item);
    }
    elseif($layout == "video") { // layout: File
        $item['video_url'] = get_sub_field('video_url');
    }

    $story_header[] = $item;
}

$context['story_page_header'] = $story_header;

Timber::render(array('single-' . $post->post_type . '.twig', 'single.twig'), $context);


