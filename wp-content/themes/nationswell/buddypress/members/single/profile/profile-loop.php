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
	<div class="left description">
		<h3><?php _e('About:','buddypress'); ?></h3>
		<?php echo get_user_meta($bp->displayed_user->id, 'description', true );?>
	</div>
	<div class="right">

		<?php 
		$topics = bp_get_profile_field_data(array('field'=>'Interest areas','user_id'=>$bp->displayed_user->id)); ?>
		<?php if(!empty($topics)): ?>
		<div class="topics">
			<h3><?php _e('Interest areas:','buddypress'); ?></h3>
		
			<?php if(!empty($topics)){
				echo('<ul>');
				foreach ($topics as $topic){
					echo('<li class="'.slugify($topic).'"><span class="label">'.$topic.'</span></li>');
				}
				echo('</ul>');
			}
			?>
		</div>
		<?php endif; ?>
		<?php 
		$interests = bp_get_profile_field_data(array('field'=>'Interested in connecting about','user_id'=>$bp->displayed_user->id)); ?>
		<?php if(!empty($interests)): ?>
		<div class="interests">
			<h3><?php _e('Interested in connecting about:','buddypress'); ?></h3>
		
			<?php if(!empty($interests)){
				echo('<ul>');
				foreach ($interests as $interest){
					echo('<li class="'.slugify($interest).'"><span class="label">'.$interest.'</span></li>');
				}
				echo('</ul>');
			}
			?>
		</div>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>

<?php

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
do_action( 'bp_after_profile_loop_content' ); ?>
