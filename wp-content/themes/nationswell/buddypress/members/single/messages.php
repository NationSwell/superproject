<?php
/**
 * BuddyPress - Users Messages
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>
<div class="ns-messages" id="ns-messages">
    <div class="item-list-tabs no-ajax messages-nav" id="subnav" role="navigation">
        <ul>
        
            <?php bp_get_options_nav(); ?>
        
        </ul>
    
    </div><!-- .item-list-tabs -->
    
    <div class="messages">
    <?php
	//echo "current action: ".bp_current_action();
    switch ( bp_current_action() ) :
    
        // Inbox/Sentbox
        case 'inbox'   :
        case 'sentbox' :
    
            /**
             * Fires before the member messages content for inbox and sentbox.
             *
             * @since 1.2.0
             */
            do_action( 'bp_before_member_messages_content' ); ?>
    
            
                <div class="message-header-wrapper">
                    <div class="messages-header">
                        <?php if ( bp_is_messages_inbox() || bp_is_messages_sentbox() ) : ?>
                            <div class="message-search"><?php bp_message_search_form(); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="messages-list">
                    <?php bp_get_template_part( 'members/single/messages/messages-loop' ); ?>
                </div>

            <?php
    
            /**
             * Fires after the member messages content for inbox and sentbox.
             *
             * @since 1.2.0
             */
            do_action( 'bp_after_member_messages_content' );
            break;
    
        // Single Message View
        case 'view' :
            bp_get_template_part( 'members/single/messages/single' );
            break;
    
        // Compose
        case 'compose' :
            bp_get_template_part( 'members/single/messages/compose' );
            break;
    
        // Sitewide Notices
        case 'notices' :
    
            /**
             * Fires before the member messages content for notices.
             *
             * @since 1.2.0
             */
            do_action( 'bp_before_member_messages_content' ); ?>
    
           <?php  bp_get_template_part( 'members/single/messages/notices-loop' ); ?>
    
            <?php
    
            /**
             * Fires after the member messages content for inbox and sentbox.
             *
             * @since 1.2.0
             */
            do_action( 'bp_after_member_messages_content' );
            break;
    
        // Any other
        default :
			bp_get_template_part( 'members/single/plugins' );
            break;
    endswitch; ?>
	</div><!-- .messages -->
</div>