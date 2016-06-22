<div id="nsc-events" class="tab-content">
    <div class="intro-text">
			<?php 
			$header_copy = __( 'From advisory sessions between social innovators and members to trips that benefit a community or nonprofit, Council members have frequent opportunities to engage in service. All experiences provide members with unique ways to generate impact and contribute to solutions. Format and size vary.', 'buddypress' );
			echo '<p>'. $header_copy .'</p>';
			?>
    </div>
    <div class="nsc-item-listing">
		<div class="service-opportunities">
        	<?php //foreach($upcoming_events as $key=>$event){ ?>
                <div class="item-info">
                    <div class="item-icon">
                        <span class="icon icon_opportunity"></span>
                    </div>
                    <div class="item-details">
                        <div class="description">
                        	<p><a href="<?php //echo($event['url']); ?>" class="item-title"><?php e//cho($event['name']); ?></a></p>
                        	<p class="event-description"><?php //echo(esc_html($event['description']));?></p>
                        </div>
                        <div class="date-location">
                        	<div class="date-time icon icon_calendar">
                               <span>
									<?php //echo($event['fulldate']); ?><br>
                                    <?php //echo($event['time']); ?>
                                </span>
                            </div>
                            <div class="location icon icon_marker">
                            	<span><?php //echo($event['location']); ?></span>
                            </div>
                       	</div>
                        <div class="rsvp">
                        	<?php
								$rsvp_link = "#";
								$rsvp_label = "RSVP";
							?>
                        	<a href="<?php echo esc_url( $rsvp_link ); ?>" class="button"><?php _e($rsvp_label,'buddypress'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
            <?php //} ?>
        </div>
   </div>
</div>