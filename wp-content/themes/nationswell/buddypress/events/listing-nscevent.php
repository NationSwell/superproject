<?php
global $bp;
?>
<div id="nsc-events" class="tab-content">
    <div class="intro-text">
		<?php if(empty( $_REQUEST['past_events'])){ ?>
			<?php 
			$header_copy = __( 'Council events are unique forums in which members engage in collaborative discussions with featured guests and one another around important national challenges and how best to advance their solutions. Format and size vary.', 'buddypress' );
			$header_copy .= __(" <a href='".$bp->bp_nav['nsc-events']['link']."?past_events=true'>".__('Need to see past events?','buddypress')."</a>");
			echo '<p>'. $header_copy .'</p>';
		 } else {
			 $header_copy = __( 'You’re viewing past events.', 'buddypress' );
			 $header_copy .= __(" <a href='".$bp->bp_nav['nsc-events']['link']."'>".__('See upcoming events &#8594;','buddypress')."</a>");
			 echo '<p>'. $header_copy .'</p>';
		 } ?>
    </div>
    <div class="nsc-item-listing">
		<?php if(empty( $_REQUEST['past_events'])){
			$upcoming_events = NSCEvent::getUpcomingEvents();
		?>
        <!-- upcoming events -->
		<div class="upcoming-events">
        	<?php foreach($upcoming_events as $key=>$event){ ?>
                <div class="item-info">
                    <div class="item-icon">
                        <span class="icon icon_calendar"></span>
                    </div>
                    <div class="item-details">
                        <div class="description">
                        	<p><a href="<?php echo($event['url']); ?>" class="item-title"><?php echo($event['name']); ?></a></p>
                        	<p class="event-description"><?php echo(esc_html($event['description']));?></p>
                        </div>
                        <div class="date-location">
                        	<div class="date-time icon icon_calendar">
                               <span>
									<?php echo($event['fulldate']); ?><br>
                                    <?php echo($event['time']); ?>
                                </span>
                            </div>
                            <div class="location icon icon_marker">
                            	<span><?php echo($event['location']); ?></span>
                            </div>
                       	</div>
                        <div class="rsvp">
                        	<?php
								$rsvp_link = $event['rsvp_link'];
								$rsvp_link_type = $event['rsvp_link_type'];
							?>
							<a href="<?php echo esc_url( $rsvp_link ); ?>" class="button"><?php _e($rsvp_link_type,'buddypress'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
            <?php } ?>
        </div>
        <!-- //END -->
        <?php }else{
		$past_events= NSCEvent::getPastEvents();
        ?>
        <!-- PAST events -->
        <div class="upcoming-events">
        	<?php unset($event); foreach($past_events as $key=>$event){ ?>
                <div class="item-info">
                    <div class="item-icon">
                        <span class="icon icon_calendar"></span>
                    </div>
                    <div class="item-details">
                        <div class="description">
                        	<p><a href="<?php echo($event['url']); ?>" class="item-title"><?php echo($event['name']); ?></a></p>
                        	<p class="event-description"><?php echo(esc_html($event['description']));?></p>
                        </div>
                        <div class="date-location">
                        	<div class="date-time icon icon_calendar">
                               <span>
									<?php echo($event['fulldate']); ?><br>
                                    <?php echo($event['time']); ?>
                                </span>
                            </div>
                            <div class="location icon icon_marker">
                            	<span><?php echo($event['location']); ?></span>
                            </div>
                       	</div>
                    </div>
                </div>
                <div class="divider"></div>
            <?php } ?>
        </div>
         <!-- //END -->
         <?php } ?>
     </div>
</div>