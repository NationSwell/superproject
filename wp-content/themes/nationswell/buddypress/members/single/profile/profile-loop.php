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

<div class="profile-view">
	<div class=" left description">
		<h3><?php _e('About:','buddypress'); ?></h3>
		<?php echo get_user_meta($bp->displayed_user->id, 'description', true );?>
	</div>
	<div class="right">
		<div class="topics">
		<h3><?php _e('NationSwell Topics:','buddypress'); ?></h3>
		<?php 
		$topics = bp_get_profile_field_data(array('field'=>'Nationswell topics','user_id'=>$bp->displayed_user->id));
		if(!empty($topics)){
			echo('<ul>');
			foreach ($topics as $topic){
				echo('<li class="'.slugify($topic).'"><span class="label">'.$topic.'</span></li>');
			}
			echo('</ul>');
		}
		?>
		</div>
		<div class="interests">
		<h3><?php _e('Interested in:','buddypress'); ?></h3>
		<?php 
		$interests = bp_get_profile_field_data(array('field'=>'Interested in','user_id'=>$bp->displayed_user->id));
		if(!empty($interests)){
			echo('<ul>');
			foreach ($interests as $interest){
				echo('<li class="'.slugify($interest).'"><span class="label">'.$interest.'</span></li>');
			}
			echo('</ul>');
		}
		?>
		</div>
	</div>
</div>
<?php endif; ?>

<?php

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
do_action( 'bp_after_profile_loop_content' ); ?>
