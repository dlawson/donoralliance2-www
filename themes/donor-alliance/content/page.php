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

$featured_link_text = lrxd_get_post_meta('featured-link-text');
$featured_link_href = lrxd_get_post_meta('featured-link-href');
$featured_link_new_window = lrxd_get_post_meta('featured-link-new-window');
?>
<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if (has_post_thumbnail() ): ?>
		<div class="photo-container">
			<?php cfct_misc('flash-photo-interior'); ?>
			
			<?php if ($featured_link_text && $featured_link_href): 
				$target_blank = ($featured_link_new_window) 
					? 'target="_blank"'
					: '';
				?>
				<a class="btn btn-featured-link" href="<?php echo $featured_link_href ?>" <?php echo $target_blank; ?>><span><?php echo $featured_link_text ?></span></a>
			<?php endif ?>
		</div>
	<?php endif ?>
	<h1 class="title"><?php the_title(); ?></h1>
	<div class="content">
		<?php the_content(); ?>
	</div>
</section>
