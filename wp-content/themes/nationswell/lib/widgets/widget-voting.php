<?php

add_action('widgets_init', 'voting_widget');

function Voting_Widget()
{
    register_widget( 'Voting_Widget' );
}

class Voting_Widget extends WP_Widget {

    function Voting_Widget() {
        $widget_ops = array('classname' => 'voting-widget', 'description' => 'NationSwell Allstars Voting Widget');

        $control_ops = array('id_base' => 'voting-widget');

        $this->WP_Widget( 'voting-widget', 'NationSwell AllStars Voting Widget', $widget_ops, $control_ops );
    }


    function widget( $args, $instance) {
        extract( $args );

        echo $before_widget;
        echo do_shortcode('[gravityform id="4" title="false" description="false" ajax="true"]');
        echo $after_widget;
    }

    //Update the widget
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        //Strip tags from title and name to remove HTML
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['description'] = strip_tags( $new_instance['description'] );

        return $instance;
    }

    function form( $instance ) {

        //Set up some default widget settings.
        $defaults = array( 'title' => 'Subscribe', 'description' => 'Subscribe to the NationSwell newsletter to receive daily updates.', 'mailchimp_form_action' => '');
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <p></p>

    <?php
    }

}

?>
