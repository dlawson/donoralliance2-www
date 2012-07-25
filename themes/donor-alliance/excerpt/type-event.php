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

$event_date = lrxd_get_post_meta('date');
?>
<article <?php post_class(); ?>>
	<div class="header">
		<a href="<?php the_permalink() ?>"><time class="datetime" datetime="<?php echo get_the_date('Y-m-dTH:i'); ?>"><?php echo get_the_date('n.j.y'); ?></time> &mdash; <h1 class="title"><?php the_title(); ?></h1></a>
	</div>
	
	<div class="content">
		<?php the_excerpt(); ?>
	</div>
</article>
