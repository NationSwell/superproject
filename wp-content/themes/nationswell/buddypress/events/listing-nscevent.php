<?php
$upcoming_events = NSCEvent::getUpcomingEvents();
$past_events= NSCEvent::getPastEvents();

?>
<div id="nsc-events" class="tab-content">
    <div class="intro-text">
    	<p><?php _e( 'Council events are unique forums in which members engage in collaborative discussions with featured guests and one another around important national challenges and how best to advance their solutions. Format and size vary. Need to see past events?', 'buddypress' ); ?></p>
    </div>
    <div class="nsc-item-listing">
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
     </div>
</div>