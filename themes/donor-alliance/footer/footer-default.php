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


?>
			</div><!-- .in -->
		</div><!-- #main -->
		<footer id="footer">
			<div class="in">
				<div id="footer-interior">
					<div class="body">
							<p class="copyright">&copy;2012 Donor Alliance, Inc. <?php _e('All Rights Reserved', 'da'); ?></p>
							<?php
							$args = array(
								'theme_location'  => 'nav-footer',
								'container'       => 'nav', 
								'container_id'    => 'nav-footer',
								'menu_class'      => 'nav', 
								'echo'            => true,
							);
							wp_nav_menu( $args );

							// Only display Newsletter Signup for English
							if (ICL_LANGUAGE_CODE == 'en') {
								cfct_form('newsletter');
							}
							
						?>
					</div>
				</div>
			</div>
		</footer>	
		<?php wp_footer(); ?>
	</div><!-- #page -->
</body>

</html>