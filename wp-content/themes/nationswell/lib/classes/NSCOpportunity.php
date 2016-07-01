<?php
if (class_exists('TimberPost')) {
    class NSCOpportunity extends TimberPost
    {

        public static function getUpcomingOpportunities()
        {
            $oppData = array();
            $oppsPosts = NSCOpportunity::queryUpcomingOpportunities();
            $today = new DateTime(date('Y-m-d'));
            $oppData = array();
            if(!empty($oppsPosts)){
				foreach ($oppsPosts as $opps) {
					$opp=get_post( $opps );
					$oppData[] = array (
						'name' => $opp->post_title,
						'url' => get_permalink($opp),
						'description' => $opp->post_content,
						'time' => get_field('opportunity_time', $opp->ID),
						'location' => get_field('location', $opp->ID),
						'opportunity_url' => get_field('opportunity_url', $opp->ID),
						'application_deadline' => get_field('application_deadline', $opp->ID),
						'opportunity_type' => get_field('opportunity_type', $opp->ID),
						'fulldate' => get_field('opportunity_date', $opp->ID),
					);
				}
            }
            return $oppData;
        }
        private static function queryUpcomingOpportunities() {
            $upcomingOpps = get_posts( array(
                'numberposts' => -1,
                'fields' => 'ids',
                'post_type' => 'opportunity',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'post_status'	=> array('publish')
            ));
            return $upcomingOpps;
        }
    }
}