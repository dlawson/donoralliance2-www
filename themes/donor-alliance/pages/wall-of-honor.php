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

$section_title = _x('Wall Of Honor', 'Wall Of Honor page - section title text', 'da');
$btn_back_to_the_form = _x('Back To The Form', 'Back To The Form link text', $domain = 'da');
?>
	
<section id="wall-of-honor">
	<h1 class="section-title"><?php echo $section_title; ?></h1>
	<?php cfct_template_file('loop', 'type-wall-of-honor'); ?>
	<div class="clearfix">
		<a href="<?php echo da_get_page_url('wall-of-honor-form'); ?>" class="btn btn-back-to-the-form"><span><?php echo $btn_back_to_the_form; ?></span></a>
	</div>
</section>
	
<?php get_footer(); ?>