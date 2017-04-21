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

    public function set_hash($email) {
        $this->set_post_field('hash', $this->hash($email));
    }

    public function should_update($email) {
        if(!empty($this->url)) {
            return empty($this->id) || empty($this->auth_key) || $this->hash($email) !== $this->get_post_field('hash');
        }

        return false;
    }

    public function clear() {
        $this->delete_post_fields('id', 'auth_key', 'content', 'timestamp', 'hash');
    }

    private function delete_post_fields() {
        foreach(func_get_args() as $name) {
            delete_post_meta($this->post_id, '_change_' . $name);
        }
    }

    private function get_post_field($name) {
        return get_post_meta($this->post_id, '_change_' . $name ,true);
    }

    private function set_post_field($name, $value) {
        update_post_meta($this->post_id, '_change_' . $name, $value);
    }

    private function hash($email) {
        return md5($email . $this->url . $this->id . $this->auth_key);
    }
}