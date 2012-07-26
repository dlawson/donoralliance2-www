<?php
function da_register_custom_post_types() {

	/**
	 * Register a custom post type
	 * 
	 * Supplied is a "reasonable" list of defaults
	 * @see register_post_type for full list of options for register_post_type
	 * @see add_post_type_support for full descriptions of 'supports' options
	 * @see get_post_type_capabilities for full list of available fine grained capabilities that are supported
	 */
	define('DA_CPT_REWRITE_EVENT', 'events');
	

	/**
	 * Donor Story
	 */
	
	$args = array(
		'labels' => array(
			'name' => __('Donor Stories', 'da-admin'),
			'singular_name' => __('Donor Story', 'da-admin')
		),
		'description' => __('Donor success stories', 'da-admin'),
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'donors'),
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
		),
		'taxonomies' => array(
			'post_tag',
		),
		'capability_type' => 'post',
	);
	$cpt_args['donor'] = $args;


	/**
	 * Recipient Story
	 */
	
	$args = array(
		'labels' => array(
			'name' => __('Recipient Stories', 'da-admin'),
			'singular_name' => __('Recipient Story', 'da-admin')
		),
		'description' => __('Recipient success stories', 'da-admin'),
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'recipients'),
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
		),
		'taxonomies' => array(
			'post_tag',
		),
		'capability_type' => 'post',
	);
	$cpt_args['recipient'] = $args;
	
	
	/**
	 * Volunteer Story
	 */
	
	$args = array(
		'labels' => array(
			'name' => __('Volunteer Stories', 'da-admin'),
			'singular_name' => __('Volunteer Story', 'da-admin')
		),
		'description' => __('Volunteer success stories', 'da-admin'),
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'volunteers'),
		'supports' => array(
			'title',
			'editor',
		),
		'taxonomies' => array(
			'post_tag',
		),
		'capability_type' => 'post',
	);
	$cpt_args['volunteer'] = $args;
	
	
	/**
	 * Event
	 */
	
	$args = array(
		'labels' => array(
			'name' => __('Events', 'da-admin'),
			'singular_name' => __('Event', 'da-admin')
		),
		'description' => __('Donor Alliance Calander Events', 'da-admin'),
		'public' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'hierarchical' => false,
		'rewrite' => array('slug'=>DA_CPT_REWRITE_EVENT),
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
		),
		'taxonomies' => array(
			'post_tag',
		),
		'capability_type' => 'post',
	);
	$cpt_args['event'] = $args;
	
	
	/**
	 * Program
	 */
	
	$args = array(
		'labels' => array(
			'name' => __('Programs', 'da-admin'),
			'singular_name' => __('Program', 'da-admin')
		),
		'description' => __('Donor Alliance Programs', 'da-admin'),
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'has_archive' => true,
		'hierarchical' => true,
		'rewrite' => array('slug' => 'programs'),
		'supports' => array(
			'title',
			'editor',
			'page-attributes',
			'thumbnail',
		),
		'taxonomies' => array(
			'post_tag',
		),
		'capability_type' => 'page',
	);
	
	$cpt_args['program'] = $args;
	
	/**
	 * News & Press
	 */
	
	$args = array(
		'labels' => array(
			'name' => __('News Items', 'da-admin'),
			'singular_name' => __('News Item', 'da-admin')
		),
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'news-press'),
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
		),
		'taxonomies' => array(
			'post_tag',
		),
		'capability_type' => 'post',
	);
	$cpt_args['news'] = $args;
	
	
	/**
	 * Quilt Square
	 */
	
	$args = array(
		'labels' => array(
			'name' => __('Quilt Squares', 'da-admin'),
			'singular_name' => __('Quilt Square', 'da-admin')
		),
		'description' => __('Images of submitted quilt squares for the virtual quilt', 'da-admin'),
		'public' => true,
		'exclude_from_search' => true,
		'show_ui' => true,
		'has_archive' => false,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'quilt'),
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
		),
		'capability_type' => 'post',
	);
	$cpt_args['quilt'] = $args;	
	

	/**
	 * Wall Of Honor
	 */
	
	$args = array(
		'labels' => array(
			'name' => __('Wall Of Honor', 'da-admin'),
			'singular_name' => __('Wall Of Honor', 'da-admin')
		),
		'public' => true,
		'exclude_from_search' => true,
		'show_ui' => true,
		'has_archive' => false,
		'hierarchical' => false,
		'supports' => array(
			'title',
		),
		'capability_type' => 'post',
	);
	$cpt_args['wall-of-honor'] = $args;


	/**
	 * Register
	 */

	foreach ($cpt_args as $cpt_slug => $this_cpt_args) {
		register_post_type($cpt_slug, $this_cpt_args);
	}
	
	
}
add_action('init', 'da_register_custom_post_types');


/**
 * Post Type Properties
 */

/* Event */
// Change the "Scheduled for" text on Event post types changing the translation
// http://blog.ftwr.co.uk/archives/2010/01/02/mangling-strings-for-fun-and-profit/
function da_event_modify_published_text($translation, $text, $domain) {
        global $post;
    if ($post->post_type == 'event') {
        $translations = &get_translations_for_domain( $domain);
        if ( $text == 'Scheduled for: <b>%1$s</b>') {
            return $translations->translate( 'Event Date: <b>%1$s</b>' );
        }
        if ( $text == 'Published on: <b>%1$s</b>') {
            return $translations->translate( 'Event Date: <b>%1$s</b>' );
        }
        if ( $text == 'Publish <b>immediately</b>') {
            return $translations->translate( 'Event Date: <b>%1$s</b>' );
        }
    }
    return $translation;
}
add_filter('gettext', 'da_event_modify_published_text', 10, 4);

// Enable Wordpress to display scheduled posts
function da_enable_scheduled_posts($posts) {
   	global $wp_query, $wpdb, $post;
	if ( $post->post_type == 'event' ) {
		if( is_single() && $wp_query->post_count == 0 ) { $posts = $wpdb->get_results($wp_query->request); }
	}
   return $posts;
}
add_filter('the_posts', 'da_enable_scheduled_posts');