<?php
global $bp;
?>
<div id="nsc-events" class="tab-content">
    <div class="intro-text">
		<?php if(empty( $_REQUEST['past_events'])){ ?>
			<p><?php _e( 'Council events are unique forums in which members engage in collaborative discussions with featured guests and one another around important national challenges and how best to advance their solutions. Format and size vary.', 'buddypress' ); echo(" <a href='".$bp->bp_nav['nsc-events']['link']."?past_events=true'>"._('Need to see past events?','buddypress')."</a>"); ?></p>
		<?php }else{ ?>
			<p><?php _e( 'Your viewing past events', 'buddypress' ); echo(" <a href='".$bp->bp_nav['nsc-events']['link']."'>"._('See upcoming events?','buddypress')."</a>"); ?></p>
		<?php } ?>
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
									<?php echo($event['month']); ?> <?php echo($event['day']); ?>, <?php echo($event['year']); ?><br>
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
									<?php echo($event['month']); ?> <?php echo($event['day']); ?>, <?php echo($event['year']); ?><br>
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