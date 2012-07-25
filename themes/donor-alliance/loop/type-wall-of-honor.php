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


$woh_types = get_terms('wall-of-honor-type');
foreach ($woh_types as $type) {
	$args = array(
		'post_type' => 'wall-of-honor',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'asc',
		'tax_query' => array(
			array(
				'taxonomy' => 'wall-of-honor-type',
				'field' => 'slug',
				'terms' => $type->slug,
				'operator' => 'IN',
			),
		),
	);
	query_posts($args);	
	if (have_posts()) :
		$count = 1;
	
		?>
		<section id="wall-of-honor-<?php echo $type->slug; ?>" class="section-wall-of-honor">
			<h1 class="section-title"><?php echo $type->name; ?>s</h1>
			<ul class="clearfix">
			<?php while (have_posts()) : the_post(); ?>
				<li><?php cfct_excerpt(); ?></li>
			<?php endwhile; ?>				
			</ul>

		</section>
		<?php
	endif;
	wp_reset_query();
}