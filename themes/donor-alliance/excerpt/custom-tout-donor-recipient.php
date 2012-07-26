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

$story_detail = lrxd_get_post_meta('story-detail', 'donor-recipient');
$content = lrxd_get_post_meta('aside', 'donor-recipient');

$story_name = get_the_title($post->ID);
$read_more_format = _x('Read %s\'s Story', 'Read More link for Donor/Recipient list item.  "Read Larry\'s Story"', 'da');
$read_more = sprintf($read_more_format, $story_name);

?>
<div <?php post_class('post-tout tout-donor-recipient'); ?>>
	<?php if ( has_post_thumbnail() ): ?>
		<div class="tout-image">
			<?php lrxd_the_post_thumbnail('donor-recipient-tout'); ?>
		</div>
	<?php endif ?>
	<div class="header">
		<a href="<?php the_permalink() ?>"><h2 class="title"><?php the_title(); ?></h2>
		<?php if ($story_detail): ?>
			&ndash; <h3 class="subtitle"><?php echo $story_detail; ?></h3>
		<?php endif; ?></a>
	</div>
	
	<div class="content">
		<?php echo $content; ?>
	</div>
	<a href="<?php the_permalink(); ?>" class="more"><?php echo $read_more ?></a>
</div>