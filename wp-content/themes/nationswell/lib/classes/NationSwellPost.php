<?php
if (class_exists('TimberPost')) {
    class NationSwellPost extends TimberPost
    {
        private $story_header_cache;
        private $more_stories_cache;
        private $authors_cache;


        function story_header()
        {
            if (!isset($this->story_header_cache)) {

                $this->story_header_cache = array();
                while (has_sub_field("hero", $this->ID)) {
                    $layout = get_row_layout();
                    $item = array(
                        'type' => $layout
                    );
                    if ($layout == "image") { // layout: Content
                        $item = array_merge(get_sub_field('image'), $item);
                        $item['credit'] = get_field('credit', $item['id']);
                    } elseif ($layout == "video") { // layout: File
                        // TODO: Generating a proper YouTube URL should be abstracted. Duplicated in placeholder.php
                        $item['video_url'] = normalize_youtube_url(get_sub_field('video_url')) .
                            '?origin=' . urlencode(get_site_url()) . '&autoplay=0&autohide=1' .
                            '&controls=2&enablejsapi=1&modestbranding=1&rel=0&theme=light&color=fc3b40&showinfo=0';
                        $item['credit'] = get_sub_field('credit');
                        $item['caption'] = get_sub_field('caption');
                    }

                    $this->story_header_cache[] = $item;
                }
            }

            return $this->story_header_cache;
        }



        private function enhance_author($author)
        {
            $author->mug_shot = get_field('mug_shot', 'user_' . $author->ID);
            $author->author_page = get_author_posts_url($author->ID);

            if (isset($author->user_url))
            {
                $url = preg_replace('/https?:\/\//', '', $author->user_url);

                if (($pos = strpos($url, '/')) !== false)
                {
                    $url = substr($url, 0, $pos);
                }
                $author->display_url = $url;
            }

            return $author;
        }

        private function load_authors() {
            if(!isset($this->authors_cache))
            {
                $this->authors_cache = array();
                foreach(get_coauthors($this->ID) as $author)
                {
                    $this->authors_cache[] = $this->enhance_author($author);
                }
            }
        }

        function author()
        {
            $this->load_authors();
            return !empty($this->authors_cache) ? $this->authors_cache[0] : false;
        }

        function authors()
        {
            $this->load_authors();
            return $this->authors_cache;
        }

        function more_stories()
        {

            $page = get_page_by_path( 'home' );
            $featured_ids = get_field('featured', $page->ID);
            $featured_posts = Timber::get_posts($featured_ids, 'NationSwellPost');

            return $featured_posts;
        }

        private function get_more_stories($term_id)
        {
            $query = new WP_Query(array(
                'fields' => 'ids',
                'posts_per_page' => 3,
                'post_type' => 'post',
                'post__not_in' => array($this->ID),
                'orderby' => 'date',
                'order' => 'DESC',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'category',
                        'field' => 'id',
                        'terms' => $term_id
                    )
                )
            ));

            return Timber::get_posts($query->posts, 'NationSwellPost');
        }

        function short_url()
        {
            global $bitly;

            // if bitly plugin is disabled fallback on the permalink
            return isset($bitly) ? $bitly->get_bitly_link_for_post_id($this->ID) : $this->permalink();
        }

        function facebook_share_url()
        {

            $facebook_share_text = !empty($this->facebook_share) ? $this->facebook_share : $this->title();

            return 'http://www.facebook.com/sharer.php?s= 100&amp;p[url]='
            . urlencode($this->short_url()) . '&amp;p[title]=' . $this->title() . '&amp;p[summary]=' . $facebook_share_text;

        }

        function twitter_share_url()
        {

            $twitter_share_text = !empty($this->twitter_share) ? $this->twitter_share : $this->title();

            return 'https://twitter.com/share?url='
            . urlencode($this->short_url()) . '&text=' . urlencode($twitter_share_text) . '&via=nationswell';
        }

        function google_share_url()
        {
            return 'https://plus.google.com/share?url='
            . urlencode($this->short_url());
        }

        function call_to_action()
        {
            $cta_id = get_field('call_to_action_link', $this->ID);

            if (!empty($cta_id)) {
                return Timber::get_post($cta_id, 'CallToAction');
            }

            return false;
        }

        function tout_title()
        {
            return !empty($this->tout_heading) ? $this->tout_heading : $this->post_title;
        }

        function tout_dek_text()
        {

            if (!empty($this->tout_dek)) {
                return $this->tout_dek;
            } elseif (!empty($this->dek)) {
                return $this->dek;
            }

            return $this->get_preview(20, false, '');
        }

        function coauthors(){

            if(function_exists('coauthors_posts_links')) {
                return coauthors_posts_links(null, null, null, null, false);
            } else {
                return author();
            }
        }

    }
}