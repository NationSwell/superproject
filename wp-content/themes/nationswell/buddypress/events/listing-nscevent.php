<?php
global $bp;
?>
<div id="nsc-events" class="tab-content">
    <div class="intro-text">
		<?php if(empty( $_REQUEST['past_events'])){ ?>
			<?php 
			$header_copy = __( 'Council events are unique forums in which members engage in collaborative discussions with featured guests and one another around important national challenges and how best to advance their solutions. Format and size vary.', 'buddypress' );
			$header_copy .= __(" <a href='".$bp->bp_nav['nsc-events']['link']."?past_events=true'>".__('Interested in past events?','buddypress')."</a>");
			echo '<p>'. $header_copy .'</p>';
		 } else {
			 $header_copy = __( 'You’re viewing past events.', 'buddypress' );
			 $header_copy .= __(" <a href='".$bp->bp_nav['nsc-events']['link']."'>".__('See upcoming events &#8594;','buddypress')."</a>");
			 echo '<p>'. $header_copy .'</p>';
		 } ?>
    </div>
    <div class="nsc-item-listing">
		<div class="search-filter">
			<?php
			if(empty($_REQUEST['location']) && empty($_REQUEST['search_events'])){
				$_REQUEST['location'] = bp_get_profile_field_data(array('field'=>'Council branch','user_id'=>$bp->loggedin_user->id));
			}
			$field_key = "field_576b17d4f5dac";
			$field = get_field_object($field_key);
			if( $field ){
				echo '<form method="get">';
				echo '<label for="location">'.__('Displaying events in','buddypress').'</label>';
				echo '<select id="location" name="location" class="member-form-input member-form-select short">';
					echo '<option value="">' .__('All locations','buddypress'). '</option>';
					foreach( $field['choices'] as $key => $value )
					{
						if($_REQUEST['location']== $value){
							echo '<option value="' . $key . '" selected="selected">' . $value . '</option>';
						}else{
							echo '<option value="' . $key . '">' . $value . '</option>';
						}
					}
				echo '</select>';
				echo '<input type="hidden" name="search_events" value="true"/>';
				if(!empty($_REQUEST['past_events'])){
					echo '<input type="hidden" name="past_events" value="true"/>';
				}
				echo '</form>';
			}?>
			<script>
			jQuery(function() {
				jQuery("#location").change(function() {
					jQuery("form").submit();
				});
			});
			</script>
		</div>
		<?php if(empty( $_REQUEST['past_events'])){
			$upcoming_events = NSCEvent::getUpcomingEvents();
		?>
        <!-- upcoming events -->
		<div class="upcoming-events">
        	<?php if (!empty($upcoming_events)):
				foreach($upcoming_events as $key=>$event){ ?>
					<div class="item-info">
						<div class="item-icon">
							<span class="icon icon_calendar"></span>
						</div>
						<div class="item-details">
							<div class="description">
								<p class="item-title"><?php echo($event['name']); ?></p>
								<p class="event-description"><?php echo $event['description'];?></p>
                                <p class="event-description"><?php echo $event['full_description'];?></p>
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
								<?php if (!empty($rsvp_link)): ?>
                                	<a href="<?php echo esc_url( $rsvp_link ); ?>" class="button action" target="_blank"><?php _e($rsvp_link_type,'buddypress'); ?></a>
                                    <?php if (strtolower($rsvp_link_type) =='request invite'): ?>
                                    	<a href="javascript:void(0);" title="<?php _e('This is an <em>Off the Record</em> event: a shared conversation between an influential expert and a curated group of members. These discussions provide an opportunity to dive deeply into an issue in a confidential, intimate setting; attendance ranges from 20 to 25 people. Space is limited – please request an invite for the opportunity to be included.  
','buddypress'); ?>" rel="tooltip"><span class="icon icon_information-button"></span></a>
                                    <?php endif; ?>
                                <?php endif; ?>
							</div>
						</div>
					</div>
					<div class="divider"></div>
				<?php } ?>
            <?php else: ?>
                <div class="no-items">
                    <p><?php _e('There are no upcoming events','buddypress'); ?></p>
                </div>
             <?php endif; ?>
        </div>
        <!-- //END -->
        <?php }else{
		$past_events= NSCEvent::getPastEvents();
        ?>
        <!-- PAST events -->
        <div class="upcoming-events">
        	<?php unset($event); 
			if (!empty($past_events)):
				foreach($past_events as $key=>$event){ ?>
					<div class="item-info">
						<div class="item-icon">
							<span class="icon icon_calendar"></span>
						</div>
						<div class="item-details">
							<div class="description">
								<p><a href="<?php echo($event['url']); ?>" class="item-title"><?php echo($event['name']); ?></a></p>
								<p class="event-description"><?php echo $event['description'];?></p>
                                <p class="event-description"><?php echo $event['full_description'];?></p>
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
            <?php else: ?>
            	 <div class="no-items">
                    <p><?php _e('There are no past events','buddypress'); ?></p>
                </div>
            <?php endif; ?>
        </div>
         <!-- //END -->
         <?php } ?>
     </div>
</div>