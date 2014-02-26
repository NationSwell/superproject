<?php

class MailChimpFeed
{

    public $feed = 'daily-newsletter';

    public function __construct()
    {

        add_action('init', array($this, 'init'));

    }

    public function init()
    {

        // feed name to access in URL eg. /feed/custom-xml/
        add_feed($this->feed, array($this, 'xml'));

        global $wp_rewrite;
        //Call flush_rules() as a method of the $wp_rewrite object
        $wp_rewrite->flush_rules();

    }

    public function xml()
    {

        header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);

        $args = array(
            'post_type' => 'ns_daily_newsletter',
            'posts_per_page' => 1,
            'post_status' => 'publish',
        );
        $query = new WP_Query( $args );
        $post = Timber::get_post($query->posts);
        $context['feed_modified_date'] = date('r', strtotime($post->post_modified));
        $context['title'] = $post->post_title;
        $posts = get_field('daily_newsletter_posts', $post->ID);
        $context['posts'] = Timber::get_posts($posts, 'NationSwellPost');

        return Timber::render($this->feed . '.twig', $context);

    }

}

$mail_chimp_feed = new MailChimpFeed();
