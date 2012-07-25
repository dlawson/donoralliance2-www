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
	'post_type' => array('donor'),
	'order' => 'ASC',
);
query_posts($args);

if (have_posts()) : $count = 0; ?>
	<div class="touts">
		<div class="tout-row clearfix">
			<?php while (have_posts()) : the_post(); $new_row = (3%$count++); ?>
				<?php cfct_template_file('excerpt', 'custom-tout-donor-recipient'); ?>
				<?php if ($new_row): ?>
					</div>
					<div class="tout-row clearfix">
				<?php endif ?>
			<?php endwhile; ?>
		</div>
	</div>
<?php endif;
wp_reset_query();