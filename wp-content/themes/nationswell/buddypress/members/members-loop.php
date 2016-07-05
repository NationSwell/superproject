<?php
/**
 * BuddyPress - Members Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires before the display of the members loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_members_loop' ); ?>

<?php

// to include only defined roles in the Buddypress Members LOOP
function include_only_members() {
	$member_array = array();
	$members = get_users(array('role' => 'member', 'fields' => array('ID')));
	foreach ( $members as $user ) {
		array_push($member_array,esc_html( $user->ID));
	}
	$members = implode(",",$member_array);
    return $members;
}

// Custom search filters, retrieve ids and include them in master search query per documentation
if(!empty( $_REQUEST )  && !empty( $_REQUEST['members_search_submit'] )){
	$user_ids = include_only_members();

	$whereSql=" user_id in (".$user_ids.")";

	if(!empty($_REQUEST['council_branch'])){
		$whereSql2[]="lower(value)='".esc_sql($_REQUEST['council_branch'])."'";
	}

	if(!empty($_REQUEST['industry'])){
		$whereSql2[]="lower(value) ='".esc_sql($_REQUEST['industry'])."'";
	}

	if(!empty($_REQUEST['nationswell_topics'])){
		$whereSql2[]="lower(value) like '%".esc_sql($_REQUEST['nationswell_topics'])."%'";
	}

	if(!empty($_REQUEST['interested_in'])){
		$whereSql2[].="lower(value)='%".esc_sql($_REQUEST['interested_in'])."%'";
	}

	if(!empty($whereSql2)){
		$whereSql.= ' and '.implode(" or ",$whereSql2);
	}
	global $wpdb;
	$useridHash = $wpdb->get_col( "SELECT user_id FROM ".$wpdb->prefix."bp_xprofile_data where ".$whereSql);
	if(!empty($useridHash)){
		$user_ids = implode(",",$useridHash);
	}else{
		$user_ids = 0;
	}
}else{
	$user_ids = include_only_members();
}
?>

<?php if ( bp_get_current_member_type() ) : ?>
	<p class="current-member-type"><?php bp_current_member_type_message() ?></p>
<?php endif; ?>

<?php
if ( bp_has_members( bp_ajax_querystring( 'members' ) . '&type=alphabetical&include=' . $user_ids ) ) : ?>

	<div id="pag-top" class="pagination">

		<div class="pag-count" id="member-dir-count-top">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-top">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

	<?php

	/**
	 * Fires before the display of the members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_members_list' ); ?>

	<ul id="members-list" class="item-list">

	<?php while ( bp_members() ) : bp_the_member(); ?>
		<li <?php bp_member_class(); ?>>
			<div class="item-avatar">
				<a href="<?php echo(bp_get_member_permalink()); ?>"><?php bp_member_avatar(); ?></a>
			</div>

			<div class="item">
				<div class="item-title">
					<a href="<?php echo(bp_get_member_permalink());?>"><?php bp_member_name(); ?></a>

					<!--<?php if ( bp_get_member_latest_update() ) : ?>

						<span class="update"> <?php bp_member_latest_update(); ?></span>

					<?php endif; ?>-->

				</div>

				<!--<div class="item-meta"><span class="activity"><?php bp_member_last_active(); ?></span></div>-->

				<?php

				/**
				 * Fires inside the display of a directory member item.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_directory_members_item' ); ?>

				<?php
				 /***
				  * If you want to show specific profile fields here you can,
				  * but it'll add an extra query for each member in the loop
				  * (only one regardless of the number of fields you show):
				  *
				  * bp_member_profile_data( 'field=the field name' );
				  */
				?>
			</div>

			<div class="action">

				<?php

				/**
				 * Fires inside the members action HTML markup to display actions.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_directory_members_actions' ); ?>

			</div>

			<div class="clear"></div>
		</li>
	<?php endwhile; ?>

	</ul>

	<?php

	/**
	 * Fires after the display of the members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_directory_members_list' ); ?>

	<?php bp_member_hidden_fields(); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-dir-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info" style="text-align:center;">
		<span class="icon icon_frown" style="font-size:100px;"></span>
		<p><?php _e( "Sorry, no members were found.", 'buddypress' ); ?></p>
		<a href="<?php echo $bp->root_domain . '/' . BP_MEMBERS_SLUG . '/' ?>" class="reset-search button">Reset search form</a>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of the members loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_members_loop' ); ?>
