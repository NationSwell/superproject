<?php
if (class_exists('TimberPost')) {
    class NSCEvent extends TimberPost
    {
        private $story_header_cache;


        function story_header()
        {
            if (!isset($this->story_header_cache)) {

                $this->story_header_cache = array();
                while (has_sub_field("hero", $this->ID)) {
                    $layout = get_row_layout();
                    $item = array(
                        'type' => $layout
                    );
                    if ($layout == "image") {
                        $item = array_merge(get_sub_field('image'), $item);
                        $item['credit'] = get_field('credit', $item['id']);

                    } elseif ($layout == "video") {
                        $item['credit'] = get_sub_field('credit');
                        $item['caption'] = get_sub_field('caption');
                        $item['video'] = new NationSwellVideo(get_sub_field('video_url'));
                    }
                    $this->story_header_cache[] = $item;
                }
            }

            return $this->story_header_cache;
        }

        public static function getUpcomingEvents()
        {
            $eventData = array();
            $events = NSCEvent::queryUpcomingEvents();
            $eventPosts = Timber::get_posts($events);
            $today = new DateTime(date('Y-m-d'));

            foreach ($eventPosts as $event) {
                $dateObj = DateTime::createFromFormat('Ymd', get_field('event_date', $event->ID));
                $eventData[] = array (
                    'name' => $event->post_title,
                    'url' => get_permalink($event),
                    'description' => get_field('dek', $event->ID),
                    'time' => get_field('event_time', $event->ID),
                    'location' => get_field('location', $event->ID),
                    'date' => $dateObj->format('j-M'),
                    'year' => $dateObj->format('Y'),
                    'sortdate' => $dateObj->format('Ymd')
                );
            }

            return $eventData;
        }

        public static function getPastEvents()
        {
            $eventData = array();
            $events = NSCEvent::queryPastEvents();
            $eventPosts = Timber::get_posts($events);

            foreach ($eventPosts as $event) {
                $dateObj = DateTime::createFromFormat('Ymd', get_field('event_date', $event->ID));
                $eventData[] = array (
                    'name' => $event->post_title,
                    'url' => get_permalink($event),
                    'description' => get_field('dek', $event->ID),
                    'time' => get_field('event_time', $event->ID),
                    'location' => get_field('location', $event->ID),
                    'date' => $dateObj->format('j-M'),
                    'year' => $dateObj->format('Y'),
                    'sortdate' => $dateObj->format('Ymd')
                );
            }

            return $eventData;
        }

        private static function queryUpcomingEvents() {
            $upcomingEvents = get_posts( array(
                'numberposts' => -1,
                'fields' => 'ids',
                'post_type' => 'nscevent',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'meta_query' => array(
                        array(
                            'key' => 'event_date',
                            'value' => date("Y-m-d"),
                            'compare' => '>=',
                            'type'    => 'DATE'
                        )
                    )
            ));
            return $upcomingEvents;
        }

        private static function queryPastEvents() {
            $pastEvents = get_posts( array(
                'numberposts' => -1,
                'fields' => 'ids',
                'post_type' => 'nscevent',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'meta_query' => array(
                    array(
                        'key' => 'event_date',
                        'value' => date("Y-m-d"),
                        'compare' => '<',
                        'type'    => 'DATE'
                    )
                )
            ));
            return $pastEvents;
        }

    }
}