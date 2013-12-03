<?php

add_action('widgets_init', 'contact_widget');

function contact_widget()
{
    register_widget( 'Contact_Widget' );
}

class Contact_Widget extends WP_Widget {

    function Contact_Widget() {
        $widget_ops = array('classname' => 'example', 'description' => 'NationSwell Widget for showing social links');

        $control_ops = array('id_base' => 'contact-widget');

        $this->WP_Widget( 'contact-widget', 'NationSwell Contact Widget', $widget_ops, $control_ops );
    }

    function widget( $args, $instance) {
        extract( $args );

        //Our variables from the widget settings.
        $context = array();
        $context['title'] = apply_filters('widget_title', $instance['title'] );
        $context['description'] = $instance['description'];
        $context['button_link'] = $instance['button_link'];
        $context['button_text'] = $instance['button_text'];

        $template = array('widget-contact.twig', 'empty.twig');

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
        $instance['button_link'] = strip_tags( $new_instance['button_link'] );
        $instance['button_text'] = strip_tags( $new_instance['button_text'] );

        return $instance;
    }

    function form( $instance ) {

        //Set up some default widget settings.
        $defaults = array( 'title' => 'Contact', 'description' => 'Let us know what you think of our site, or share your story with our editorial tream.', 'button_link' => '/contact', 'button_text' => 'Contact Us');
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
            <label for="<?php echo $this->get_field_id( 'button_link' ); ?>"><?php _e('Button Link:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'button_link' ); ?>" name="<?php echo $this->get_field_name( 'button_link' ); ?>" value="<?php echo $instance['button_link']; ?>" style="width:100%;" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e('Button Text:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" value="<?php echo $instance['button_text']; ?>" style="width:100%;" />
        </p>



    <?php
    }

}

?>