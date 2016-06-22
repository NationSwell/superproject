<?php
/*
Template Name: NSC Landing
Cloudred notes: no idea why this page exists and why it was created this way, clearly not good. Hijacking it for member login purposes.
*/
global $bp;

?>


<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">	
		<title>
			<?php if (is_home() || is_front_page()) { echo bloginfo('name');
			} elseif (is_404()) {
			echo '404 Not Found';
			} elseif (is_category()) {
			echo 'Category:'; wp_title('');
			} elseif (is_search()) {
			echo 'Search Results';
			} elseif ( is_day() || is_month() || is_year() ) {
			echo 'Archives:'; wp_title('');
			} else {
			echo wp_title('');
			}
			?>
		</title>
    	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
		<meta name="viewport" content="width=device-width">
		<?php if(is_search()) { ?>
		<meta name="robots" content="noindex, nofollow" /> 
	    <?php }?>
    	<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=PT+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/nsc.css" media="screen" />
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		
		<!--[if lt IE 9]>
		<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js">IE7_PNG_SUFFIX=".png";</script>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]--> 
		
		
		<?php wp_head(); ?>

	</head>

	<body>
	
		<!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
	
		<div id="container">
        	<header>
            </header>
            <div id="content">
				<a id="top"></a>
                <section class="member-login-forms">
                    <div class="content-wrapper">
                        <div class="content">
                            
                            <div class="intro">
                            	<h1 class="logo"><?php _e( 'NationSwell Council', 'buddypress' ); ?></h1>
                           		<p><?php _e( 'A diverse community of accomplished professionals who are passionate about service', 'buddypress' ); ?></p>
                            </div>
                            <div class="login-form">
                                <div class="login-form-inputs">
                                    <?php   
									$lostpassword = '<a href="'.wp_lostpassword_url().'">'.__( 'Forgot password?','buddypress').'</a>';
                                    
									if( $_GET["register"] ) {
										//show register form
										echo '<h2>'.__( 'Register','example').'</h2>';
										$bottom_message = __( 'Enter the primary email address we have on file for you.','example'); ?>
										<form id="lostpasswordform" class="lostpassword-form" action="<?php echo wp_lostpassword_url(); ?>" method="post">
											<p class="form-row">
												<label for="user_first_name"><?php _e( 'First name', 'buddypress' ); ?>
												<input type="text" name="user_first_name" id="user_first_name">
											</p>
                                            <p class="form-row">
												<label for="user_last_name"><?php _e( 'Last name', 'buddypress' ); ?>
												<input type="text" name="user_last_name" id="user_last_name">
											</p>
                                            <p class="form-row">
												<label for="user_login"><?php _e( 'Email address', 'buddypress' ); ?>
												<input type="text" name="user_login" id="user_login">
											</p>
									 		<div class="form-row">
                                                <p class="login-remember">
                                                    <a href="<?php echo esc_url( get_permalink() ); ?>"><?php _e( 'Back to member login', 'buddypress' ); ?></a>
                                                </p>
                                                <p class="lostpassword-submit">
                                                    <input type="submit" name="submit" class="lostpassword-button"
                                                           value="<?php _e( 'Register', 'buddypress' ); ?>"/>
                                                </p>
                                            </div>
										</form>
                                    <?php    
									} else {
										//show login
										echo '<h2>'.__( 'Member Login','example').'</h2>';
										$bottom_message = __( 'Forgot your password?','buddypress') . '<a href="'.wp_lostpassword_url().'">'.__( 'Reset it here.','buddypress').'</a><br>';
										$bottom_message .= __( 'Are you a member but haven’t yet registered on our portal?','example') .' <a href="'. esc_url( get_permalink() ).'?register=true">'. __( 'Register now!','example').'</a>';
										if( function_exists('bp_is_active') ) {
											$redirect_url = bp_get_root_domain().'/members/'.bp_members_get_user_nicename($bp->loggedin_user->id).'/activity/';
										} else {
											$redirect_url = '/wp-admin';
										}
										$args = array(
										'echo'           => true,
										'remember'       => true,
										'redirect'       => $redirect_url,
										'form_id'        => 'loginform',
										'id_username'    => 'user_login',
										'id_password'    => 'user_pass',
										'id_remember'    => 'rememberme',
										'id_submit'      => 'wp-submit',
										'label_username' => __( 'Your email address' ),
										'label_password' => __( 'Password' ),
										'label_remember' => __( 'Remember me' ),
										'label_log_in'   => __( 'Log in' ),
										'value_username' => '',
										'value_remember' => false
										);
								
										wp_login_form( $args );
									}
                                    ?> 
                            
                                </div>
                                <div class="login-form-bottom">
                                    <p><?php echo $bottom_message; ?></p>
                                </div>
                            </div>
                      		<!--<a href="http://nationswell.com/nsc-portal/" class="btn red"><span>Sign in</span></a>-->
                            <div class="link-more">
                            	<a class="learn-more" href="#welcome">Learn More</a>
                            </div>
                        </div>
                    </div>
                </section>
<section class="photo-strip" id="welcome">
<?php 

$images = get_field('photo_strips');

if( $images ): shuffle( $images ) ?>
    <ul>
        <?php foreach( $images as $image ): ?>
            <li><img src="<?php echo $image['sizes']['event-thumb']; ?>" alt="<?php echo $image['alt']; ?>" /></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
</section>
<section id="benefits">
  <div class="inner">
  	<h4>Membership</h4>
  	<div class="member-box">
  	<?php if(get_field('members')): ?>
  	 
  		<ul class="member-list">
  	 
  		<?php while(has_sub_field('members')): ?>
  		<li>
  			<?php $image = get_sub_field('image'); ?>
  			<div class="image-container">
    			<div class="overlay"></div>
    			<img src="<?php echo $image['sizes']['member-thumb']; ?>" alt="<?php echo $image['alt']; ?>" />
          <div class="credits">
      			<h6><?php the_sub_field('name'); ?></h6>
      			<?php the_sub_field('title'); ?>
    			</div>
  			</div>
  		</li>
  	 
  		<?php endwhile; ?>
  	 
  		</ul>
  	 
  	<?php endif; ?>
  	<p class="highlight">NationSwell Council members have access to</p>
  	<img src="<?php bloginfo('template_directory'); ?>/img/star-embellishment.png" alt="NationSwell" class="embellishment" />
  	<p>Meetings with America’s leading problem-solvers<br />
Jeffersonian-style dinners to unpack and advance solutions<br />
Introductions to the broader NationSwell network of innovators<br />
Opportunities for direct service and impact</p>
      <a href="http://nationswell.com/nsc-portal/" class="btn red"><span>Sign in</span></a>
  	<?php if(get_field('testimonials')): ?>
  	 
  		<ul class="testimonial-list bxslider">
  	 
  		<?php while(has_sub_field('testimonials')): ?>
  		<li>
  			<div class="text">
    			<div class="container"><?php the_sub_field('quote'); ?></div>
  			</div>
  			<div class="byline">
    			 <div class="container"><?php the_sub_field('byline'); ?></div>
  			</div>
  		</li>
  		<?php endwhile; ?>
  	 
  		</ul>
  	 
  	<?php endif; ?>
  	</div>
	</div>
</section>
<section id="goals">
	<div class="overlay"></div>
	<div class="inner">
		<p>Members of the NationSwell Council know that America faces challenges.<br />They also believe that those problems are solvable.<br />Council members are committed to advancing innovations that:</p>
		<ul class="core-focus">
			<li class="one"><div class="fill"><div class="cut"></div></div><span>bridge the <b>OPPORTUNITY</b> divide</span></li>
			<li class="two"><div class="fill"><div class="cut"></div></div><span>make <b>GOVERNMENT</b> work</span></li>
			<li class="three"><div class="fill"><div class="cut"></div></div><span>advance <b>NATIONAL SERVICE</b></span></li>
			<li class="four"><div class="fill"><div class="cut"></div></div><span>preserve our <b>ENVIRONMENT</b></span></li>
		</ul>
	</div>
</section>
<section class="quote">
  <div class="inner">
    <?php
    
    $rows = get_field('pullquote' ); // get all the rows
    $first_row = $rows[0]; // get the first row
    $second_row = $rows[1]; // get the first row
    ?>
    <div class="copy">
      <p><?php echo $first_row['quote' ]; ?></p>
      <div class="byline"><?php echo $first_row['byline' ]; ?></div>
    </div>
    <?php $image =  $first_row['associated_image' ]; ?>
    <img src="<?php echo $image['sizes']['quote-thumb']; ?>" alt="<?php echo $image['alt']; ?>" />
    <div class="clear"></div>
  </div>
</section>
<section id="events">
  <div class="inner">
    <p>Council events are intimate forums in which members engage in collaborative discussions with featured guests and one another around important national challenges, efforts to solve those challenges, and how best to advance the solutions.</p>
  </div>
  <div id="event-list">
    <div class="filter">
      <a href="#" data-filter="current" class="active clicked"><span>Upcoming Events</span></a>
      <a href="#" data-filter="past"><span>Past Events</span></a>
    </div>
    <ul class="current-events events-listings">
		<?php 
		    query_posts(array( 
				    'order' => 'ASC',
		        'post_type' => 'events',
		        'showposts' => 10,
           'meta_key' => 'date',
           'orderby' => 'meta_value_num',
           'order' => 'ASC',
          	'meta_query' => array(
          		array(
          			'key' => 'past',
          			'value' => '0',
          			'compare' => '==='
          		)
          	)		    
        ) );  
		?>
		<?php if(have_posts()) { ?>
		<?php while (have_posts()) : the_post();?>
			<li>
  			<?php if ( has_post_thumbnail() ) { ?>
  				<?php the_post_thumbnail( 'event-thumb' ); ?>
  			<?php } ?>
			  <div class="text">
  			  <div class="date"><?php the_field('date'); ?></div>
  				<h3><?php the_title(); ?></h3>
  				<?php the_content(); ?>
			  </div>
			</li>
		<?php endwhile;?>
		<?php } else { ?>
			<h3>Currently, no events are scheduled.</h3>
		<?php } ?>
		<?php wp_reset_query(); ?>
    </ul>
    <ul class="past-events events-listings">
		<?php 
		    query_posts(array( 
			    	'order' => 'ASC',
		        'post_type' => 'events',
		        'showposts' => 10,
           'meta_key' => 'date',
           'orderby' => 'meta_value_num',
           'order' => 'DESC',
          	'meta_query' => array(
          		array(
          			'key' => 'past',
          			'value' => '1',
          			'compare' => '==='
          		)
          	)		    
        ) );  
		?>
		<?php while (have_posts()) : the_post();?>
			<li>
  			<?php if ( has_post_thumbnail() ) { ?>
  				<?php the_post_thumbnail( 'event-thumb' ); ?>
  			<?php } ?>
			  <div class="text">
  			  <div class="date"><?php the_field('date'); ?></div>
  				<h3><?php the_title(); ?></h3>
  				<?php the_content(); ?>
			  </div>
			</li>
		<?php endwhile;?>
		<?php wp_reset_query(); ?>
    </ul>
  </div>
</section>
<section class="quote">
  <div class="inner">
    <div class="copy">
      <p><?php echo $second_row['quote' ]; ?></p>
      <div class="byline"><?php echo $second_row['byline' ]; ?></div>
    </div>
    <?php $image =  $second_row['associated_image' ]; ?>
    <img src="<?php echo $image['sizes']['quote-thumb']; ?>" alt="<?php echo $image['alt']; ?>" />
    <div class="clear"></div>
  </div>
</section>
<section id="apply">
  <div class="overlay"></div>
  <div class="inner">
      <p class="large">Members join the council by invitation or application.</p>
      <a href="http://nationswell.com/nsc-portal/" class="btn red"><span>Sign in</span></a>
			<div class="sidenote">Not a member? <a href="mailto:nsc@nationswell.com">Apply</a></div>
			<p class="spacer">For inquiries about membership or for more information about the NationSwell Council, please contact us at <a href="mailto:nsc@nationswell.com">nsc@nationswell.com</a>.</p>
  </div>
</section>
<section class="photo-strip">
<?php 

$images = get_field('photo_strips');

if( $images ): shuffle( $images ) ?>
    <ul>
        <?php foreach( $images as $image ): ?>
            <li><img src="<?php echo $image['sizes']['event-thumb']; ?>" alt="<?php echo $image['alt']; ?>" /></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
</section>
<section id="footer">
  <div class="inner">
    <div class="footer-nav">
      <a href="http://nationswell.com/privacy/">Privacy Policy</a>
      <a href="http://nationswell.com/termsofservice/">Terms of Service</a>
    </div>
    <div class="copyright">
      &copy;<?php echo date('Y'); ?> NationSwell. All rights reserved.<br />
      <span class="site-design">Carefully crafted by <a href="http://milkandpixels.com" target="_blank">Milk & Pixels</a></span>
    </div>
    <a class="back-top" href="#top">
	    <div class="star-container">
		    <img id="arrow" src="<?php bloginfo('template_directory'); ?>/img/footerarrow.png" />
		    <img id="tips" src="<?php bloginfo('template_directory'); ?>/img/footerstartips.png" />
		  </div>
    </a>
  </div>
</section>

			</div>
			<!--</END CONTENT>-->
        <footer>
        
        </footer>

	</div>
	<!--</END WRAPPER-->		
		<?php wp_footer(); ?>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script>
        window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/jquery-1.8.3.min.js"><\/script>')
        </script>
        <script src="<?php echo get_template_directory_uri(); ?>/js/plugins.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/js/main.js"></script>
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-65566331-1', 'auto');
  ga('send', 'pageview');

</script>      
	</body>

</html>