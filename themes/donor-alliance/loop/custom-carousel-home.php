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

$args = array(
	'post_type' => array('donor', 'recipient'),
	'meta_key' => 'da-donor-recipient-featured-carousel',
	'meta_value' => true,
);
query_posts($args);

if (have_posts()) : ?>
	<ul>
	<?php while (have_posts()) : the_post(); ?>
		<li><?php cfct_template_file('content', 'custom-carousel-home'); ?></li>
	<?php endwhile; ?>
	</ul>
<?php endif;
wp_reset_query();