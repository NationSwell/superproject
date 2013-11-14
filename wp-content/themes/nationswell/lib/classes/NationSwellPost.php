<?php
if (class_exists('TimberPost')) {
    class NationSwellPost extends TimberPost {
        private $story_header_cache = null;


        function story_header() {
            if ($this->story_header_cache == null) {

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