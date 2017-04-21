<?php

add_action('widgets_init', 'partners_widget');

function partners_widget()
{
    register_widget( 'partners_Widget' );
}

class partners_Widget extends WP_Widget {

    function partners_Widget() {
        $widget_ops = array('classname' => 'widget_partners', 'description' => 'NationSwell Widget for adding partner messages to specific categories.');

        $control_ops = array('id_base' => 'partners-widget');

        $this->WP_Widget( 'partners-widget', 'NationSwell Partners Widget', $widget_ops, $control_ops );
    }

    function widget( $args, $instance) {
        extract( $args );

        //Our variables from the widget settings.
        $context = array();
        $context['logo_url'] = apply_filters('widget_logo_url', $instance['logo_url'] );
        $context['logo_alt'] = apply_filters('widget_logo_alt', $instance['logo_alt'] );
		$context['description'] = $instance['description'];

        $template = array('widget-partners.twig', 'empty.twig');

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

        //Strip tags from logo_url and name to remove HTML
        $instance['logo_url'] = strip_tags( $new_instance['logo_url'] );
		$instance['logo_alt'] = strip_tags( $new_instance['logo_alt'] );
        $instance['description'] = $new_instance['description'];
        
        return $instance;
    }

    function form( $instance ) {

        //Set up some default widget settings.
        $defaults = array(
            'logo_url' => __( 'http://', 'example' ),
            'description' => ''
        );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'logo_url' ); ?>"><?php _e('Logo URL:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'logo_url' ); ?>" name="<?php echo $this->get_field_name( 'logo_url' ); ?>" value="<?php echo $instance['logo_url']; ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'logo_alt' ); ?>"><?php _e('ALT text:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'logo_alt' ); ?>" name="<?php echo $this->get_field_name( 'logo_alt' ); ?>" value="<?php echo $instance['logo_alt']; ?>" style="width:100%;" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e('Description:', 'example'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" style="width:100%;" rows="5"><?php echo $instance['description']; ?></textarea>
        </p>
        

    <?php
    }

}

?>