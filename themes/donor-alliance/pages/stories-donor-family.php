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

while ( have_posts() ) : the_post();
	$content = get_the_content();
	$section_title = get_the_title($post->ID);
endwhile;

?>
<section class="page-archive-donor">
	<h1 class="title"><?php echo $section_title; ?></h1>
	<?php if ($content): ?>
		<div class="page-content">
			<?php echo $content; ?>
		</div>		
	<?php endif ?>
	<?php echo DA_BTN_SHARE_YOUR_STORY; ?>
</section>	

<div class="archive post-type-archive-donor">
	<?php cfct_template_file('loop', 'custom-grid-donor'); ?>
</div>
<?php
get_footer();
