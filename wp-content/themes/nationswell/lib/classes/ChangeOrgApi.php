<?php

class ChangeOrgApi {

    private $api_key;
    private $secret;
    private $source;
    private $description;

    function __construct($api_key, $secret, $source, $description) {
        $this->api_key = $api_key;
        $this->description = $description;
        $this->secret = $secret;
        $this->source = $source;
    }


    private static function parseJson($json, $attr = '') {
        $result = false;

        if($json) {
            $parsed = json_decode($json, true);
            if($parsed) {
                $result = !empty($attr) ? $parsed[$attr] : $parsed;
            }
        }

        return $result;
    }

    public function get_id_json($url) {
        $query_string = http_build_query(array('api_key' => $this->api_key, 'petition_url' => $url));
        return file_get_contents("https://api.change.org/v1/petitions/get_id?" . $query_string);
    }

    public function get_id($url) {
        return ChangeOrgApi::parseJson($this->get_id_json($url), 'petition_id');
    }

    public function get_petition_json($id) {
        return file_get_contents('https://api.change.org/v1/petitions/' . $id . '?api_key=' . $this->api_key);
    }

    public function get_petition($id) {
        return ChangeOrgApi::parseJson($this->get_petition_json($id));
    }

    public function get_auth_key_json($id) {
        $host = 'https://api.change.org';
        $endpoint = "/v1/petitions/" . $id . "/auth_keys";
        $request_url = $host . $endpoint;

        $params = array(
            'api_key' => $this->api_key,
            'source_description' => 'This is a test description.', // Something human readable.
            'source' => 'test_source', // Eventually included in every signature submitted with the auth key obtained with this request.
            'requester_email' => 'mark@ronikdesign.com', // The email associated with your API key and Change.org account.
            'timestamp' => gmdate("Y-m-d\TH:i:s\Z"), // ISO-8601-formtted timestamp at UTC
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

        $response = curl_exec($curl_session);

        curl_close($curl_session);
        return $response;
    }

    public function get_auth_key($id) {
        return ChangeOrgApi::parseJson($this->get_auth_key_json($id), 'auth_key');
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
            'email' => 'person@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            //'address' => '1 Market St',
            'city' => 'Philadelphia',
            //'state_province' => 'PA',
            'postal_code' => '19144',
            'country_code' => 'US'
        );

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

        curl_close($curl_session);

        return ChangeOrgApi::parseJson($result);
    }

}