<?php
$upcoming_events = NSCEvent::getUpcomingEvents();
$past_events= NSCEvent::getPastEvents();

?>
<div id="nsc-events">
    <div class="member-title"><h2>Upcoming Events</h2></div>
    <div class="events">
        <ul>
        	<?php foreach($upcoming_events as $key=>$event){ ?>
            <li>
                <div class="event-info">
                    <div class="upcoming event-date">
                        <ul>
                            <li><?php echo($event['month']); ?></li>
                            <li><?php echo($event['day']); ?></li>
							<li class="year"><?php echo($event['year']); ?></li>
                        </ul>
                    </div>
                    <div class="about-event">
                    	<ul>
                            <li><?php echo($event['month']); ?></li>
                            <li><?php echo($event['day']); ?></li>
							<li class="year"><?php echo($event['year']); ?></li>
                        </ul>
                        <a href="<?php echo($event['url']); ?>"><h3><?php echo($event['name']); ?></h3></a>
                        <div class="event-details"><?php echo($event['time']); ?> at <?php echo($event['location']); ?></div>
                        <div class="event-description"><?php echo(esc_html($event['description']));?></div>
                        <div class="event-link"><a href="<?php echo($event['url']); ?>">Click here for more information</a></div>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
        <div class="member-title"><h1>Past Events</h1></div>
        <ul>
        	<?php unset($event); foreach($past_events as $key=>$event){ ?>
            <li>
                <div class="event-info">
                    <div class="past event-date">
                        <ul>
                            <li><?php echo($event['month']); ?></li>
                            <li><?php echo($event['day']); ?></li>
                            <li class="year"><?php echo($event['year']); ?></li>
                        </ul>
                    </div>
                    <div class="about-event">
                        <a href="<?php echo($event['url']); ?>"><h1 class="hd-n"><?php echo($event['name']); ?></h1></a>
                        <div class="event-details"><?php echo($event['time']); ?> at <?php echo($event['location']); ?></div>
                        <div class="event-description"><?php echo(esc_html($event['description']));?></div>
                        <div class="event-link"><a href="<?php echo($event['url']); ?>">Click here for more information</a></div>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>