<?php
/*
Template Name: Summit
*/
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
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=PT+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="http://milkandpixels.com/summit.css" media="screen" />
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
	     	<div class="inner">
  			<div class="right-nav">
						<a href="http://nationswell.com">NationSwell.com</a>
						<a href="https://www.facebook.com/nationswell" target="_blank"><i class="fa fa-facebook"></i></a>
						<a href="https://twitter.com/nationswell" target="_blank"><i class="fa fa-twitter"></i></a>
					</div>
					<a href="http://nationswell.com/nationswell-council">NationSwellCouncil.com</a>
	     	</div>
      </header>
    <div id="content">
<a id="top"></a>
<?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<section class="fullscreen" id="landing">
	<div class="overlay" style="background-image:url(<?php echo $feat_image; ?>);"></div>
		<div class="logo-content">
			<h1 class="logo">Summit on Service</h1>
      <a href="#" class="btn red lightbox-trigger"><span>Request Invitation</span></a>
      <a href="https://www.eventbrite.com/e/nationswell-summit-on-service-tickets-18025091534" class="btn red" target="_blank"><span>Register Now</span></a>
		</div>
	<div class="content-holder">
		<div class="photo-strips">
			<div class="photos">
				<img src="<?php bloginfo('template_directory'); ?>/img/summit/nssummit_introphoto1.png" />
				<img src="<?php bloginfo('template_directory'); ?>/img/summit/nssummit_introphoto2.png" />
				<img src="<?php bloginfo('template_directory'); ?>/img/summit/nssummit_introphoto3.png" />
			</div>
			<h3>America's Premier, Invitation-Only Conference Dedicated to Elevating Innovations That Address the Nation's Most Critical Issues.</h3>
		</div>
	</div>
</section>
<section id="about">
	<div class="inner">
		<h6>About the Summit</h6>
		<h4>Less Talk, More Action</h4>
		<p>Participants roll up their sleeves and work side-by-side to advance innovative solutions that:</p>
		<ul class="benefits">
			<li>
				<div class="icon"><img src="<?php bloginfo('template_directory'); ?>/img/summit/bridge_icon.png" /></div>
				<span class="title">Bridge the <br />Opportunity Divide</span>
			</li>
			<li>
				<div class="icon"><img src="<?php bloginfo('template_directory'); ?>/img/summit/flag_icon.png" /></div>
				<span class="title">Advance <br />National Service</span>
			</li>
			<li>
				<div class="icon"><img src="<?php bloginfo('template_directory'); ?>/img/summit/government_icon.png" /></div>
				<span class="title">Make <br />Government Work</span>
			</li>
			<li>
				<div class="icon"><img src="<?php bloginfo('template_directory'); ?>/img/summit/handleaf_icon.png" /></div>
				<span class="title">Preserve <br />Our Environment</span>
			</li>
		</ul>
	</div>
</section>
<section id="featuring">
	<div class="columns feature-set">
		<div class="left half feature-image">
			<img src="<?php bloginfo('template_directory'); ?>/img/summit/people.jpg" />
		</div>
		<div class="right half bullets">
			<div class="inside">
			<h4>Featuring:</h4>
			<p>350+ of the country’s most prominent leaders, innovators, and influencers across industry</p>
	<p>Panel discussions, awards and performances</p>
	<p>Breakout discussions with <a href="#allstars">AllStars</a></p>
	<p>Digital media showcasing mini-documentaries featuring AllStars</p>
	<p>Delicious food throughout and a cocktail reception in the evening</p>
			</div>
		</div>
	</div>
	<div class="allstars">
		<div class="inner">
			<div class="photo-strips">
				<div class="copy columns">
					<div class="left half">
						<h3>Meet the <br />2015 NationSwell <br />AllStars</h3>
						<p>in partnership with</p>
						<img src="<?php bloginfo('template_directory'); ?>/img/summit/nbc-logo.png" />
					</div>
					<div class="right half" id="allstars">
						<p>We’re partnering with NBCUniversal to support the greatest innovators who are tackling some of the nation’s most critical issues. Meet the newest NationSwell AllStars at the Summit and hear how they are encouraging advancements in education and environmental sustainability, making government work better for its citizens, engaging people in national service, advancing the American dream, and supporting our veterans.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section id="benefits">
  <div class="inner">
  	<h6>Summit Speakers</h6>
  	<?php if(get_field('speakers')): ?>
  	 
  		<ul class="member-list">
  	 
  		<?php while(has_sub_field('speakers')): ?>
  		<li>
  			<?php $image = get_sub_field('image'); ?>
  			<div class="image-container">
    			<img src="<?php echo $image['sizes']['member-thumb']; ?>" alt="<?php echo $image['alt']; ?>" />
  			</div>
        <div class="credits">
    			<h6><?php the_sub_field('name'); ?></h6>
    			<p><?php the_sub_field('title'); ?></p>
  			</div>
  		</li>
  	 
  		<?php endwhile; ?>
  	 
  		</ul>
  	 
  	<?php endif; ?>
  	<span class="more">and many more</span>
	</div>
</section>
<section id="schedule">
	<div class="inner">
		<h6>Summit Schedule</h6>
		<h4>Tuesday, November 10, 2015</h4>
  	<?php if(get_field('schedule')): ?>
  	 
  		<ul class="schedule-itemized">
  	 
  		<?php while(has_sub_field('schedule')): ?>
  		<li><span class="timeslot"><?php the_sub_field('time'); ?></span><span class="item-name"><?php the_sub_field('name_of_scheduled_item'); ?></span></li>
  	 
  		<?php endwhile; ?>
  	 
  		</ul>
  	<?php endif; ?>
		<i>Summit schedule is tentative and subject to change.</i>
	</div>
</section>
<section id="sponsors">
	<div class="inner">
		<h6>Summit Sponsors</h6>
		<h4>Special Thanks to Our Sponsors</h4>
  	<?php if(get_field('sponsors')): ?>
  	 
  		<ul class="sponsor-list">
  	 
  		<?php while(has_sub_field('sponsors')): ?>
  		<li><img src="<?php the_sub_field('logo'); ?>" /></li>
  	 
  		<?php endwhile; ?>
  	 
  		</ul>
  	<?php endif; ?>
	</div>
</section>
<section id="footer">
  <div class="inner">
	  <h1 class="dark-logo">Summit on Service</h1>
	  <a href="#" class="btn red lightbox-trigger"><span>Request Invitation</span></a>
    <a href="https://www.eventbrite.com/e/nationswell-summit-on-service-tickets-18025091534" class="btn red" target="_blank"><span>Register Now</span></a>
    <div class="copyright">
      &copy;<?php echo date('Y'); ?> NationSwell. All rights reserved.<br />
      <span class="site-design">Carefully crafted by <a href="http://milkandpixels.com" target="_blank">Milk & Pixels</a></span>
    </div>
  </div>
</section>

		</div>
		<!--</END CONTENT>-->

</div>
<!--</END WRAPPER-->		
<div id="lightbox">
	<div class="content">
		<h4>Request an Invitation to the 2015 NationSwell</h4>
		<img src="<?php bloginfo('template_directory'); ?>/img/summit-on-service.png" class="graphic" />
		<?php gravity_form(2, false, false, false, '', true, 12); ?>
	</div>
</div>
		<?php wp_footer(); ?>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script>
        window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/jquery-1.8.3.min.js"><\/script>')
        </script>
        <script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/js/plugins.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/js/main.js"></script>
  <script>
  $(document).ready(function() {
    $('.lightbox-trigger').on('click', function(e){
	    e.preventDefault();
	    $('#lightbox').addClass('show');
    });

		$('#lightbox').click(function(e) {
		  if ( $(e.target).closest('#lightbox .content').length === 0 ) {
		    $('#lightbox').removeClass('show');
		  }
		});
		
    if ($(window).width() < 500) { $('meta[name=viewport]').attr('content','width=500'); }
  });
  </script>
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