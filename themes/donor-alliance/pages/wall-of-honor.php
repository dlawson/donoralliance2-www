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

get_header(); ?>

	
	
	<section id="wall-of-honor">
		<h1 class="section-title">Wall Of Honor</h1>
		<?php cfct_template_file('loop', 'type-wall-of-honor'); ?>
		<div class="clearfix">
			<a href="<?php echo da_get_page_url('wall-of-honor-form'); ?>" class="btn btn-back-to-the-form"><span>Back To The Form</span></a>
		</div>
	</section>
	
<?php get_footer(); ?>