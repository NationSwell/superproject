<?php
if (class_exists('TimberPost')) {
    class CallToAction extends TimberPost {
        private $petition;

        function __construct($pid = null) {
            parent::__construct($pid);

            // remove the image property and use the acf function instead;
            if(isset($this->image)) {
                unset($this->image);
            }
        }

        public function petition() {
            if(!isset($this->petition)) {
                $this->petition = $this->type === 'petition' ? new ChangeOrgPetition($this->ID) : false;
            }

            return $this->petition;
        }

        public function image() {
            return get_field('image', $this->ID);
        }
    }
}