<?php
/**
 * BuddyPress - Users Notifications
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<div class="item-list-tabs no-ajax notifications-menu" id="subnav" role="navigation">
	<h2><?php esc_attr_e( 'Your notifications', 'buddypress' ); ?></h2>
    <p>&nbsp;</p>
    <ul>
		<li class="filters-title"><?php esc_attr_e( 'Filter your notifications by:', 'buddypress' ); ?></li>
		<?php bp_get_options_nav(); ?>
		
		<li id="members-order-select" class="last filter">
			<?php bp_notifications_sort_order_form(); ?>
		</li>
	</ul>
</div>

<?php
switch ( bp_current_action() ) :

	case 'unread' :
		bp_get_template_part( 'members/single/notifications/unread' );
		break;

	case 'read' :
		bp_get_template_part( 'members/single/notifications/read' );
		break;

	// Any other actions.
	default :
		bp_get_template_part( 'members/single/plugins' );
		break;
endswitch;
