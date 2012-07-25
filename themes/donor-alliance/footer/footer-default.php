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
							<p class="copyright"><?php echo cfct_get_option('cfct_copyright'); ?></p>
							<?php
							$args = array(
								'theme_location'  => 'nav-footer',
								// 'menu'            => ,  	
								'container'       => 'nav', 
								// 'container_class' => 'menu-{menu slug}-container', 
								'container_id'    => 'nav-footer',
								'menu_class'      => 'nav', 
								// 'menu_id'         => ,
								'echo'            => true,
								// 'fallback_cb'     => 'wp_page_menu',
								// 'before'          => ,
								// 'after'           => ,
								// 'link_before'     => ,
								// 'link_after'      => ,
								// 'items_wrap'      => '<ul id=\"%1$s\" class=\"%2$s\">%3$s</ul>',
								// 'depth'           => 0,
								// 'walker'          => 
							);
							wp_nav_menu( $args );
							cfct_form('newsletter');
						?>
					</div>
				</div>
			</div>
		</footer>	
		<?php wp_footer(); ?>
	</div><!-- #page -->
</body>

</html>