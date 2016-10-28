<?php

class Voting_Widget extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Voting_Widget', // Base ID
			__( 'NationSwell Allstars Voting Widget', 'buddypress' ), // Name
			array( 'description' => __( 'Widget allows you to select a gravity form to be displayed in sidebar of certain posts. Use this widget to enable vosting for this year’s AllStars.', 'buddypress' ), ) // Args
		);
	}
	
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		echo $args['before_widget'];
		if ( $instance['gravity_form_id'] > 0 ):
			//check if the user is logged in
			if ( is_user_logged_in() ):
				$current_user = wp_get_current_user();
				//check if the user has already voted
				$search_criteria['field_filters'][] = array( 'key' => 'created_by', 'value' => $current_user->ID );
				$form_id = $instance['gravity_form_id'];
				$entries = GFAPI::get_entries( $form_id, $search_criteria );
				//if the user has already voted, tell them so
				if ( count($entries)>0 ):
					echo '<div class="gf_browser_chrome gform_wrapper module module--bg_wrapper">';
					echo '<div class="gform_body form-unavailable">';
					echo '<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=1174971189235255";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';
					echo '<p>';
					echo '<strong>';
					echo __('You have already voted.','buddypress');
					echo '</strong>';
					echo '<br>';
					echo __('Thank you for your vote!<br>Spread the word:','buddypress');
					echo '</p>';
					echo '<div><a href="https://twitter.com/share" class="twitter-share-button" data-size="large" data-text="Vote for your favorite  #NationSwellAllStars!" data-url="'.get_permalink().'" data-via="NationSwell" data-lang="en" data-show-count="false">'.__('Tweet','buddypress').'</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script></div>';
					
					echo '<div class="fb-share-button" data-href="'.get_permalink().'" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u='.urlencode(get_permalink()).'%2F&amp;src=sdkpreparse">'.__('Share','buddypress').'</a></div>';
					
					echo '<p class="ps">';
					echo 'You’re logged in as '.$current_user->user_email.'.<br>Not '.$current_user->user_firstname.'? <a href="'.wp_logout_url( get_permalink() ).'">Log out &#8594;</a>';
					echo '</p>';
					
					echo '</div></div>';
				else:
					//otherwise, show the form;
					echo do_shortcode('[gravityform id="'.$instance['gravity_form_id'].'" title="false" description="false" ajax="true"]');
				endif;
			else:
				echo do_shortcode('[gravityform id="'.$instance['gravity_form_id'].'" title="false" description="false" ajax="true"]');
			endif;
		endif;
		echo $args['after_widget'];
	}
				
	
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		//show available gravity forms
		//print_r( $instance );
		$gravity_form_id = 0;
		if (isset($instance['gravity_form_id'])) {
			$gravity_form_id=$instance['gravity_form_id'];
		}
		$select = '<select class="widefat" id="'.$this->get_field_id('gravity_form_id').'" name="'.$this->get_field_name('gravity_form_id').'">';
		$forms = RGFormsModel::get_forms( null, 'title' );
		$selected = '';
		if ($gravity_form_id == 0):
			$select .= '<option value="0">' . __( esc_attr( 'Select form...' ) ) . '</option>';
		endif;
		foreach( $forms as $form ):
			if ($gravity_form_id == $form->id):
				$selected = " selected";
			else:
				$selected = '';
			endif;
		  	$select .= '<option value="' . $form->id . '"'.$selected.'>' . $form->title . '</option>';
		endforeach;
		$select .= '</select>';
		
		echo '<p>';
		echo '<label for="'.$this->get_field_id('gravity_form_id').'">'. __( esc_attr( 'Gravity form:' ) ) .'</label>';
		echo $select;
		echo '</p>'; 
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['gravity_form_id'] = ( ! empty( $new_instance['gravity_form_id'] ) ) ? strip_tags( $new_instance['gravity_form_id'] ) : '0';

		return $instance;
	}

} // class Foo_Widget

// register Foo_Widget widget
function register_voting_widget() {
    register_widget( 'Voting_Widget' );
}
add_action( 'widgets_init', 'register_voting_widget' );


	
	
/*	
	
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

add_action('widgets_init', 'voting_widget');

function Voting_Widget()
{
    register_widget( 'Voting_Widget' );
}


?>*/
