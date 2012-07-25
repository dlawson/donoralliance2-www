<?php 

/**
 * Filters
 */

// Customize Theme Settings Form Titles
function lrxd_get_theme_settings_title ($title) {
	$title = 'Donor Alliance Theme Settings';
	return $title;
}
add_filter('cfct_admin_settings_title', 'lrxd_get_theme_settings_title');
add_filter('cfct_admin_settings_form_title', 'lrxd_get_theme_settings_title');

// Customize Theme Settings title in wp-admin side menu
function lrxd_get_theme_settings_title_menu ($title) {
	$title = 'DA Theme Settings';
	return $title;
}
add_filter('cfct_admin_settings_menu','lrxd_get_theme_settings_title_menu');


// Customize Theme Setting Options
function lrxd_get_theme_settings_options ($cfct_options) {

	// clear default settings array
	$cfct_options = array();
	
	// Rebuild settins array
	$cfct_options['base-settings'] = array(
		'label' => 'Base Settings',
		//This is a callback, use cfct_options_blank to display nothing
		'description' => 'Settings for Donor Alliance\'s social media',
		'fields' => array(
			'copyright' => array(
				'type' => 'text',
				'label' => __('Copyright / legal footer text', 'da'),
				'name' => 'copyright',
				'class' => 'cfct-text-long',
			),
			'analytics' => array(
				'type' => 'textarea',
				'label' => __('Analytics Code', 'da'),
				'name' => 'analytics',
				'class' => 'cfct-text-long',
			),
		),
	);
	$cfct_options['home-buckets'] = array(
		'label' => 'Homepage Content Buckets',
		//This is a callback, use cfct_options_blank to display nothing
		// 'description' => 'Settings for Donor Alliance\'s social media',
		'fields' => array(
			'bucket-title-left' => array(
				'type' => 'text',
				'label' => __('Left Bucket Title', 'da'),
				'name' => 'bucket-title-left',
				'class' => 'cfct-text-long',
			),
			'bucket-link-left' => array(
				'type' => 'text',
				'label' => __('Left Bucket Link', 'da'),
				'name' => 'bucket-link-left',
				'class' => 'cfct-text-long',
			),
			'bucket-content-left' => array(
				'type' => 'textarea',
				'label' => __('Left Bucket Text', 'da'),
				'name' => 'bucket-content-left',
				'class' => 'cfct-text-long',
			),
			
			'bucket-title-middle' => array(
				'type' => 'text',
				'label' => __('Middle Bucket Title', 'da'),
				'name' => 'bucket-title-middle',
				'class' => 'cfct-text-long',
			),
			'bucket-link-middle' => array(
				'type' => 'text',
				'label' => __('Middle Bucket Link', 'da'),
				'name' => 'bucket-link-middle',
				'class' => 'cfct-text-long',
			),
			'bucket-content-middle' => array(
				'type' => 'textarea',
				'label' => __('Middle Bucket Text', 'da'),
				'name' => 'bucket-content-middle',
				'class' => 'cfct-text-long',
			),
			
			'bucket-title-right' => array(
				'type' => 'text',
				'label' => __('Right Bucket Title', 'da'),
				'name' => 'bucket-title-right',
				'class' => 'cfct-text-long',
			),
			'bucket-link-right' => array(
				'type' => 'text',
				'label' => __('Right Bucket Link', 'da'),
				'name' => 'bucket-link-right',
				'class' => 'cfct-text-long',
			),
			'bucket-content-right' => array(
				'type' => 'textarea',
				'label' => __('Right Bucket Text', 'da'),
				'name' => 'bucket-content-right',
				'class' => 'cfct-text-long',
			),
		),
	);
	$cfct_options['archive-settings'] = array(
		'label' => 'Archive Settings',
		//This is a callback, use cfct_options_blank to display nothing
		'description' => 'Settings for Donor Alliance\'s social media',
		'fields' => array(
			'donor-intro' => array(
				'type' => 'textarea',
				'label' => __('Donors Intro Copy', 'da'),
				'name' => 'donor-intro',
				'help' => '<br />Introductory text for Donors page',
				'class' => 'cfct-text-long',
			),
			'recipient-intro' => array(
				'type' => 'textarea',
				'label' => __('Recipients Intro Copy', 'da'),
				'name' => 'recipient-intro',
				'help' => '<br />Introductory text for Recipients page',
				'class' => 'cfct-text-long',
			),
		),
	);
	$cfct_options['social'] = array(
		'label' => 'Social Settings',
		//This is a callback, use cfct_options_blank to display nothing
		'description' => 'Settings for Donor Alliance\'s social media',
		'fields' => array(
			'facebook' => array(
				'type' => 'text',
				'label' => __('Facebook Url', 'da'),
				'name' => 'facebook',
				'class' => 'cfct-text-long',
			),
			'twitter' => array(
				'type' => 'text',
				'label' => __('Twitter Url', 'da'),
				'name' => 'twitter',
				'class' => 'cfct-text-long',
			),

		),
	);
	return $cfct_options;

}
add_filter('cfct_options', 'lrxd_get_theme_settings_options');

// Add active state to nav menus
function cfct_additional_classes_menu ( $classes = array(), $menu_item = false ){
	if ( in_array( 'current-menu-item', $menu_item->classes ) ){
		$classes[] = 'active';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'cfct_additional_classes_menu', 10, 2 );

// Augment body classes
function da_additional_classes_body($classes) {
	// Stamp body with ancestor slug
	global $post;
	$this_post_id = $post->ID;
	$ancestors = get_post_ancestors($this_post_id);

	switch ($post->post_type) {
		case 'event':
		case 'program':
			$classes[] = 'ancestor-event-program';
			break;
		case 'donor':
		case 'recipient':
			$classes[] = 'ancestor-our-stories';
			break;
		default:
		
			if (count($ancestors) > 0) {
				$classes[] = 'ancestor-'.da_get_post_slug_from_id($ancestors[0]);
			}
			break;
	}


	
	
	
	
	
	
	$classes[] = 'lang-'.ICL_LANGUAGE_CODE;
	return $classes;
}
add_filter('body_class', 'da_additional_classes_body');


// Augment post classes
function cfct_additional_classes_post($classes) {
	global $post;
	$classes[] = 'post';
	$classes[] = 'post-'.$post->post_type;
	
	// Add Featured Image detection in Post
	if ( has_post_thumbnail() ) {
	    $classes[] = 'has-featured-image';
	}
	return $classes;
}
add_filter('post_class', 'cfct_additional_classes_post');

// Add "Read More" link to Excerpts
function cfct_excerpt_read_more($more) {
	global $post;
	return '&hellip; <a href="'. get_permalink($post->ID) . '" class="more">'.__('Read More', 'da').'</a>';
}
add_filter('excerpt_more', 'cfct_excerpt_read_more');