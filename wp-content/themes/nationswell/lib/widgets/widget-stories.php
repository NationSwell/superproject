<?php

add_action('widgets_init', 'stories_widget');

function stories_widget()
{
    register_widget('Stories_Widget');
}

class Stories_Widget extends WP_Widget
{

    function Stories_Widget()
    {
        $widget_ops = array('classname' => 'stories', 'description' => 'NationSwell Widget for displaying a list of stories');

        $control_ops = array('id_base' => 'stories-widget');

        $this->WP_Widget('stories-widget', 'NationSwell Stories List Widget', $widget_ops, $control_ops);
    }


    function widget($args, $instance)
    {
        extract($args);

        $context = array();

        if (!empty($instance['post_id'])) {

            //Our variables from the widget settings.
            $post_id = intval($instance['post_id']);

            $post = Timber::get_post(array($post_id));
            $context['header'] = $post->post_title;

            $posts = get_field('story_list', $post->ID);
            $context['posts'] = Timber::get_posts($posts, 'NationSwellPost');

        }

        $template = array('widget-stories.twig', 'empty.twig');

        echo $before_widget;

        // do not echo:
        ob_start();
        $output = Timber::render($template, $context);
        ob_end_clean();

        echo $output;

        echo $after_widget;
    }

    //Update the widget
    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        //Strip tags from title and name to remove HTML
        $instance['post_id'] = strip_tags($new_instance['post_id']);

        return $instance;
    }

    function form($instance)
    {

        //Set up some default widget settings.
        $defaults = array('post_id' => '');
        $instance = wp_parse_args((array)$instance, $defaults); ?>

        <p>
            <label for="<?php echo $this->get_field_id('post_id'); ?>"><?php _e('Post ID:', 'ID'); ?></label>
            <input id="<?php echo $this->get_field_id('post_id'); ?>"
                   name="<?php echo $this->get_field_name('post_id'); ?>" value="<?php echo $instance['post_id']; ?>"
                   style="width:100%;"/>
        </p>

    <?php
    }

}

?>