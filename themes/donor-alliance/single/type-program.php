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

$has_siderail = false;

if (ICL_LANGUAGE_CODE == 'en') {
	$dd_args = array(
		'post_type'	=> 'program',
		'name' => 'donor-dash',
	);
	$dd_query = new WP_Query($dd_args);
	$dd_container = $dd_query->get_posts();
	$dd = $dd_container[0];




	$content_class = 'col-abc';

	$valid_dd_ids = array($post->ID, $post->post_parent);


	if (in_array($dd->ID, $valid_dd_ids )) {
		$has_siderail = true;
		$content_class = 'col-bc';
		
		$args = array(
			'container'     => 'nav', 
			'container_id'	=> 'nav-siderail',
			'menu' 			=> 'section-donor-dash',
			'menu_class'    => 'nav nav-donor-dash', 
			'echo'			=> false,
		);
		$siderail = wp_nav_menu( $args );
	}

}










get_header(); ?>
	<?php if ($has_siderail): ?>
		<div class="col col-a">
			<?php echo $siderail;  ?>
		</div>		
	<?php endif ?>
	<div class="col <?php echo $content_class ?>">
		<?php cfct_loop(); ?>
	</div>
<?php get_footer(); ?>