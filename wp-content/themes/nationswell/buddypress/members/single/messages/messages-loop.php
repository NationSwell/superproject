<?php
/**
 * BuddyPress - Members Messages Loop
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires before the members messages loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_member_messages_loop' ); ?>
<div class="loop">
	<?php if ( bp_has_message_threads( bp_ajax_querystring( 'messages' ) ) ) : ?>
	
		<div class="pagination no-ajax top" id="user-pag">
	
			<div class="pag-count" id="messages-dir-count">
				<?php bp_messages_pagination_count(); ?>
			</div>
	
			<div class="pagination-links" id="messages-dir-pag">
				<?php bp_messages_pagination(); ?>
			</div>
	
		</div><!-- .pagination -->
	
		<?php
	
		/**
		 * Fires after the members messages pagination display.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_member_messages_pagination' ); ?>
	
		<?php
	
		/**
		 * Fires before the members messages threads.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_before_member_messages_threads' ); ?>
	
		<form action="<?php echo bp_loggedin_user_domain() . bp_get_messages_slug() . '/' . bp_current_action() ?>/bulk-manage/" method="post" id="messages-bulk-management">
	
			<table id="message-threads" class="messages-notices">
	
				<thead>
					<tr>
						<th scope="col" class="thread-checkbox bulk-select-all"><input id="select-all-messages" type="checkbox"><label class="bp-screen-reader-text" for="select-all-messages"><?php _e( 'Select all', 'buddypress' ); ?></label></th>
						<th scope="col" class="thread-from"><?php _e( 'From', 'buddypress' ); ?></th>
						<th scope="col" class="thread-info"><?php _e( 'Subject', 'buddypress' ); ?></th>
	
						<?php
	
						/**
						 * Fires inside the messages box table header to add a new column.
						 *
						 * This is to primarily add a <th> cell to the messages box table header. Use
						 * the related 'bp_messages_inbox_list_item' hook to add a <td> cell.
						 *
						 * @since 2.3.0
						 */
						do_action( 'bp_messages_inbox_list_header' ); ?>
	
						
	
						<th scope="col" class="thread-options" style="text-align:center"><?php _e( 'Actions', 'buddypress' ); ?></th>
					</tr>
                    <tr>
                    	<td colspan="4" class="messages-divider">
                        	<div class="divider"></div>
                        </td>
                    </tr>
				</thead>
	
				<tbody>
	
					<?php while ( bp_message_threads() ) : bp_message_thread(); ?>
	
						<tr id="m-<?php bp_message_thread_id(); ?>" class="<?php bp_message_css_class(); ?><?php if ( bp_message_thread_has_unread() ) : ?> unread<?php else: ?> read<?php endif; ?>">
							<td class="bulk-select-check">
								<label for="bp-message-thread-<?php bp_message_thread_id(); ?>"><input type="checkbox" name="message_ids[]" id="bp-message-thread-<?php bp_message_thread_id(); ?>" class="message-check" value="<?php bp_message_thread_id(); ?>" /><span class="bp-screen-reader-text"><?php _e( 'Select this message', 'buddypress' ); ?></span></label>
							</td>
	
							<?php if ( 'sentbox' != bp_current_action() ) : ?>
								<td class="thread-from">
									<?php bp_message_thread_avatar( array( 'width' => 25, 'height' => 25 ) ); ?>
									<span class="from"><?php _e( 'From:', 'buddypress' ); ?></span> <?php bp_message_thread_from(); ?>
									<?php bp_message_thread_total_and_unread_count(); ?>
									<span class="activity"><?php bp_message_thread_last_post_date(); ?></span>
								</td>
							<?php else: ?>
								<td class="thread-from">
									<?php bp_message_thread_avatar( array( 'width' => 25, 'height' => 25 ) ); ?>
									<span class="to"><?php _e( 'To:', 'buddypress' ); ?></span> <?php bp_message_thread_to(); ?>
									<?php bp_message_thread_total_and_unread_count(); ?>
									<span class="activity"><?php bp_message_thread_last_post_date(); ?></span>
								</td>
							<?php endif; ?>
	
							<td class="thread-info">
								<p class="subject"><a href="<?php bp_message_thread_view_link(); ?>" title="<?php esc_attr_e( "View Message", 'buddypress' ); ?>"><?php bp_message_thread_subject(); ?></a></p>
								<p class="thread-excerpt"><?php bp_message_thread_excerpt(); ?></p>
							</td>
	
							<?php
	
							/**
							 * Fires inside the messages box table row to add a new column.
							 *
							 * This is to primarily add a <td> cell to the message box table. Use the
							 * related 'bp_messages_inbox_list_header' hook to add a <th> header cell.
							 *
							 * @since 1.1.0
							 */
							do_action( 'bp_messages_inbox_list_item' ); ?>
	
							<td class="thread-options">
								
                                <!-- Delete -->
								<a class="delete" href="<?php bp_message_thread_delete_link(); ?>" title="<?php _e( 'Delete', 'buddypress' ); ?>"><span class="icon icon_trash"></span></a>
								<!-- //end -->
								
                                <!-- see/unsee -->
								<?php if ( bp_message_thread_has_unread() ) : ?>
									<a class="read" href="<?php bp_the_message_thread_mark_read_url();?>" title="<?php _e( 'Read', 'buddypress' ); ?>"><span class="icon icon_read"></span></a>
								<?php else : ?>
									<a class="unread" href="<?php bp_the_message_thread_mark_unread_url();?>" title="<?php _e( 'Unread', 'buddypress' ); ?>"><span class="icon icon_unread"></span></a>
								<?php endif; ?>
                                <!-- //end -->
                                
                                <!-- star -->
								<?php if ( bp_is_active( 'messages', 'star' ) ) : ?>
									<?php bp_the_message_star_action_link( array( 'thread_id' => bp_get_message_thread_id() ) ); ?>
								<?php endif; ?>
                                <!-- //end -->
                                
                                <?php
	
								/**
								 * Fires after the thread options links for each message in the messages loop list.
								 *
								 * @since 2.5.0
								 */
								do_action( 'bp_messages_thread_options' ); ?>
							</td>
						</tr>
	
					<?php endwhile; ?>
	
				</tbody>
	
			</table><!-- #message-threads -->
			
            <?php if ( bp_is_messages_inbox() || bp_is_messages_sentbox() ) : ?>
				<div class="messages-options-nav">
					<?php bp_messages_bulk_management_dropdown(); ?>
				</div><!-- .messages-options-nav -->
            <?php endif; ?>
	
			<?php wp_nonce_field( 'messages_bulk_nonce', 'messages_bulk_nonce' ); ?>
		</form>
	
		<?php
	
		/**
		 * Fires after the members messages threads.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_member_messages_threads' ); ?>
	
		<?php
	
		/**
		 * Fires and displays member messages options.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_member_messages_options' ); ?>
	
	<?php else: ?>
	
		<div id="message" class="info bad-news" style="margin-top:0 !important">
			<p><?php _e( 'Sorry, couldn’t find any messages.', 'buddypress' ); ?></p>
		</div>
	
	<?php endif;?>
</div>
<?php
	
/**
 * Fires after the members messages loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_member_messages_loop' ); ?>

<script>
jQuery( document ).ready(function() {
	//convert table to stackable in mobile
	jQuery('#message-threads').ReStable({
    	rowHeaders: false, // Table has row headers?
    	maxWidth: 960, // Size to which the table become responsive
    	keepHtml: true // Keep the html content of cells
	});
});
</script>
