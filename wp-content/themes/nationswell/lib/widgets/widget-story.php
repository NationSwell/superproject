<?php

add_action('widgets_init', 'story_widget');

function story_widget()
{
    register_widget( 'Story_Widget' );
}

class Story_Widget extends WP_Widget {

    function Story_Widget() {
        $widget_ops = array('classname' => 'story', 'description' => 'NationSwell Widget for highlighting a featured story');

        $control_ops = array('id_base' => 'story-widget');

        $this->WP_Widget( 'story-widget', 'NationSwell Story Widget', $widget_ops, $control_ops );
    }


    function widget( $args, $instance) {
        extract( $args );

        //Our variables from the widget settings.
        $context = array();
        $post_id = intval($instance['post_id']);
        $context['post'] = Timber::get_post(array($post_id));

        $template = array('widget-story.twig', 'empty.twig');

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
        $instance['post_id'] = strip_tags( $new_instance['post_id'] );

        return $instance;
    }

    function form( $instance ) {

        //Set up some default widget settings.
        $defaults = array( 'post_id' => '');
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'post_id' ); ?>"><?php _e('Post ID:', 'ID'); ?></label>
            <input id="<?php echo $this->get_field_id( 'post_id' ); ?>" name="<?php echo $this->get_field_name( 'post_id' ); ?>" value="<?php echo $instance['post_id']; ?>" style="width:100%;" />
        </p>

    <?php
    }

}

?>