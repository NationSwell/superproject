<?php

add_action('widgets_init', 'subscribe_widget');

function subscribe_widget()
{
    register_widget( 'Subscribe_Widget' );
}

class Subscribe_Widget extends WP_Widget {

    function Subscribe_Widget() {
        $widget_ops = array('classname' => 'subscribe', 'description' => 'NationSwell Widget for collecting subscriptions');

        $control_ops = array('id_base' => 'subscribe-widget');

        $this->WP_Widget( 'subscribe-widget', 'NationSwell Subscribe Widget', $widget_ops, $control_ops );
    }


    function widget( $args, $instance) {
        extract( $args );

        //Our variables from the widget settings.
        $context = array();
        $context['title'] = apply_filters('widget_title', $instance['title'] );
        $context['description'] = $instance['description'];
        $context['mailchimp_form_action'] = $instance['mailchimp_form_action'];

        $template = array('widget-subscribe.twig', 'empty.twig');

        echo $before_widget;

        // do not echo:
        ob_start();
        $output = Timber::render($template, $context);
        ob_end_clean();

        echo $output;

        echo $after_widget;
    }

    //Update the widget
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        //Strip tags from title and name to remove HTML
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['description'] = strip_tags( $new_instance['description'] );
        $instance['mailchimp_form_action'] = strip_tags( $new_instance['mailchimp_form_action'] );

        return $instance;
    }

    function form( $instance ) {

        //Set up some default widget settings.
        $defaults = array( 'title' => 'Subscribe', 'description' => 'Subscribe to the NationSwell newsletter to receive daily updates.', 'mailchimp_form_action' => '');
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'Subscribe'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e('Description:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" value="<?php echo $instance['description']; ?>" style="width:100%;" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'mailchimp_form_action' ); ?>"><?php _e('MailChimp List ID:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'mailchimp_form_action' ); ?>" name="<?php echo $this->get_field_name( 'mailchimp_form_action' ); ?>" value="<?php echo $instance['mailchimp_form_action']; ?>" style="width:100%;" />
        </p>

    <?php
    }

}

?>
