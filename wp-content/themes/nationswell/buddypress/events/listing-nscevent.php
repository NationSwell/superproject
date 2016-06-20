<?php
$upcoming_events = NSCEvent::getUpcomingEvents();
$past_events= NSCEvent::getPastEvents();

?>
<div id="nsc-events">
    <div class="member-title"><h1>Upcoming Events</h1></div>
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
                        <a ng-href="<?php echo($event['url']); ?>"><h1 class="hd-n"><?php echo($event['name']); ?></h1></a>
                        <div class="event-details"><?php echo($event['time']); ?> at <?php echo($event['location']); ?></div>
                        <div class="event-description" ng-bind-html="echo($event['description']);"></div>
                        <div class="event-link"><a ng-href="<?php echo($event['url']); ?>">Click here for more information</a></div>
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
                        <a ng-href="<?php echo($event['url']); ?>"><h1 class="hd-n"><?php echo($event['name']); ?></h1></a>
                        <div class="event-details"><?php echo($event['time']); ?> at <?php echo($event['location']); ?></div>
                        <div class="event-description" ng-bind-html="echo($event['description']);"></div>
                        <div class="event-link"><a ng-href="<?php echo($event['url']); ?>">Click here for more information</a></div>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>