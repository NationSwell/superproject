<?php
/**
 * The Template for displaying all Editor's Picks Posts
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();

$post = Timber::get_post();
$posts = get_field( 'editors_picks_posts', $post->ID );

$context['posts'] = Timber::get_posts( $posts, 'NationSwellPost' );
$context['title'] = $post->post_title;
$context['wp_title'] .= ' - ' . $post->post_title;

Timber::render( array( 'editors-picks.twig', 'single.twig' ), $context );
