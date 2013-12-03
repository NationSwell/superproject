<?php

class ChangeOrgApi {

    private $api_key;
    private $secret;
    private $source;
    private $description;

    function __construct($api_key, $secret, $email, $source, $description) {
        $this->api_key = $api_key;
        $this->description = $description;
        $this->email = $email;
        $this->secret = $secret;
        $this->source = $source;

        $this->poll_frequency = 60;
        $this->fetch_frequency = 60;

        add_filter('cron_schedules', array($this, 'cron_add_cta_schedule'));
        add_action('wp', array($this,'schedule_petition_fetch'));
        add_action('petition_fetch_event', array($this, 'scheduled_petition_fetch'));
    }

    // CRON
    function cron_add_cta_schedule( $schedules ) {
        $schedules['changeorg'] = array(
            'interval' => $this->poll_frequency,
            'display' => __('Change.org Fetch')
        );
        return $schedules;
    }

    function schedule_petition_fetch() {
        // Schedule petition fetching
        if (!wp_next_scheduled('petition_fetch_event')) {
            wp_schedule_event(time(), 'changeorg', 'petition_fetch_event');
        }
    }

    function scheduled_petition_fetch() {
        $cta_ids = get_transient('ns_petition_cta_ids');
        if(!empty($cta_ids)) {
            delete_transient('ns_petition_cta_ids');

            // Get all the petition ids and map them to petition objects
            $ids = array();
            $petition_posts = array();
            foreach($cta_ids as $cta_id) {
                $petition_post = new ChangeOrgPetition($cta_id);
                $id = $petition_post->id();
                if(!empty($id)) {
                    $ids[] = $id;
                    $petition_posts[$id] = $petition_post;
                }
            }

            // request updated information and update the petition objects
            $petitions = $this->get_petitions($ids);
            foreach($petitions as $petition) {
                $id = $petition['petition_id'];
                if(isset($petition_posts[$id])) {
                    $petition_posts[$id]->set_content($petition);
                }
            }
        }
    }

    // API
    private static function get_request($url) {
        $curl_session = curl_init();
        curl_setopt_array($curl_session, array(
            CURLOPT_URL => $url,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5
        ));

        $result = curl_exec($curl_session);
        $response_code = curl_getinfo($curl_session, CURLINFO_HTTP_CODE);
        curl_close($curl_session);

        $result = @json_decode($result, true);

        return array(
            'data' => $result ? $result : false,
            'response_code' => $response_code
        );
    }

    private static function get_response_property($response, $attr) {
        return $response ? $response['data'][$attr] : false;
    }

    public function get_id($url) {
        $query_string = http_build_query(array('api_key' => $this->api_key, 'petition_url' => $url));
        $response = $this->get_request("https://api.change.org/v1/petitions/get_id?" . $query_string);

        return $this->get_response_property($response, 'petition_id');
    }

    public function get_petitions($ids) {
        $url = 'https://api.change.org/v1/petitions/?petition_ids=' . implode(',', $ids) . '&api_key=' . $this->api_key;
        $response = $this->get_request($url);;

        return $response['data']['petitions'];
    }

    public function get_petition($id, $json = false) {
        $response = $this->get_request(
            'https://api.change.org/v1/petitions/' . $id . '?api_key=' . $this->api_key, $json);

        return $response['data'];
    }

    public function get_auth_key($id) {
        $host = 'https://api.change.org';
        $endpoint = "/v1/petitions/" . $id . "/auth_keys";
        $request_url = $host . $endpoint;

        $params = array(
            'api_key' => $this->api_key,
            'source_description' => $this->description,
            'source' => $this->source,
            'requester_email' => $this->email,
            'timestamp' => gmdate("Y-m-d\TH:i:s\Z"),
            'endpoint' => $endpoint
        );

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

        $json = curl_exec($curl_session);

        curl_close($curl_session);

        $result = false;

        if($json) {
            $parsed = @json_decode($json, true);
            if($parsed) {
                $result = $parsed['auth_key'];
            }
        }

        return $result;
    }

    public function sign_petition($id, $auth_key, $signer) {

        // Set up the endpoint and URL.
        $base_url = "https://api.change.org";
        $endpoint = "/v1/petitions/" . $id . "/signatures";
        $url = $base_url . $endpoint;

        // Set up the signature parameters.
        $parameters = array(
            'api_key' => $this->api_key,
            'timestamp' => gmdate("Y-m-d\TH:i:s\Z"), // ISO-8601-formtted timestamp at UTC
            'endpoint' => $endpoint,
            'source' => $this->source,
        );

        $parameters = array_merge($signer, $parameters);

        // Build request signature.
        $query_string_with_secret_and_auth_key = http_build_query($parameters) . $this->secret . $auth_key;

        // Add the request signature to the parameters array.
        $parameters['rsig'] = hash('sha256', $query_string_with_secret_and_auth_key);

        // Create the request body.
        $data = http_build_query($parameters);

        // POST the parameters to the petition's signatures endpoint.
        $curl_session = curl_init();
        curl_setopt_array($curl_session, array(
            CURLOPT_POST => 1,
            CURLOPT_URL => $url,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => true
        ));

        $result = curl_exec($curl_session);
        $response_code = curl_getinfo($curl_session, CURLINFO_HTTP_CODE);
        curl_close($curl_session);


        $parsed = json_decode($result, true);
        $parsed = $parsed ? $parsed : array();
        $parsed['response_code'] = $response_code;

        return $parsed;
    }

    public function get_petition_from_post($cta_id) {
        $petition = new ChangeOrgPetition($cta_id);
        if(time() - $petition->last_updated() > $this->fetch_frequency) {

            $ids = get_transient('ns_petition_cta_ids');
            $ids = $ids === false ? array() : $ids;

            $ids[] = $cta_id;

            set_transient('ns_petition_cta_ids', array_unique($ids),0);
        }


        return $petition;
    }

    public function sign($petition, $signer) {
        return $this->sign_petition($petition->id(), $petition->auth_key(), $signer);
    }

    public function fetch($petition) {
        if($petition->should_update()) {

            $id = $this->get_id($petition->url());
            if($id) {
                $auth_key = $this->get_auth_key($id);
                if($auth_key) {
                    $petition->set_id($id);
                    $petition->set_auth_key($auth_key);
                    $petition->set_hash();
                }
            }
        }

        $petition_content = $this->get_petition($petition->id());
        if($petition_content) {
            $petition->set_content($petition_content);
        }
    }
}