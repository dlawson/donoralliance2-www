<?php 

$args = array(
	'theme_location'  => 'link-submit-to-the-quilt',
	'container'       => false, 
	'container_id'    => false,
	'menu_class'      => 'menu-link menu-link-submit-to-the-quilt', 
	'echo'            => true,
	'link_before'     => '<span>',
	'link_after'      => '</span>',

);
wp_nav_menu( $args );
