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

$title = get_the_title($post->ID);
$link = get_post_meta($post->ID, 'da-homepage-callout-link', true);
$content = get_the_content();

$link = ($link) ? $link : '#';

?>
<h2 class="title"><a href="<?php echo $link; ?>"><?php echo $title; ?></a></h2>
<div class="content">
	<?php echo $content; ?>
</div>
