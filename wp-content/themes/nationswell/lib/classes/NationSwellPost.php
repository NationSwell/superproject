<?php
if (class_exists('TimberPost')) {
    class NationSwellPost extends TimberPost
    {
        private $story_header_cache = null;


        function story_header()
        {
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
    }
}