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

?>


<a href="<?php echo da_get_site_url().DA_ARCHIVE_URL_DONORS; ?>" class="stories stories-donor imr imr-stories-donor">Donor Stories</a>
<a href="<?php echo da_get_site_url().DA_ARCHIVE_URL_RECIPIENTS; ?>" class="stories stories-recipient imr imr-stories-recipient">Recipient Stories</a>

<?php
echo DA_BTN_SHARE_YOUR_STORY;
get_footer();