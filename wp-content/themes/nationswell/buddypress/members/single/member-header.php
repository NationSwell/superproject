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

<div class="member-row">
     <div class="left-wrapper">
        <div class="member-info-card">
            <div id="item-header-avatar" class="member-header-avatar">
                <a href="<?php bp_displayed_user_link(); ?>">
    
                    <?php bp_displayed_user_avatar( 'type=full' ); ?>
    
                </a>
            </div><!-- #item-header-avatar -->
            <div id="item-meta-bio" class="member-meta-bio">
                <h2 class="user-nicename"><?php echo get_user_meta( $bp->displayed_user->id, 'first_name', true )." ".get_user_meta( $bp->displayed_user->id, 'last_name', true );?></h2>
                <p class="user-company">Title, Company</p>
                <div class="item-block-content">
                    <div class="item-subblock">
                        <a href="<?php echo("#"); ?>" title="<?php _e("LinkedIn","buddypress");?>"><span class="item-block-button-linkedin icon icon_linkedin"></span></a>
                        <a href="<?php echo("#"); ?>" title="<?php _e("Email","buddypress");?>"><span class="item-block-button-email icon icon_envelope-empty"></span></a>
                    </div>
                    <div class="item-subblock">
                        <ul>
                            <li><a href="<?php echo($bp->bp_options_nav['profile']['public']['link']); ?>"><?php _e("View profile","buddypress");?></a></li>
                            <?php if($bp->loggedin_user->id == $bp->displayed_user->id ){?> <li><a href="<?php echo($bp->bp_options_nav['profile']['edit']['link']); ?>"><?php _e("Edit profile","buddypress");?></a></li><?php }?>
                            <?php if($bp->loggedin_user->id == $bp->displayed_user->id ){?><li><a href="<?php echo($bp->bp_options_nav['profile']['change-avatar']['link']); ?>"><?php _e("Change photo","buddypress");?></a></li><?php }?>
                        <ul>
                    </div>
                </div>
            </div><!-- #item-meta-bio -->
        </div>
        
         <?php
		  if( $bp->current_action =='general' || $bp->current_action =='notifications' ) {
			echo '<div class="member-notifications">';
			require( 'settings/cloudred-notifications.php' );
			echo '</div>';
		  }
		  ?>
        
    </div>
    <?php 
		//if we're on the change pic page, show the form
		
		//if(!empty(strpos($_SERVER['REQUEST_URI'], 'avatar'))){
		if ( $bp->current_action =='change-avatar' ) {
			echo '<div class="member-change-avatar">';
			require( 'profile/cloudred-change-avatar.php' );
			echo '</div>';
		//if we're on the settings page, show the settings form
		} else if( $bp->current_action =='general' || $bp->current_action =='notifications' ) {
			echo '<div class="member-settings">';
			require( 'settings/cloudred-general.php' );
			//require( 'settings/cloudred-notifications.php' );
			echo '</div>';
		//in all other cases, show the two callouts
		} else {

		?>
	
	<div id="item-meta-member-directory" class="callout-block">
		<h3><span class="icon icon_people"></span><?php _e("Member Directory");?></h3>
		<div class="item-block-content"><?php _e("Connect with other members!");?></div>
		<a href="<?php echo($bp->root_domain."/".$bp->members->root_slug); ?>"><span class="item-block-button-go"><?php _e("Go!");?></span></a>
	</div><!-- #item-meta-member-directory -->

	<div id="item-meta-get-in-touch" class="callout-block">
		<h3><span class="icon icon_comments"></span><?php _e("Get in touch!");?></h3>
		<div class="item-block-content"><?php _e("Refer a member, recommend a speaker, or tell us about your experience.");?></div>
		<a href="<?php echo($bp->root_domain."/contact"); ?>"><span class="item-block-button-go"><?php _e("Go!");?></span></a>
	</div><!-- #item-meta-get-in-touch -->
    
    	<?php } ?>

</div>



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
