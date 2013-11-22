<?php

class ChangeOrgPetition {
    private $debug = false;

    private $post_id;
    private $change_org_api;

    private $url;
    private $id;
    private $auth_key;
    private $content;

    function __construct($post_id, $change_org_api = false) {
        $this->post_id = $post_id;
        $this->change_org_api = $change_org_api;

        $this->url = get_post_meta($this->post_id, 'change_url',true);
        $this->id = $this->get_post_field('id');
        $this->auth_key = $this->get_post_field('auth_key');
        $this->content = json_decode($this->get_post_field('content'));

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
        $this->set_post_field('content', $content);
    }

    public function fetch() {
        if($this->change_org_api) {
            $api = $this->change_org_api;

            if($this->should_fetch()) {
                $this->log("updating");

                $id = $api->get_id($this->url);
                if($id) {
                    $auth_key = $api->get_auth_key($id);
                    if($auth_key) {
                        $this->set_id($id);
                        $this->set_auth_key($auth_key);
                        $this->set_post_field('hash', $this->hash());
                    }
                }
            }
            else {
                $this->log("not updated");
            }

            $petition_content = $api->get_petition_json($this->id);
            if($petition_content) {
                $this->log("updated content");
                $this->set_content($petition_content);
            }

            $this->log($this);
        }
    }

    public function sign($signer) {
        $result = false;
        if($this->change_org_api) {
            $result = $this->change_org_api->sign_petition($this->id, $this->auth_key, $signer);
        }

        return $result;
    }

    private function should_fetch() {
        if(!empty($this->url)) {
            return empty($this->id) || empty($this->auth_key) || $this->hash() !== $this->get_post_field('hash');
        }

        return false;
    }

    private function log($o) {
        if($this->debug) {
            error_log("\n" . print_r($o, true), 3, "/tmp/my-errors.log");
        }
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