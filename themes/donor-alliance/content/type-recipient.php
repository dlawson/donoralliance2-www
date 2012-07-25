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

$story_detail = lrxd_get_post_meta('story-detail', 'donor-recipient');

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ): ?>
		<div class="photo-container">
			<?php cfct_misc('flash-photo-interior') ?>
		</div>
	<?php endif ?>
	<h1 class="title"><?php echo da_possessify_name( get_the_title($post->ID) ); ?> Story</h1>
	<?php if ($story_detail): ?>
		<h2 class="subtitle"><?php echo $story_detail; ?></h2>
	<?php endif ?>
	<div class="content">
		<?php the_content(); ?>
	</div>
	<?php echo DA_BTN_SHARE_YOUR_STORY; ?>
</article>