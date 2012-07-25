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

global $wp_query;
$query_vars = $wp_query->query_vars;

if (is_archive()) {
	$args = array(
		'post_type' => 'event',
		'post_status' => 'future',
		'order' => 'ASC',
	);
	
	if (array_key_exists('year', $query_vars)) {
		$args['year'] = $query_vars['year'];
		if (array_key_exists('monthnum', $query_vars)) {
			$args['monthnum'] = $query_vars['monthnum'];
		}
	}
	
	query_posts($args);
}

if (have_posts()) : ?>
	<ol class="posts">
	<?php while (have_posts()) : the_post(); ?>
		<li><?php 
			if (is_archive()) { cfct_excerpt(); } 
			else { cfct_content(); }
		?></li>
	<?php endwhile; ?>
	</ol>
<?php endif;

wp_reset_query();

