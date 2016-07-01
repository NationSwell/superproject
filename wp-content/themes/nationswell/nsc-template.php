<?php
/*
Template Name: NSC Landing
Cloudred notes: no idea why this page exists and why it was created this way, clearly not good. Hijacking it for member login purposes.
*/
global $bp;
global $wpdb, $current_site;
//bad email entered
$error_email = '';
//general system error
$error_system = '';
//no such user exists
$error_user = '';
$success = false;

//figure out if the form has been submitted
if (isset($_POST['action']) && $_POST['action']=='reset') :
	//get form values
	$user_login = sanitize_text_field($_POST['user_login']);
	$user_first_name = sanitize_text_field($_POST['user_first_name']);
	$user_last_name = sanitize_text_field($_POST['user_last_name']);
	
	if( empty( $user_login ) ) {
		$error_email = 'Enter your e-mail address...';
	} else if( ! is_email( $user_login )) {
		$error_email = 'Invalid e-mail address';
	} else if( ! email_exists( $user_login ) ) {
		$error_user = 'There is no member registered with that email address';
	} else {
		//we got the email, all good, now send the password reset link to user.
		$user_data = get_user_by('email', $user_login);
		
		//print_r($user_data);
		
		//do_action('lostpassword_post');
	
	
		if ( !$user_data ) {
			$error_user = 'Oh no! Something has gone horribly wrong (frown)';
		}
	
		// redefining user_login ensures we return the right case in the email
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
		$user_info = get_userdata( $user_data->ID );
		$first_name = $user_info->first_name;
	
		//do_action('retreive_password', $user_login);  // Misspelled and deprecated
		//do_action('retrieve_password', $user_login);
	
		$allow = apply_filters('allow_password_reset', true, $user_data->ID);
	
		if ( ! $allow ) {
			$error_system = 'This action isn’t allowed at this time';
		} else if ( is_wp_error($allow) ) {
			$error_system = 'Oh no! Something has gone horribly wrong (frown)';
		}
		
		
		//$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
		//if ( empty($key) ) {
			// Generate something random for a key...
			$key = wp_generate_password(20, false);
			$hash_key = wp_hash_password($key);
			//do_action('retrieve_password_key', $user_login, $key);
			// Now insert the new md5 key into the db
			$wpdb->update($wpdb->users, array('user_activation_key' => time() . ':' . $hash_key), array('user_login' => $user_login));
		//}
		$message = sprintf(__('Hi %s,'), $first_name) . "\r\n\r\n";
		$message .= __('Thank you for activating your NationSwell Council portal account! The final step is creating a unique password by using the link below:') . "\r\n\r\n";
		//$message .= network_home_url( '/' ) . "\r\n\r\n";
		//$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
		//$message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
		$message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n\r\n";
		
		$message .= __('This link will remain valid for the next 24 hours only. If this window has passed, please return to <'.network_home_url( "/nationswell-council/?register=true","register"). '> and request a new link.') . "\r\n\r\n";
		
		$message .= __('Please reach out to our ops expert, Melissa, with any questions: Melissa@nationswell.com') . "\r\n\r\n";
		
		$message .= __('Enjoy!') . "\r\n\r\n";
		
		
		$message .= __('Warmly,') . "\r\n";
		$message .= __('The NationSwell Council Team') . "\r\n";
		$message .= network_home_url( '/' );
	
		$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	
		$title = __('Welcome to NationSwell');
	
		$title = apply_filters('retrieve_password_title', $title);
		$message = apply_filters('retrieve_password_message', $message, $key);
	
		if ( $message && !wp_mail($user_email, $title, $message) ) {
			wp_die( __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') );
		} else {
			$success = true;
		}
	}

endif;



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
                                <div class="login-form-inputs"<?php if ($_GET["register"]): echo ' style="padding-bottom:0;"'; endif; ?>>
                                    <?php   
									$lostpassword = '<a href="'.wp_lostpassword_url().'">'.__( 'Forgot password?','buddypress').'</a>';
                                    
									if( $_GET["register"] ) {
										//show register form
										echo '<h2>'.__( 'Register','example').'</h2>';
										 ?>
										
                                        <?php if ($success) : ?>
                                        	<?php $bottom_message = '<a href="'.get_permalink().'">'.__( '&#8592; Back to member login','buddypress').'</a>'; ?>
                                        	<p style="margin-bottom:100px"><?php _e('A match was made with the information you provided. Please check your email account for a message from us.','buddypress'); ?></p>
                                            
                                            <?php else : ?>
                                        	<?php $bottom_message = __( 'Enter the primary email address we have on file for you.','buddypress'); ?>
                                            <form id="lostpasswordform" class="lostpassword-form" action="<?php echo the_permalink(); ?>?register=true" method="post">
                                                <?php if (!empty($error_user)) : 
                                                            $contact_link = '<a href="'.get_site_url().'/contact/">'.__('Contact us.','buddypress').'</a>';						
                                                            echo '<p class="form-row login-error">';
                                                            echo __('The information you submitted does not match our records&#8212;please try again! If you think this is an error, please get in touch! ','buddypress') . $contact_link;
                                                       elseif (!empty($error_system)) :
                                                             echo $error_system .' '. $contact_link;
                                                            echo '</p>';
                                                       endif;
                                                    ?>
                                                
                                                <p class="form-row">
                                                    <label for="user_first_name"><?php _e( 'First name', 'buddypress' ); ?></label>
                                                    <input type="text" name="user_first_name" id="user_first_name">
                                                </p>
                                                <p class="form-row">
                                                    <label for="user_last_name"><?php _e( 'Last name', 'buddypress' ); ?></label>
                                                    <input type="text" name="user_last_name" id="user_last_name">
                                                </p>
                                                <p class="form-row">
                                                    <label for="user_login">
                                                    
                                                    <?php if( ! empty( $error_email ) ) {
                                                            echo '<span class="login-error">'. $error_email .'</span>';
                                                          } else {
                                                              echo __( 'Email address', 'buddypress' );
                                                          }
                                                        $user_login = isset( $_POST['user_login'] ) ? $_POST['user_login'] : '';
                                                    ?>
                                                    </label>
                                                    <input type="text" name="user_login" id="user_login" value="<?php echo $user_login; ?>" <?php if(!empty($error_email) || !empty($error_user)): echo 'class="login-error-field"'; endif; ?>>
                                                </p>
                                                <div class="form-row">
                                                    <p class="login-remember">
                                                        <a href="<?php echo esc_url( get_permalink() ); ?>"><?php _e( 'Back to member login', 'buddypress' ); ?></a>
                                                    </p>
                                                    <p class="lostpassword-submit">
                                                        <input type="hidden" name="action" value="reset" />
                                                        <input type="submit" name="submit" class="lostpassword-button"
                                                               value="<?php _e( 'Register', 'buddypress' ); ?>"/>
                                                    </p>
                                                </div>
                                            </form>
                                            
                                            <?php endif; ?>
                                    <?php    
									} else {
										//show login
										echo '<h2>'.__( 'Member login','buddypress').'</h2>';
										$bottom_message = '<a href="'.wp_lostpassword_url().'">'.__( 'Forgot your password?','buddypress') .'</a><br>';
										$bottom_message .= __( 'Are you a member but haven’t yet registered on our portal?','example') .' <a href="'. esc_url( get_permalink() ).'?register=true">'. __( 'Register now!','example').'</a>';
										if( function_exists('bp_is_active') ) {
											$redirect_url = home_url();
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