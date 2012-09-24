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
global $wp_query;
global $da_months;

$query_vars = $wp_query->query_vars;
$title = _x('Events', 'Events page.  Section title.', 'da');
$archive_year = get_query_var('year');
$archive_month = get_query_var('monthnum');

if ($archive_year > 0) {
	$title = $query_vars['year'];

	if ($archive_month > 0) {
		$title = $da_months[$query_vars['monthnum']].' '.$title;
	}
}


get_header();
?>
<h1 class="section-title"><?php echo $title; ?></h1>

<div class="col col-ab">
	<?php
		cfct_loop();
		// cfct_misc('nav-posts');
	?>
</div>
<div class="col col-c">
	<?php get_sidebar(); ?>
</div>
<?php get_footer();