<?php

class RallyApi {

    private $drive;
    private $token;
    private $frequency;

    function __construct($drive, $token) {
        $this->drive = $drive;
        $this->token = $token;
        $this->frequency = HOUR_IN_SECONDS;

        add_filter('cron_schedules', array($this, 'cron_add_cta_schedule'));
        add_action('wp', array($this,'schedule_rally_fetch'));
        add_action('petition_fetch_event', array($this, 'scheduled_rally_fetch'));
    }

    public function set_frequency($frequency) {
        $this->frequency = $frequency;
    }

    // CRON
    function cron_add_cta_schedule( $schedules ) {
        $schedules['rally'] = array(
            'interval' => $this->frequency,
            'display' => __('Rally.org Fetch')
        );
        return $schedules;
    }

    function schedule_rally_fetch() {
        // Schedule rally fetching
        if (!wp_next_scheduled('rally_fetch_event')) {
            wp_schedule_event(time(), 'rally', 'rally_fetch_event');
        }
    }

    function scheduled_rally_fetch() {
        $causes = $this->get_all_causes();
        foreach ($causes as $cause) {
            $this->cache_cause($cause);
        }

        $this->log('Running scheduled fetch (' . $this->frequency . 's) for rally.org ' . $this->drive . ' drive.');
    }

    function cache_cause($cause) {
        $key = $this->cause_cache_key($cause['id']);
        set_transient($key, $cause, $this->frequency * 2);
    }

    function get_cause_from_cache($id) {
        return get_transient($this->cause_cache_key($id));
    }

    function cause_cache_key($id) {
        return 'rally_org_cause_' . $id;
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

    public function get_all_causes() {
        $url = 'https://rally.org/api/drives/' . $this->drive . '/causes?access_token=' . $this->token;
        $response = $this->get_request($url);

        if($response['response_code'] !== 200) {
            $this->log('Getting ' . $this->drive .' from rally.org failed (' . $response['response_code'] . ')', $response['data']);
        }

        return $response['data'];
    }

    public function get_cause($id) {
        $cause = $this->get_cause_from_cache($id);

        if($cause === false) {
            $url = 'https://rally.org/api/causes/' . $id . '?access_token=' . $this->token;
            $response = $this->get_request($url);

            if($response['response_code'] === 200) {
                $cause = $response['data'];
                $this->cache_cause($cause);
            }
            else {
                $this->log('Getting cause with id ' . $id .' from rally.org failed (' . $response['response_code'] . ')', $response['data']);
            }
        }

        return $cause;
    }

    private function log() {
        $msg = '';
        foreach(func_get_args() as $i => $arg) {
            if($i !== 0) {
                $msg .= "\n";
            }
            $msg .= print_r($arg, true);
        }
        error_log(get_class() . ' - ' . $msg);
    }
}