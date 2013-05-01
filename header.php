<?php
$temp_url = get_bloginfo( 'template_url' );

$theme_options = get_option('theme_options'); 
?>		
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->
	<head>

		<!-- Basic Page Needs
	  ================================================== -->
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php wp_title(''); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		

		<!-- Mobile Specific Metas
	  ================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">		

		<!-- js
	  ================================================== -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Favicons
		================================================== -->
		<link rel="shortcut icon" href="<?php echo $temp_url; ?>/images/favicon.ico">
		<link rel="apple-touch-icon" href="<?php echo $temp_url; ?>/images/apple-touch-icon.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $temp_url; ?>/images/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $temp_url; ?>/images/apple-touch-icon-114x114.png">

		<?php wp_head(); ?>


		<!-- CSS
	  ================================================== -->
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<!--[if gte IE 9]>
	  <style type="text/css">
	    .mainNav .navList li a {
	       filter: none;
	    }
	  </style>
	<![endif]-->
	<!--[if IE 8]>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo $temp_url; ?>/css/ie8.css" />
	  </style>
	<![endif]-->
	<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo $temp_url; ?>/css/ie7.css" />
	  </style>
	<![endif]-->
	</head>
	<body <?php body_class($class); ?> <?php if (is_page()){ ?><?php echo 'id="'. $post->post_name .'-page"'; }?> >
	<?php if(has_nav_menu( "mobile" )): ?>
	    <div class="navbar navbar-inverse navbar-fixed-top">
	      <div class="navbar-inner">
	        <div class="container">
	          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </a>
	          <a class="brand" href="<?php echo home_url( "/" ); ?>"><?php bloginfo( 'name' ) ?></a>
	          <div class="nav-collapse collapse">
<?php 
    wp_nav_menu( array(
        'theme_location'       => 'mobile',
        'depth'      => 0,
        'container'  => false,
        'menu_class' => 'nav',
        'walker' => new BootstrapNavMenuWalker())
    );
?>
	          </div><!--/.nav-collapse -->
	        </div>
	      </div>
	    </div>
	<?php endif; ?>

		<div id="outerWrap" class="container">
			<header id="siteHeader" class="row">
				<hgroup class="span12">
	<?php if(has_nav_menu( "super" )): ?>
					<nav id="superNav"><ul class="nav nav-pills"><?php 
					    wp_nav_menu( array(
					        'theme_location'       => 'super',
					        'depth'      => 1,
					        'container'  => false,
					        'items_wrap' => '%3$s',
					        'walker' => new Unnested_Nav_Walker())
					    );
					?></ul></nav>
	<?php endif; ?>
				<?php if(is_home()): ?>
					<h1 id="siteTitle"><a href="<?php echo home_url( "/" ); ?>"><?php bloginfo( 'name' ) ?></a></h1>
				<?php else: ?>
					<h6 id="siteTitle"><a href="<?php echo home_url( "/" ); ?>"><?php bloginfo( 'name' ) ?></a></h6>
				<?php endif; ?>
	<?php if(has_nav_menu( "main" )): ?>
					<nav id="mainNav"><?php 
					    wp_nav_menu( array(
					        'theme_location'       => 'main',
					        'depth'      => 3,
					        'container'  => false,
					        'menu_class' => 'nav nav-pills',
					        'walker' => new Main_Nav_Walker())
					    );
					?></nav>
	<?php endif; ?>
				</hgroup>
			</header>
	<?php if( is_home() || is_front_page()):
		$args = array(
		'post_type' => 'slide',
		'posts_per_page' => -1,
		'order' => 'ASC',
		'orderby' => 'menu_order',
		'tax_query' => array(array('taxonomy' => 'slideshow', 'field' => 'slug', 'terms' => 'home'))
		);
		$slides = new WP_Query($args);
			if($slides->have_posts()):
	?>
			<div id="homeSlider" class="row">
				<div class="slidewrap span12">
					<ul class="slides">
						<?php

						while ($slides->have_posts()) : $slides->the_post();
						$post_thumbnail_id = get_post_thumbnail_id( $post->ID);
						$post_thumb_arr = wp_get_attachment_image_src( $post_thumbnail_id, 'home-slide' );
						$slide_link = get_post_meta( $post->ID, "slide_url_value", true );
						?>
						<li><?php echo (($slide_link == true) ? "<a>" : ""); ?><div class="slide" style="background-image:url(<?php echo $post_thumb_arr[0]; ?>);"><?php
							the_post_thumbnail( "home-slide" );
							if(get_the_content()){
								 echo "<div class='content'>";
								 the_content();
								 echo "</div>";
							}
						?></div><?php echo (($slide_link == true) ? "</a>" : ""); ?></li>
						<?php endwhile; ?>
						<?php wp_reset_query(); ?> 
					</ul>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>
				<?php if ( function_exists('yoast_breadcrumb') && !is_front_page() ) {
					yoast_breadcrumb("<nav class='breadcrumb'>",'</nav>');
				} ?>
			<div id="torso" class="row">
			<?php if(is_front_page()): ?>
				<div id="middle" class="span12">
			<?php else: ?>
				<div id="middle" class="span7">
			<?php endif; ?>
