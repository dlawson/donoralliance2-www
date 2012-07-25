<?php

// This file is part of the Carrington JAM Theme for WordPress
// http://carringtontheme.com
//
// Copyright (c) 2008-2010 Crowd Favorite, Ltd. All rights reserved.
// http://crowdfavorite.com
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// **********************************************************************

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
if (CFCT_DEBUG) { cfct_banner(__FILE__); }
global $post;
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?php wp_title( '-', true, 'right' ); echo esc_html( get_bloginfo('name') ); ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=EDGE" />
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php esc_attr(printf( __( '%s latest posts', 'da' ), get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php esc_attr(printf( __( '%s latest comments', 'da' ), get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />

	<?php wp_head(); ?>
	<!--[if lte IE 7]>
		<script src="<?php echo trailingslashit( get_bloginfo('template_url') ) ?>assets/main/js/lib/jquery-ie7.js" type="text/javascript" charset="utf-8"></script>
	<![endif]-->
</head>
<body <?php body_class(); ?>>
	<div id="page">
		<header id="header">
			<div class="in">
				<nav id="nav-aux" class="clearfix">
					<ul class="nav nav-language">
						<li class="en"><a href="/">Eng</a></li>
						<li class="es"><a href="/?lang=es">Esp</a></li>
					</ul>
					<?php
					$args_join = array(
						'theme_location'  => 'nav-aux-join',
						'container'       => false, 
						'menu_class'      => 'nav nav-join', 
						'echo'            => true,
					);
					wp_nav_menu( $args_join );
					?>
					<?php cfct_misc('social-header'); ?>
					
					<?php 
					$args_donor = array(
						'theme_location'  => 'nav-aux-donor',
						'container'       => false, 
						'menu_class'      => 'nav nav-donor', 
						'echo'            => true,
						'walker'          => new Walker_Nav_Menu__Nav_Donor()
					);
					wp_nav_menu( $args_donor );
					?>
				</nav>
			</div>
			<div class="body">
				<h1 id="site-name"><a id="site-logo" href="<?php echo site_url(); ?>" class="imr">Donor Alliance - Organ &amp; Tissue Donation</a></h1>
				<nav id="nav-main" class="clearfix">
					<div id="nav-main-interior">
						<?php
						$args_main = array(
							'theme_location'  	=> 'nav-main',
							'container'       	=> false, 
							'menu_class'      	=> 'nav', 
							'depth'				=> 1,
							'after'				=> '<span class="indicator"></span>',
							'echo'            	=> true,
						);
						wp_nav_menu( $args_main );
						?>						
					</div>
				</nav>
				<?php cfct_misc('nav-header-sub'); ?>
			</div>
		</header>


		<div id="main" role="main">
			<div class="in">