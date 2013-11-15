<?php
if (class_exists('TimberPost')) {
    class NationSwellPost extends TimberPost {
        private $story_header_cache;
        private $more_stories_cache;


        function story_header() {
            if (!isset($this->story_header_cache)) {

                $this->story_header_cache = array();
                while (has_sub_field("story_page_header", $this->ID)) {
                    $layout = get_row_layout();
                    $item = array(
                        'type' => $layout
                    );
                    if ($layout == "image") { // layout: Content
                        $item = array_merge(get_sub_field('image'), $item);
                        $item['credit'] = get_field('credit', $item['id']);
                    } elseif ($layout == "video") { // layout: File
                        $item['video_url'] = get_sub_field('video_url');
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

        function facebook_share_url(){
            return 'https://www.facebook.com/sharer/sharer.php?u='
            . urlencode($this->permalink()) .'&title=' . urlencode($this->title());
        }

        function twitter_share_url(){
            return 'https://twitter.com/share?url='
            . urlencode($this->permalink()) . '&text=' . urlencode($this->title()) . '&via=nationswell';
        }
    }
}