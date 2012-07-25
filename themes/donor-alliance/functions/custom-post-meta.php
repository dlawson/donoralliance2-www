<?php
function da_create_post_meta() {
	if (lrxd_plugin_exists('RW_Meta_Box')) {
		
		
		/**
		 * Page
		 */
		
		$post_type = 'page';
		$prefix = LRXD_THEME_PREFIX.'-'.$post_type.'-';
		$meta_boxes[] = array(
		    'id' => 'page-info',
		    'title' => 'Page Info', 
		    'pages' => array($post_type), 
		    'context' => 'normal', 
		    'priority' => 'high',
		    'fields' => array(
				array(
					'name' => 'Featured Link Text',          
					'id' => $prefix . 'featured-link-text',      
					'type' => 'text',               
				),
				array(
					'name' => 'Featured Link Address',          
					'id' => $prefix . 'featured-link-href',      
					'type' => 'text',               
				),
				array(
					'name' => 'Open Featured Link in new window',          
					'id' => $prefix . 'featured-link-new-window',      
					'type' => 'checkbox',               
				),
		    ),
		);	

	
		/**
		 * Donor / Recipient
		 */
		
		$prefix = LRXD_THEME_PREFIX.'-donor-recipient-';
		$meta_boxes[] = array(
		    'id' => 'story-info',
		    'title' => 'Story Info', 
		    'pages' => array('donor', 'recipient'), 
		    'context' => 'normal', 
		    'priority' => 'high',
		    'fields' => array(
				array(
					'name' => 'Gender',
					'id' => $prefix . 'gender',
					'type' => 'radio',              
					'options' => array(             
						'm' => 'Male',
						'f' => 'Female'
					),
				),
				array(
					'name' => 'Story Detail',          // Field name
					'desc' => 'Short description of donor/recipient.', // Field description, optional
					'id' => $prefix . 'story-detail',      // Field id, i.e. the meta key
					'type' => 'text',               // Field type: text box
				),
				array(
					'name' => 'Story Aside',
					'desc' => 'Short snippet for Carousel and Tout items.', // Field description, optional
					'id' => $prefix . 'aside',
					'type' => 'wysiwyg',
				),
		    ),
		);

		$meta_boxes[] = array(
		    'id' => 'featured-meta',
		    'title' => 'Featured', 
		    'pages' => array('donor', 'recipient'), 
		    'context' => 'side', 
		    'priority' => 'high',
		    'fields' => array(
				array(
					'name' => 'Feature on the homepage',          // Field name
					'id' => $prefix . 'featured-carousel',      // Field id, i.e. the meta key
					'type' => 'checkbox',               // Field type: text box
				),
		    ),
		);
		

		foreach ($meta_boxes as $meta_box) {
		    new RW_Meta_Box($meta_box);
		}
	}
}
add_action( 'init', 'da_create_post_meta' );