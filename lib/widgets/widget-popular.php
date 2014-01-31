<?php

add_action('widgets_init', 'popular_widget');

function popular_widget()
{
    register_widget( 'Popular_Widget' );
}

class Popular_Widget extends WP_Widget {

    function Popular_Widget() {
        $widget_ops = array('classname' => 'story', 'description' => 'NationSwell Widget for Popular Stories');

        $control_ops = array('id_base' => 'popular-widget');

        $this->WP_Widget( 'popular-widget', 'NationSwell Popular Widget', $widget_ops, $control_ops );
    }


    function widget( $args, $instance) {
        extract( $args );

        //Our variables from the widget settings.
        $context = array();
        $context['header'] = $instance['header'];
        $context['popular_posts'] = Timber::get_posts(get_field('popular_posts', 'option'), 'NationSwellPost');

        $template = array('widget-popular.twig', 'empty.twig');

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
        $instance['header'] = strip_tags( $new_instance['header'] );

        return $instance;
    }

    function form( $instance ) {

        //Set up some default widget settings.
        $defaults = array( 'header' => '');
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'header' ); ?>"><?php _e('Header:', 'HEADER'); ?></label>
            <input id="<?php echo $this->get_field_id( 'header' ); ?>" name="<?php echo $this->get_field_name( 'header' ); ?>" value="<?php echo $instance['header']; ?>" style="width:100%;" />
        </p>

    <?php
    }

}

?>