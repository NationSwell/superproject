<?php
add_shortcode('ph', 'placeholder_shortcode');

/**
 * The Gallery shortcode.
 *
 * This implements the functionality of the Gallery Shortcode for displaying
 * WordPress images on a post.
 *
 * @since 2.5.0
 *
 * @param array $attr Attributes of the shortcode.
 * @return string HTML content to display gallery.
 */
function placeholder_shortcode($attr) {
    $post = get_post();

    static $index = 0;
    static $component_cache = null;


    if($component_cache === null) {
        $component_cache = array();
        while(has_sub_field("story_content", $post->ID)) {
            $layout = get_row_layout();
            $component = array('type' => $layout);

            if($layout == "image") {
                $component = array_merge(get_sub_field('image'), $component);
                $component['credit'] = get_field('credit', $component['id']);
            }
            elseif($layout == "video") {
                $component['title'] = get_sub_field('title');
                $component['video_url'] = get_sub_field('video_url');
                $component['credit'] = get_sub_field('credit');
            }
            elseif($layout == "pull_quote") {
                $component['text'] = get_sub_field('text');
                $component['credit'] = get_sub_field('credit');
            }
            elseif($layout == "related") {
                $component['related_posts'] = Timber::get_posts(get_sub_field('related'));
                $component['position'] = get_sub_field('position');
            }

            $component_cache[] = $component;
        }
    }

    $context = array();

    if($index < count($component_cache)) {
        $component = $component_cache[$index];
        if($component) {
            $context = $component;
        }
        $template = ['component-' . $component['type'] .'.twig', 'empty.twig'];
    }
    else {
        $template = is_user_logged_in() ? 'component-extraneous.twig' : 'empty.twig';
    }

    // do not echo:
    ob_start();
    $output = Timber::render($template, $context);
    ob_end_clean();

    $index++;

    return $output;

}