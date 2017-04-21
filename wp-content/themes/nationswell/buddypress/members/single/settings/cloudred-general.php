<?php
/**
 * BuddyPress - Members Single Profile
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/settings/profile.php */
do_action( 'bp_before_member_settings_template' ); ?>

<h3><?php _e( 'Account settings', 'buddypress' ); ?></h3>


<form action="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/general'; ?>" method="post" class="standard-form" id="settings-form">

	<?php if ( !is_super_admin() ) : ?>
		<div class="form-row">
			<label for="pwd"><?php _e( 'Current password <span>(required to update email or change current password)</span>', 'buddypress' ); ?></label>
			<input type="password" name="pwd" id="pwd" size="16" value="" class="member-form-input settings-input small" <?php bp_form_field_attributes( 'password' ); ?>/> &nbsp;<a href="<?php echo wp_lostpassword_url(); ?>" title="<?php esc_attr_e( 'Password Lost and Found', 'buddypress' ); ?>"><?php _e( 'Lost your password?', 'buddypress' ); ?></a>
		</div>
	<?php endif; ?>

	<div class="form-row">
    	<label for="email"><?php _e( 'Email', 'buddypress' ); ?></label>
		<input type="email" name="email" id="email" value="<?php echo bp_get_displayed_user_email(); ?>" class="settings-input" <?php bp_form_field_attributes( 'email' ); ?>/>
    </div>
    
    <div class="divider"></div>

	<div class="form-row">
    	<label for="pass1"><?php _e( 'Change password <span>(leave blank for no change)</span>', 'buddypress' ); ?></label>
		<input type="password" name="pass1" id="pass1" size="16" value="" class="settings-input small password-entry" <?php bp_form_field_attributes( 'password' ); ?> placeholder="<?php _e( 'New password', 'buddypress' ); ?>"/><br>
   		<div id="pass-strength-result"></div>
    </div>
    
    <div class="form-row">
		<label for="pass2" class="bp-screen-reader-text"><?php _e( 'Repeat New Password', 'buddypress' ); ?></label>
		<input type="password" name="pass2" id="pass2" size="16" value="" class="settings-input small password-entry-confirm" <?php bp_form_field_attributes( 'password' ); ?> placeholder="<?php _e( 'Repeat new password', 'buddypress' ); ?>"/>
	</div>
    
     <div class="divider"></div>
    
	
	<?php

	/**
	 * Fires before the display of the submit button for user general settings saving.
	 *
	 * @since 1.5.0
	 */
	do_action( 'bp_core_general_settings_before_submit' ); ?>

	<div class="submit form-row">
		<input type="submit" name="submit" value="<?php esc_attr_e( 'Save Changes', 'buddypress' ); ?>" id="submit" class="auto" />
	</div>

	<?php

	/**
	 * Fires after the display of the submit button for user general settings saving.
	 *
	 * @since 1.5.0
	 */
	do_action( 'bp_core_general_settings_after_submit' ); ?>

	<?php wp_nonce_field( 'bp_settings_general' ); ?>

</form>

<?php

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/settings/profile.php */
do_action( 'bp_after_member_settings_template' ); ?>
