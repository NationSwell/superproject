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
		<div class="search-filter">
			<?php
			if(empty($_REQUEST['location']) && empty($_REQUEST['search_opportunities'])){
				$_REQUEST['location'] = bp_get_profile_field_data(array('field'=>'Council branch','user_id'=>$bp->loggedin_user->id));
			}
			//Staging field key
			//$field_key = "field_576b17d4f5dad";
			
			//Production field key
			$field_key = "field_578ff22261702";
			$field = get_field_object($field_key);
			if( $field ){
				echo '<form method="get">';
				echo '<label for="location">'.__('Displaying opportunities in','buddypress').'</label>';
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
				echo '</select><input type="hidden" name="search_opportunities" value="true"/></form>';
			}?>
			<script>
			jQuery(function() {
				jQuery("#location").change(function() {
					jQuery("form").submit();
				});
			});
			</script>
		</div>
		<div class="service-opportunities">
		<?php $upcoming_opps = NSCOpportunity::getUpcomingOpportunities();?>
		<?php 
		if (!empty($upcoming_opps)):
			foreach($upcoming_opps as $key=>$opp){ ?>
					<div class="item-info">
						<div class="item-icon">
							<span class="icon icon_opportunity"></span>
						</div>
						<div class="item-details">
							<div class="description">
								<p><a href="<?php echo($opp['opportunity_url']); ?>" class="item-title"><?php echo($opp['name']); ?></a></p>
								<p class="event-description"><?php echo $opp['description']; ?></p>
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
								<?php if (!empty($rsvp_link)): ?>
                                	<a href="<?php echo esc_url( $rsvp_link ); ?>" class="button" target="_blank"><?php _e($rsvp_label,'buddypress'); ?></a>
                                <?php endif; ?>
							</div>
						</div>
					</div>
					<div class="divider"></div>
				<?php } ?>
            <?php else: ?>
            	<div class="no-items">
                    <p><?php _e('There are no service opportunities','buddypress'); ?></p>
                </div>
            <?php endif; ?>
        </div>
   </div>
</div>