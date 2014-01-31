<?php
class NationSwellVideo {
    private $url;
    private $oEmbed;

    function __construct($url) {
        if(!empty($url)) {
            if($this->is_youtube_url($url)) {
                $this->url = $this->get_youtube_iframe_url($url);
            }
            elseif(function_exists('wp_oembed_get')) {
                $this->oEmbed = wp_oembed_get($url);
            }
        }
    }

    public function url() {
        return $this->url;
    }

    public function oEmbed() {
        return $this->oEmbed;
    }


    private function get_youtube_iframe_url($url) {
        return $this->normalize_youtube_url($url) .
        '?origin=' . urlencode(get_site_url()) . '&autoplay=0&autohide=1' .
        '&controls=2&enablejsapi=1&modestbranding=1&rel=0&theme=light&color=fc3b40&showinfo=0';
    }

    private function is_youtube_url($url) {
        return strpos('www.youtube.com/', $url) !== false || strpos('youtu.be/', $url) !== false;
    }

    private function normalize_youtube_url($url) {
        if (strpos('//www.youtube.com/embed/', $url) === false  &&
            (preg_match('/\/\/www.youtube.com\/watch\?.*v=([^&#]+)/', $url, $matches) ||
                preg_match('/\/\/youtu.be\/([^&#]+)/', $url, $matches))) {

            $url = '//www.youtube.com/embed/' . $matches[1];
        }

        return $url;
    }

}