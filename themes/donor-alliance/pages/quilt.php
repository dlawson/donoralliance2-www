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

$quilt_submit = _x('Submit To The Quilt', 'Quilt submission button', 'da');
?>
<div class="col col-abc">
	<div id="quilt">
		
		<?php 
			// Regular loop to add in page content
			cfct_loop();
			
			// Custom loop to add in quilt content
			cfct_template_file('loop', 'custom-quilt'); 
		?>
	</div>
	<div class="clearfix">
		<a href="<?php echo da_get_page_url('submit-to-the-quilt'); ?>" class="btn btn-submit-to-the-quilt"><span><?php echo $quilt_submit; ?></span></a>
	</div>
</div>
<?php get_footer();