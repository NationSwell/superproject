<?php

class ChangeOrgPetition {
    private $debug = true;
    private $api_key = '937ae45924510660d19d71f3622aee68810b8e8969c418da92afdde2e618be8f';
    private $secret = '9955d60df46358b12c33646352e54c50a28ea2f54fdc45fe4d7457307d847cf5';

    private $url;
    private $post_id;

    private $id;
    private $auth_key;
    private $content;

    function __construct($post_id) {
        $this->post_id = $post_id;

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
        if($this->should_fetch()) {
            $this->log("updating");

            $id = $this->fetch_id();
            if($id) {
                $auth_key = $this->fetch_auth_key();
                if($auth_key) {
                    $this->set_id('id', $id);
                    $this->set_auth_key($auth_key);
                    $this->set_post_field('hash', $this->hash());
                }
            }
        }
        else {
            $this->log("not updated");
        }

        $petition_content = $this->fetch_content();
        if($petition_content) {
            $this->log("updated content");
            $this->set_content($petition_content);
        }

        $this->log(get_post_meta($this->post_id));
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

    private function fetch_id() {
        $query_string = http_build_query(array('api_key' => $this->api_key, 'petition_url' => $this->url));
        $response = file_get_contents("https://api.change.org/v1/petitions/get_id?" . $query_string);

        $result = false;
        if($response) {
            $json_response = json_decode($response, true);
            if($json_response) {
                $result = $json_response['petition_id'];
            }
        }

        return $result;
    }

    private function fetch_content() {
        return file_get_contents('https://api.change.org/v1/petitions/' . $this->id . '?api_key=' . $this->api_key);
    }

    private function hash() {
        return md5($this->url . $this->id . $this->auth_key);
    }

    private function fetch_auth_key() {
        $host = 'https://api.change.org';
        $endpoint = "/v1/petitions/" . $this->id . "/auth_keys";
        $request_url = $host . $endpoint;

        $params = array();
        $params['api_key'] = $this->api_key;
        $params['source_description'] = 'This is a test description.'; // Something human readable.
        $params['source'] = 'test_source'; // Eventually included in every signature submitted with the auth key obtained with this request.
        $params['requester_email'] = 'mark@ronikdesign.com'; // The email associated with your API key and Change.org account.
        $params['timestamp'] = gmdate("Y-m-d\TH:i:s\Z"); // ISO-8601-formtted timestamp at UTC
        $params['endpoint'] = $endpoint;

        // Build request signature and add it as a parameter
        $query_string_with_secret_and_auth_key = http_build_query($params) . $this->secret;
        $params['rsig'] = hash('sha256', $query_string_with_secret_and_auth_key);

        // Final request body
        $query = http_build_query($params);

        // Make the request
        $curl_session = curl_init();
        curl_setopt_array($curl_session, array(
                CURLOPT_POST => 1,
                CURLOPT_URL => $request_url,
                CURLOPT_POSTFIELDS => $query,
                CURLOPT_RETURNTRANSFER => true
            ));

        $result = false;

        $response = curl_exec($curl_session);

        curl_close($curl_session);

        if($response) {
            $json_response = json_decode($response, true);
            if($json_response) {
                $result = $json_response['auth_key'];
            }
        }
        return $result;
    }


}