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

get_header();

global $post;

$ancestors = get_post_ancestors($post->ID);


if (count($ancestors) > 0) {
		// This is a Child Level Page.  Use Parent post to determine which nav to get.
		$parent = get_post($post->post_parent);
		$nav_name = $parent->post_title;
		$nav_slug = $parent->post_name;
}
else {
		// This is a Parent Level Page.  Use This post to determine which nav to get.
		$nav_name = $post->post_title;
		$nav_slug = $post->post_name;
}

$args = array(
	'container'     => 'nav', 
	'container_id'	=> 'nav-siderail',
	'fallback_cb'	=> false,
	'menu' 			=> 'section-'.$nav_slug,
	'menu_class'    => 'nav nav-'.$nav_slug, 
	'echo'			=> false,
);
$sidenav = wp_nav_menu( $args );
?>


<div class="col col-a">
	<?php echo $sidenav; ?>
</div>

<div class="col col-bc">
	<?php cfct_loop(); ?>
</div>


<?php get_footer();
