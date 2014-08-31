<?php
if (class_exists('TimberPost')) {
    class NationSwellSeries extends TimberPost
    {


        function short_url()
        {
            global $bitly;


            // if bitly plugin is disabled fallback on the permalink
            return isset($bitly) ? $bitly->get_bitly_link_for_post_id($this->ID) : $this->permalink();
        }

//        function og_image()
//        {
//            if (class_exists('WPSEO_OpenGraph')){
//                ob_start();
//                $wpseo = new WPSEO_OpenGraph();
//                $wpseo->image_output($wpseo->image());
//                $og_meta = ob_get_contents();
//                $image = getAttribute('content', $og_meta);
//                ob_end_clean();
//
//                return $image;
//            } else {
//                return '';
//            }
//
//        }

        function facebook_share_url()
        {

            $facebook_share_text = !empty($this->facebook_share) ? $this->facebook_share : $this->tout_title();

            return 'http://www.facebook.com/sharer.php?m2w&s= 100'
            . '&amp;p[url]=' . urlencode($this->permalink())
            . '&amp;p[title]=' . urlencode($facebook_share_text)
            . '&amp;p[summary]=' . urlencode($this->tout_dek_text());
//            . '&amp;p[images][0]=' . urlencode($this->og_image());

        }

        function twitter_share_url()
        {

            $twitter_share_text = !empty($this->twitter_share) ? $this->twitter_share : $this->title();

            return 'https://twitter.com/share?url='
            . urlencode($this->short_url()) . '&text=' . $twitter_share_text . '&via=nationswell';
        }

        function google_share_url()
        {
            return 'https://plus.google.com/share?url='
            . urlencode($this->short_url());
        }

        function header_image()
        {
            return get_field('header_image');
        }

        function series_posts()
        {
            $series_post_ids = get_field('ns_series_posts');
            $ns_series_posts = Timber::get_posts($series_post_ids, 'NationSwellPost');

            return $ns_series_posts;
        }

        function total_posts()
        {
            return count(get_field('ns_series_posts'));
        }

        function description()
        {
            return get_field('description');
        }


    }
}