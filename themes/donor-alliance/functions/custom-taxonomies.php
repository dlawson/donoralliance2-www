<?php 
	// Services
	$labels = array(
		'name' => _x( 'Types', 'taxonomy general name' ),
		'singular_name' => _x( 'Type', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Wall Of Honor Types' ),
		'all_items' => __( 'All Types' ),
		'edit_item' => __( 'Edit Type' ), 
		'update_item' => __( 'Update Type' ),
		'add_new_item' => __( 'Add New Type' ),
		'new_item_name' => __( 'New WOH Type' ),
		'menu_name' => __( 'WOH Types' ),
	); 	
	register_taxonomy(
		'wall-of-honor-type',
		array('wall-of-honor'), 
		array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
	));