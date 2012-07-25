<?php

$post_type = get_query_var('post_type');

$html_before = '<nav id="nav-sub"><div id="nav-sub-interior">';
$html_after = '</div></nav>';

$subnav_args = array(
	'theme_location'  	=> 'nav-sub',
	'container'       	=> false, 
	'menu_class'      	=> 'nav', 
	'echo'           	=> false,
	'walker'			=> new Custom_Walker_Nav_Sub_Menu() // grabs submenu of current page in main menu
);	

$subnav = wp_nav_menu($subnav_args);

// test subnav for nav items
$li_pos = strpos( $subnav, '<li ');

if ( is_front_page() ) {
	// Do Nothing.  No Homepage navigation.
}
elseif ($li_pos > 0) {
	echo $html_before.$subnav.$html_after;
}
else {
	$post_args = array(
		'post_type' => 'page',
	);
	switch ($post_type) {
		
		case 'donor':
		case 'recipient':
			$post_args['name'] = 'submit-a-story';
			
			query_posts($post_args);
			if( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					$subnav = wp_nav_menu($subnav_args);
					// echo $html_before.$subnav.$html_after;

				}
			}
			
			wp_reset_query();
			
			break;
		case 'event':
		case 'program':
			echo $html_before.'<div class="sub-menu">';
			cfct_template_file('loop', 'custom-type-program-nav');
			echo '</div>'.$html_after;
			break;
	}
}
