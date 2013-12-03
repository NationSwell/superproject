<?php

class ChangeOrgPetition {
    private $post_id;

    private $url;
    private $id;
    private $auth_key;
    private $content;
    private $last_updated;

    function __construct($post_id) {
        $this->post_id = $post_id;

        $this->url = get_post_meta($this->post_id, 'change_url',true);
        $this->id = $this->get_post_field('id');
        $this->auth_key = $this->get_post_field('auth_key');
        $this->content = json_decode($this->get_post_field('content'));

        $timestamp = $this->get_post_field('timestamp');
        $this->last_updated = is_numeric($timestamp) ? $timestamp : 0;
    }

    public function url() {
        return $this->url;
    }

    public function id() {
        return $this->id;
    }

    public function auth_key() {
        return $this->auth_key;
    }

    public function content() {
        return $this->content;
    }

    public function last_updated() {
        return $this->last_updated;
    }

    public function set_url($url) {
        $this->url = $url;
        $this->set_post_field('url', $url);
    }

    public function set_id($id) {
        $this->id = $id;
        $this->set_post_field('id', $id);
    }

    public function set_auth_key($auth_key) {
        $this->auth_key = $auth_key;
        $this->set_post_field('auth_key', $auth_key);
    }

    public function set_content($content) {
        $this->content = $content;
        $this->set_post_field('content', json_encode($content));
        $this->set_post_field('timestamp', time());
    }

    public function set_hash() {
        $this->set_post_field('hash', $this->hash());
    }

    public function should_update() {
        if(!empty($this->url)) {
            return empty($this->id) || empty($this->auth_key) || $this->hash() !== $this->get_post_field('hash');
        }

        return false;
    }

    private function get_post_field($name) {
        return get_post_meta($this->post_id, '_change_' . $name ,true);
    }

    private function set_post_field($name, $value) {
        update_post_meta($this->post_id, '_change_' . $name, $value);
    }

    private function hash() {
        return md5($this->url . $this->id . $this->auth_key);
    }
}