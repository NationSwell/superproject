<?php

add_action('widgets_init', 'joinus_widget');

function joinus_widget()
{
    register_widget( 'Joinus_Widget' );
}

class Joinus_Widget extends WP_Widget {

    function Joinus_Widget() {
        $widget_ops = array('classname' => 'example', 'description' => 'NationSwell Widget for showing social links');

        $control_ops = array('id_base' => 'joinus-widget');

        $this->WP_Widget( 'joinus-widget', 'NationSwell Join Us Widget', $widget_ops, $control_ops );
    }

    function widget( $args, $instance) {
        extract( $args );

        //Our variables from the widget settings.
        $context = array();
        $context['title'] = apply_filters('widget_title', $instance['title'] );
        $context['description'] = $instance['description'];
        $context['facebook'] = $instance['facebook'];
        $context['twitter'] = $instance['twitter'];
        $context['youtube_url'] = $instance['youtube_url'];
        $context['youtube_copy'] = $instance['youtube_copy'];

        $template = array('widget-joinus.twig', 'empty.twig');

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
        $instance['facebook'] = strip_tags( $new_instance['facebook'] );
        $instance['twitter'] = strip_tags( $new_instance['twitter'] );
        $instance['youtube_url'] = strip_tags( $new_instance['youtube_url'] );
        $instance['youtube_copy'] = strip_tags( $new_instance['youtube_copy'] );

        return $instance;
    }

    function form( $instance ) {

        //Set up some default widget settings.
        $defaults = array(
            'title' => 'Join Us',
            'description' => 'Meet the people renewing America. Follow us on Facebook and Twitter for the latest updates on the American renewal.',
            'facebook' => 'https://www.facebook.com/nationswell',
            'twitter' => 'https://twitter.com/nationswell',
            'youtube_url' => 'https://www.youtube.com/user/nationswell?sub_confirmation=1&src_vid=MFjcKxx-h7Y&feature=iv&annotation_id=annotation_33899605',
            'youtube_copy' => 'Subscribe to Channel'
        );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e('Description:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" value="<?php echo $instance['description']; ?>" style="width:100%;" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e('Facebook:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo $instance['facebook']; ?>" style="width:100%;" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e('Twitter:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo $instance['twitter']; ?>" style="width:100%;" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'youtube_url' ); ?>"><?php _e('Youtube Url:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'youtube_url' ); ?>" name="<?php echo $this->get_field_name( 'youtube_url' ); ?>" value="<?php echo $instance['youtube_url']; ?>" style="width:100%;" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'youtube_copy' ); ?>"><?php _e('Youtube Copy:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'youtube_copy' ); ?>" name="<?php echo $this->get_field_name( 'youtube_copy' ); ?>" value="<?php echo $instance['youtube_copy']; ?>" style="width:100%;" />
        </p>

    <?php
    }

}

?>