<?php
if (class_exists('TimberPost')) {

    class CallToAction extends TimberPost {

        private $petition;
        private $current;
        private $goal;

        function __construct($pid = null) {
            parent::__construct($pid);

            // remove the image property and use the acf function instead;
            if(isset($this->image)) {
                unset($this->image);
            }
        }

        public function days_until(){
            $datetime1 = new DateTime(date('Y-m-d'));

            $datetime2 = new DateTime($this->goal_date);

            $interval = $datetime1->diff($datetime2);
            return $interval->format('%a');
        }

        public function current() {
            if(!isset($this->current)) {
                $this->get_stats();
            }

            return $this->current;
        }

        public function goal() {
            if(!isset($this->goal)) {
                $this->get_stats();
            }

            return $this->goal;
        }

        private function get_stats() {
            $petition = $this->petition();
            if($petition) {
                $content = $petition->content();

                $this->current = $content->signature_count;
                $this->goal = $content->goal;
            }
            else {
                $this->current = 0;
                $this->goal = 0;
            }
        }

        public function petition() {
            global $change_org_api;

            if(!isset($this->petition)) {
                $this->petition = $this->type === 'petition' ?
                    $change_org_api->get_petition_from_post($this->ID) : false;
            }

            return $this->petition;
        }

        public function image() {
            return get_field('image', $this->ID);
        }
    }
}