<?php 

global $is_IE;



/**
 * Theme Setup
 */
function cfct_theme_setup() {
	if(!is_admin()) {
		
		// Enqueue Styles
		wp_enqueue_style('css_main_fonts', get_bloginfo('template_url') . '/assets/main/css/fonts.css', array(), THEME_VERSION);
		wp_enqueue_style('css_main_base', get_bloginfo('template_url') . '/assets/main/css/base.css', array(), THEME_VERSION);
		wp_enqueue_style('css_main_typography', get_bloginfo('template_url') . '/assets/main/css/typography.css', array(), THEME_VERSION);
		wp_enqueue_style('css_main_utility', get_bloginfo('template_url') . '/assets/main/css/utility.css', array(), THEME_VERSION);
		wp_enqueue_style('css_main_grid', get_bloginfo('template_url') . '/assets/main/css/grid.css', array(), THEME_VERSION);
		wp_enqueue_style('css_main_structure', get_bloginfo('template_url') . '/assets/main/css/structure.css', array(), THEME_VERSION);
		wp_enqueue_style('css_main_forms', get_bloginfo('template_url') . '/assets/main/css/forms.css', array(), THEME_VERSION);
		wp_enqueue_style('css_main_content', get_bloginfo('template_url') . '/assets/main/css/content.css', array(), THEME_VERSION);
		wp_enqueue_style('css_main_templates', get_bloginfo('template_url') . '/assets/main/css/templates.css', array(), THEME_VERSION);
		if (!da_is_english()) {
			wp_enqueue_style('css_main_lang_'.ICL_LANGUAGE_CODE, get_bloginfo('template_url') . '/assets/lang-'.ICL_LANGUAGE_CODE.'/css/main.css', array(), THEME_VERSION);
		}

		// Enqueue Scripts
		wp_enqueue_script('modernizr', get_bloginfo('template_url') . '/assets/main/js/lib/modernizr.js', array(), THEME_VERSION);
		wp_enqueue_script('js_main_jquery_cycle', get_bloginfo('template_url') . '/assets/main/js/lib/jquery-cycle.js', array('jquery'), THEME_VERSION);
		wp_enqueue_script('js_main_jquery_swfobject', get_bloginfo('template_url') . '/assets/main/js/lib/jquery-swfobject.js', array('jquery'), THEME_VERSION);
		wp_enqueue_script('js_main_jquery_watermark', get_bloginfo('template_url') . '/assets/main/js/lib/jquery-watermark.js', array('jquery'), THEME_VERSION);
		wp_enqueue_script('js_main_jquery_columnizer', get_bloginfo('template_url') . '/assets/main/js/lib/jquery-columnizer.js', array('jquery'), THEME_VERSION);
		wp_enqueue_script('js_main_script', get_bloginfo('template_url') . '/assets/main/js/script.js', array('jquery'), THEME_VERSION);

		// Add css transitions to IE
		if ($is_IE) {
			// wp_enqueue_script('js_main_sandpaper_eventhelpers', get_bloginfo('template_url') . '/assets/main/js/lib/css-sandpaper/EventHelpers.js', array(), THEME_VERSION);
			// wp_enqueue_script('js_main_sandpaper_cssquery_p', get_bloginfo('template_url') . '/assets/main/js/lib/css-sandpaper/cssQuery-p.js', array(), THEME_VERSION);
			// wp_enqueue_script('js_main_sandpaper_sylvester', get_bloginfo('template_url') . '/assets/main/js/lib/css-sandpaper/sylvester.js', array(), THEME_VERSION);
			// wp_enqueue_script('js_main_sandpaper_csssandpaper', get_bloginfo('template_url') . '/assets/main/js/lib/css-sandpaper/cssSandpaper.js', array(), THEME_VERSION);
		}
		
		// Threaded Comments
		if ( is_singular() ) { wp_enqueue_script( 'comment-reply' ); }
	}

}
add_action( 'init', 'cfct_theme_setup' );


/**
 * Actions
 */

// Add CSS3 Pie style block
function da_add_css3pie() {
	cfct_misc('style-css3pie');
}
add_action('wp_head', 'da_add_css3pie');


function da_manipulate_menu_items($items, $menu, $args) {
	
	foreach ($items as $item_key => $item) {
		
		$class_prefix = 'menu-item-'.$item->object.'-';
		
		// If a post type item, get actual slug from post ID.  Otherwise, generate a slug from menu title.
		$menu_item_slug = ($item->type == 'post_type')
			? da_get_post_slug_from_id($item->object_id)
			: lrxd_generate_slug($item->title);
		
		// Build Menu Item Class
		$menu_item_class = $class_prefix.$menu_item_slug;
		
		// Add Class to this menu item
		$items[$item_key]->classes[] = $menu_item_class;
	}
	
	return $items;
}
add_action('wp_get_nav_menu_items', 'da_manipulate_menu_items', 10, 3);



function da_modify_footer() {
	echo cfct_get_option('analytics');
}
add_action('wp_footer', 'da_modify_footer');

