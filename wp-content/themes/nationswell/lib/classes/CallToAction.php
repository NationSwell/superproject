<?php
if (class_exists('TimberPost')) {

    class CallToAction extends TimberPost {
        private $petition_cache;
        private $donation_cache;

        function __construct($pid = null) {
            parent::__construct($pid);

            // remove the image property and use the acf function instead;
            if(isset($this->image)) {
                unset($this->image);
            }

            $this->get_stats();
        }

        private function get_stats() {
            if(($petition = $this->petition()) !== false) {
                $content = $petition->content();
                if($content) {
                    $this->current_amount = $content->signature_count;
                    $this->goal_amount = $content->goal;
                    $this->goal_date = $content->end_at;
                }
            }
            elseif(($donation = $this->donation()) !== false) {
                $this->current_amount  = $donation['raised_toward_fundraising_goal'] / 100;
                $this->goal_amount  = $donation['current_fundraising_goal'] / 100;
            }
        }

        public function days_until(){
            $datetime1 = new DateTime(date('Y-m-d'));

            $datetime2 = new DateTime(date('Y-m-d'));

            $interval = $datetime1->diff($datetime2);
            return $interval->format('%a');
        }

        public function goal_percentage(){
            if(isset($this->current_amount) && isset($this->goal_amount)) {
                return ceil($this->current_amount / $this->goal_amount * 100);
            }
            return 0;
        }

        public function petition() {
            global $change_org_api;

            if(!isset($this->petition_cache)) {
                if($this->type === 'petition' && isset($change_org_api)) {
                    $this->petition_cache = $change_org_api->get_petition_from_post($this->ID);
                }
                else {
                    $this->petition_cache = false;
                }
            }

            return $this->petition_cache;
        }

        public function donation() {
            global $rally_api;

            if(!isset($this->donation_cache)) {
                if($this->type === 'donation' && isset($rally_api) && isset($this->rally_id)) {
                    $this->donation_cache = $rally_api->get_cause($this->rally_id);
                }
                else {
                    $this->donation_cache = false;
                }
            }

            return $this->donation_cache;

        }

        public function image() {
            return get_field('image', $this->ID);
        }
    }
}