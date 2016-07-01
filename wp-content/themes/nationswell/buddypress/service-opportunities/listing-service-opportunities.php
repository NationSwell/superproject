<?php
global $bp;
?>
<div id="nsc-events" class="tab-content">
    <div class="intro-text">
			<?php 
			$header_copy = __( 'From advisory sessions between social innovators and members to trips that benefit a community or nonprofit, Council members have frequent opportunities to engage in service. All experiences provide members with unique ways to generate impact and contribute to solutions. Format and size vary.', 'buddypress' );
			echo '<p>'. $header_copy .'</p>';
			?>
    </div>
    <div class="nsc-item-listing">
		<div class="service-opportunities">
		<?php $upcoming_opps = NSCOpportunity::getUpcomingOpportunities();?>
		<?php foreach($upcoming_opps as $key=>$opp){ ?>
                <div class="item-info">
                    <div class="item-icon">
                        <span class="icon icon_opportunity"></span>
                    </div>
                    <div class="item-details">
                        <div class="description">
                        	<p><a href="<?php echo($opp['opportunity_url']); ?>" class="item-title"><?php echo($opp['name']); ?></a></p>
                        	<p class="event-description"><?php echo(esc_html($opp['description']));?></p>
                        </div>
                        <div class="date-location">
                        	<div class="date-time icon icon_calendar">
                               <span>
                               <?php echo('<div style="font-weight: bold;">'.$opp['opportunity_type'].'</div>'); ?>
                               <?php if($opp['opportunity_type']=='One-time'){echo($opp['fulldate']); if(!empty($opp['time'])){echo(' at '.$opp['time']);}  echo('</br>');} ?>
									<?php if(!empty($opp['application_deadline'])){
										_e('Application deadline:','buddypress');
										echo('</br>');
										echo($opp['application_deadline']);
									}
                                    ?>
                                </span>
                            </div>
                            <div class="location icon icon_marker">
                            <span><?php echo($opp['location']); ?></span>
                            </div>
                       	</div>
                        <div class="rsvp">
                        	<?php
								$rsvp_link = $opp['opportunity_url'];
								$rsvp_label = "Get Involved";
							?>
                        	<a href="<?php echo esc_url( $rsvp_link ); ?>" class="button"><?php _e($rsvp_label,'buddypress'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
            <?php } ?>
        </div>
   </div>
</div>