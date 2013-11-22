<?php
if (class_exists('TimberPost')) {
    class NationSwellPost extends TimberPost {
        private $story_header_cache;
        private $more_stories_cache;


        function story_header() {
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
                    }

                    $this->story_header_cache[] = $item;
                }
            }

            return $this->story_header_cache;
        }

        function author() {
            $author = parent::author();
            $author->mug_shot = get_field('mug_shot', 'user_' . $author->ID);

            if(isset($author->user_url)) {
                $url = preg_replace('/https?:\/\//', '', $author->user_url);

                if(($pos = strpos($url,'/')) !== false) {
                    $url = substr($url, 0, $pos);
                }
                $author->display_url = $url;
            }
            return $author;
        }

        function petiton() {

        }

        function more_stories() {
            if(!isset($this->more_stories_cache)) {
                $this->more_stories_cache = array();
                $categories = get_the_category($this->ID);

                if(!empty($categories)) {
                    $this->more_stories_cache = $this->get_more_stories($categories[0]->term_id);
                }

            }

            return $this->more_stories_cache;
        }

        private function get_more_stories($term_id) {
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

        function short_url() {
            global $bitly;
            // if bitly plugin is disabled fallback on the permalink
            return isset($bitly) ? $bitly->get_bitly_link_for_post_id($this->ID) : $this->permalink();
        }

        function facebook_share_url(){
            return 'https://www.facebook.com/sharer/sharer.php?u='
            . urlencode($this->short_url()) .'&title=' . urlencode($this->title());
        }

        function twitter_share_url(){
            return 'https://twitter.com/share?url='
            . urlencode($this->short_url()) . '&text=' . urlencode($this->title()) . '&via=nationswell';
        }

        function call_to_action(){
            $cta_id = get_field('call_to_action_link', $this->ID);

            if(!empty($cta_id)) {
                return Timber::get_post($cta_id, 'CallToAction');
            }

            return false;
        }

        function tout_title(){
            return $this->tout_heading ? $this->tout_heading : $this->post_title;
        }

        function tout_dek_text(){
            return $this->tout_dek ? $this->tout_dek : $this->dek;
        }
    }
}