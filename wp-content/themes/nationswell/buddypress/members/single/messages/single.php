<?php
/**
 * BuddyPress - Members Single Message
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>
<div id="message-thread" class="single">

	<?php

	/**
	 * Fires before the display of a single member message thread content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_message_thread_content' ); ?>

	<?php if ( bp_thread_has_messages() ) : ?>
		<div class="message-header-wrapper content-padding single-header">
			<div id="message-recipients" class="message-recipients">
                <span class="highlight">
    
                    <?php if ( bp_get_thread_recipients_count() <= 1 ) : ?>
    
                        <?php _e( 'You are alone in this conversation.', 'buddypress' ); ?>
    
                    <?php elseif ( bp_get_max_thread_recipients_to_list() <= bp_get_thread_recipients_count() ) : ?>
    
                        <?php printf( __( 'Conversation between %s recipients.', 'buddypress' ), number_format_i18n( bp_get_thread_recipients_count() ) ); ?>
    
                    <?php else : ?>
    
                        <?php printf( __( 'Conversation between %s and you.', 'buddypress' ), bp_get_thread_recipients_list() ); ?>
    
                    <?php endif; ?>
    
                </span>
    		</div>
            <div class="single-actions">
                <a href="<?php bp_the_thread_delete_link(); ?>" title="<?php esc_attr_e( "Delete conversation", 'buddypress' ); ?>"><span class="icon icon_trash"></span></a>
    
                <?php
                
                /**
                 * Fires after the action links in the header of a single message thread.
                 *
                 * @since 2.5.0
                 */
                do_action( 'bp_after_message_thread_recipients' ); ?>
            </div>
		 </div>
         
         <div class="single-sibject content-padding">
            
       	 	<h3 id="message-subject"><?php bp_the_thread_subject(); ?></h3>
         </div>

		<?php

		/**
		 * Fires before the display of the message thread list.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_before_message_thread_list' ); ?>

		<?php while ( bp_thread_messages() ) : bp_thread_the_message(); ?>
			<?php bp_get_template_part( 'members/single/messages/message' ); ?>
		<?php endwhile; ?>

		<?php

		/**
		 * Fires after the display of the message thread list.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_after_message_thread_list' ); ?>

		<?php

		/**
		 * Fires before the display of the message thread reply form.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_before_message_thread_reply' ); ?>
		<div class="divider" style="margin:0"></div>
		<form id="send-reply" action="<?php bp_messages_form_action(); ?>" method="post" class="standard-form">

			<div class="message-box content-padding">

				<div class="message-data">

					<?php

					/** This action is documented in bp-templates/bp-legacy/buddypress-functions.php */
					do_action( 'bp_before_message_meta' ); ?>

					<div class="message-avatar">
						<?php bp_loggedin_user_avatar( 'type=thumb&height=60&width=60' ); ?>
					</div>
                    <div class="message-content">
						<h3><?php _e( 'Send a reply', 'buddypress' ); ?></h3>
						<?php
    
                        /**
                         * Fires before the display of the message reply box.
                         *
                         * @since 1.1.0
                         */
                        do_action( 'bp_before_message_reply_box' ); ?>
    
                        <label for="message_content" class="bp-screen-reader-text"><?php _e( 'Reply to Message', 'buddypress' ); ?></label>
                        <textarea name="content" id="message_content" rows="15" cols="40"></textarea>
    
                        <?php
    
                        /**
                         * Fires after the display of the message reply box.
                         *
                         * @since 1.1.0
                         */
                        do_action( 'bp_after_message_reply_box' ); ?>

                        <div class="submit">
                            <input type="submit" name="send" value="<?php esc_attr_e( 'Send Reply', 'buddypress' ); ?>" id="send_reply_button"/>
                        </div>

						<input type="hidden" id="thread_id" name="thread_id" value="<?php bp_the_thread_id(); ?>" />
						<input type="hidden" id="messages_order" name="messages_order" value="<?php bp_thread_messages_order(); ?>" />
						<?php wp_nonce_field( 'messages_send_message', 'send_message_nonce' ); ?>

					</div><!-- .message-content -->
                    

					<?php

					/** This action is documented in bp-templates/bp-legacy/buddypress-functions.php */
					do_action( 'bp_after_message_meta' ); ?>

				</div><!-- .message-data -->

				

			</div><!-- .message-box -->

		</form><!-- #send-reply -->

		<?php

		/**
		 * Fires after the display of the message thread reply form.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_after_message_thread_reply' ); ?>

	<?php endif; ?>

	<?php

	/**
	 * Fires after the display of a single member message thread content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_message_thread_content' ); ?>

</div>
