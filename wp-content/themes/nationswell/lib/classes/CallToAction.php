<?php
if (class_exists('TimberPost')) {
    class CallToAction extends TimberPost {
        private $petition;

        public function petition() {
            if(!isset($this->petition)) {
                $this->petition = $this->type === 'petition' ? new ChangeOrgPetition($this->ID) : false;
            }

            return $this->petition;
        }
    }
}