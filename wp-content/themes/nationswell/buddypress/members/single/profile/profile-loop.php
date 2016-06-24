<?php
/**
 * BuddyPress - Members Profile Loop
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

global $bp;
/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
do_action( 'bp_before_profile_loop_content' ); ?>

<?php if ( bp_has_profile() ) : ?>

<div class=" left description">
<?php echo get_user_meta($bp->displayed_user->id, 'description', true );?>
</div>
<div class="right" >
	<div class="topics">
		<?php 
		$topics = bp_get_profile_field_data(array('field'=>'Nationswell topics','user_id'=>$bp->displayed_user->id));
		if(!empty($topics)){
			echo('<ul>');
			foreach ($topics as $topic){
				echo('<li class="'.$topic.'">'.$topic.'</li>');
			}
			echo('</ul>');
		}
		?>
	</div>
	<div class="interests">
		<?php 
		$interests = bp_get_profile_field_data(array('field'=>'Interested in','user_id'=>$bp->displayed_user->id));
		if(!empty($interests)){
			echo('<ul>');
			foreach ($interests as $interest){
				echo('<li class="'.$interest.'">'.$interest.'</li>');
			}
			echo('</ul>');
		}
		?>
	</div>
</div>

<?php endif; ?>

<?php

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
do_action( 'bp_after_profile_loop_content' ); ?>
