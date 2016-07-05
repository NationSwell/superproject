<?php
/**
 * BuddyPress - Members Single Profile Edit
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires after the display of member profile edit content.
 *
 * @since 1.1.0
 */
do_action( 'bp_before_profile_edit_content' );
global $bp;
?>
<div class="profile-edit-forms">
	<?php
	$groups = bp_profile_get_field_groups();
	foreach($groups AS $group){
		if ( bp_has_profile( 'profile_group_id=' . $group->id ) ) :
			while ( bp_profile_groups() ) : bp_the_profile_group(); ?>
				<div class="profile-edit-form">
				<form action="<?php bp_the_profile_group_edit_form_action(); ?>" method="post" id="profile-edit-form-<?php echo $group->id; ?>" class="<?php bp_the_profile_group_slug(); ?>">

					<?php

					/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
					do_action( 'bp_before_profile_field_content' ); ?>

					<h3><?php printf( __( "%s:", 'buddypress' ), bp_get_the_profile_group_name() ); ?><?php if (strtolower(bp_get_the_profile_group_name()) == 'private info'): ?>
					<br><span><?php _e('Note: this info will not appear in your profile.','buddypress'); ?></span>
					
					<?php endif; ?></h3>
					
					
					<?php if ( bp_profile_has_multiple_groups() ) : ?>
						<ul class="button-nav">

							<?php //bp_profile_group_tabs(); ?>

						</ul>
					<?php endif ;?>

					<div class="clear"></div>

					<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

						<div<?php bp_field_css_class( 'editfield' ); ?>>

							<?php
							$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
							switch( bp_get_the_profile_field_name() ){
								case 'Date joined':
								case 'Member status':
									if (!empty(bp_get_the_profile_field_value())):
										echo("<div class='editfield' style='margin-bottom:20px'>");
										echo "<label>".bp_get_the_profile_field_name()."</label>";
										echo bp_get_the_profile_field_value();
										echo("</div>");
										
									endif;
								break;
								default:
									$field_type->edit_field_html();
								break;
							}


							/**
					 		* Fires before the display of visibility options for the field.
					 		*
					 		* @since 1.7.0
					 		*/
							do_action( 'bp_custom_profile_edit_fields_pre_visibility' );
							?>

							<!--
							<?php if ( bp_current_user_can( 'bp_xprofile_change_field_visibility' ) ) : ?>
								<p class="field-visibility-settings-toggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
									<?php
									printf(
										__( 'This field can be seen by: %s', 'buddypress' ),
										'<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
									);
									?>
									<a href="#" class="visibility-toggle-link"><?php _e( 'Change', 'buddypress' ); ?></a>
								</p>
								
								<div class="field-visibility-settings" id="field-visibility-settings-<?php bp_the_profile_field_id() ?>">
									<fieldset>
										<legend><?php _e( 'Who can see this field?', 'buddypress' ) ?></legend>

										<?php bp_profile_visibility_radio_buttons() ?>

									</fieldset>
									<a class="field-visibility-settings-close" href="#"><?php _e( 'Close', 'buddypress' ) ?></a>
								</div>
							<?php else : ?>
								<div class="field-visibility-settings-notoggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
									<?php
									printf(
										__( 'This field can be seen by: %s', 'buddypress' ),
										'<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
									);
									?>
								</div>
							<?php endif ?>
							-->
							<?php

							/**
					 		* Fires after the visibility options for a field.
					 		*
					 		* @since 1.1.0
					 		*/
							do_action( 'bp_custom_profile_edit_fields' ); ?>

							<p class="description"><?php bp_the_profile_field_description(); ?></p>
						</div>

					<?php endwhile; ?>

				<?php

				/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
				do_action( 'bp_after_profile_field_content' ); ?>

				<div class="submit">
					<input type="submit" name="profile-group-edit-submit" id="profile-group-edit-submit" value="<?php esc_attr_e( 'Save Changes', 'buddypress' ); ?> " />
				</div>

				<input type="hidden" name="field_ids" id="field_ids" value="<?php bp_the_profile_field_ids(); ?>" />

				<?php wp_nonce_field( 'bp_xprofile_edit' ); ?>
			
			</form>
			</div>
			<?php endwhile; endif; ?>
		<?php } ?>
</div>
<?php

/**
 * Fires after the display of member profile edit content.
 *
 * @since 1.1.0
 */
do_action( 'bp_after_profile_edit_content' ); ?>
<div id="popup-bio-info" class="popup bio" style="display:none;">
	<h3><?php _e('NSC Bio Best Practices','buddypress'); ?></h3>
    <ul class="popup__list">
    	<li><?php _e('Less is more (4 – 6 sentences)','buddypress'); ?></li>
        <li><?php _e('A healthy mix of professional and personal!','buddypress'); ?></li>
    </ul>
    <span><?php _e('Bios are subject to editing.','buddypress'); ?></span>
</div>

<script>
jQuery( document ).ready(function() {
	// Hack to counteract removing of content on focus
	jQuery( "#description" ).focus(function() {
		jQuery( "#description" ).val(<?php echo "'". get_user_meta($bp->displayed_user->id, 'description', true )."'";?>);
		jQuery( "#description" ).off('focus');
	});
	// Show/hide popup
	jQuery( ".my-account .profile-edit-form-bio .icon_information" ).hover(function() {
		jQuery( '#popup-bio-info' ).show();
	}, function() {
		jQuery( '#popup-bio-info' ).hide();
	  }
	);
	// Use chosen.js for multi select inputs
	jQuery(".field_type_multiselectbox select").chosen({
    	placeholder_text_multiple: "<?php _e('Select some options','buddypress'); ?>"
    });
	
	jQuery(function($){
   		$(".field_phone input").mask("(999) 999-9999");
   		$(".field_zip input").mask("99999");
	});
	
});
</script>