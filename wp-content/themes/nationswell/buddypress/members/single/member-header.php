<?php
/**
 * BuddyPress - Users Header
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php
global $bp;

/**
 * Fires before the display of a member's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_member_header' ); ?>

<div id="item-header-avatar">
	<a href="<?php bp_displayed_user_link(); ?>">

		<?php bp_displayed_user_avatar( 'type=full' ); ?>

	</a>
</div><!-- #item-header-avatar -->

<div id="item-header-content">
	<div id="item-meta-bio">
		<h2 class="user-nicename"><?php echo get_user_meta( $bp->displayed_user->id, 'first_name', true )." ".get_user_meta( $bp->displayed_user->id, 'last_name', true );?></h2>
		<h3 class="user-company">Title, Company</h3>
		<div class="item-block-content">
			<div class="item-subblock">
				<a href="<?php echo("#"); ?>"><span class="item-block-button-linkedin"><?php _e("Linkedin");?></span></a>
			</div>
			<div class="item-subblock">
				<ul>
					<li><a href="<?php echo($bp->bp_options_nav['profile']['public']['link']); ?>">View Profile</a></li>
					<li><a href="<?php echo($bp->bp_options_nav['profile']['edit']['link']); ?>">Edit Profile</a></li>
					<li><a href="<?php echo($bp->bp_options_nav['profile']['change-avatar']['link']); ?>">Change Photo</a></li>
				<ul>
			</div>
		</div>
	</div><!-- #item-meta-bio -->

	<div id="item-meta-member-directory" class="item-block">
		<h2><?php _e("Member Directory");?></h2>
		<div class="item-block-content"><?php _e("Connect with other members!");?></div>
		<a href="<?php echo($bp->root_domain."/".$bp->members->root_slug); ?>"><span class="item-block-button-go"><?php _e("Go!");?></span></a>
	</div><!-- #item-meta-member-directory -->

	<div id="item-meta-get-in-touch" class="item-block">
		<h2><?php _e("Get in touch!");?></h2>
		<div class="item-block-content"><?php _e("Refer a member, recommend a speaker, or tell us about your experience.");?></div>
		<a href="<?php echo($bp->root_domain."/contact"); ?>"><span class="item-block-button-go"><?php _e("Go!");?></span></a>
	</div><!-- #item-meta-get-in-touch -->

</div><!-- #item-header-content -->

<?php

/**
 * Fires after the display of a member's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_member_header' ); ?>

<?php

/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
do_action( 'template_notices' ); ?>
