<?php 

define('RK_GFID_CONTACT', 1);
define('RK_GFID_NEWSLETTER', 2);

global $lrxd_forms;
$lrxd_forms = array (
	'contact' => 1,
	'coroner-contact' => 5,
	'donor-alliance-aftercare-survey' => 10,
	'rsvp-family-tribute-wyoming-2010' => 8,
	'rsvp-family-tribute-colorado-2011' => 9,
	'funeral-services' => 6,
	'honor-loved-one' => 7,
	'newsletter-form' => 2,
	'newsletter' => 12,
	'submit-to-the-quilt' => 11,
	'submit-a-story' => 3,
	'volunteer-info' => 4,
	'ccathlab' => 33,
	'cechocardiogram' => 32,
	'cnuclear' => 34,
	'cpathology' => 37,
	'cradiology' => 35,
	'icharge' => 17,
	'inurse' => 13,
	'ipastoral' => 18,
	'irespiratory' => 15,
	'iunit' => 16,
	'oanesthesia' => 21,
	'ocharge' => 31,
	'ocirculator' => 20,
	'oscrub' => 19,
	'panesthesia' => 19,
	'pcardiologist' => 22,
	'pemergency' => 28,
	'phospitalist' => 27,
	'pintensivist' => 25,
	'pneuro' => 23,
	'ppathology' => 29,
	'ppulmonologists' => 24,
	'ptrauma' => 26,
	'pradiology' => 36
);

function lrxd_enqueue_gf_scripts() {
	
	// Enqueue GravityForms Scripts
	if ( lrxd_plugin_exists('gravity_form_enqueue_scripts') ) {
		global $lrxd_forms;
		
		foreach ($lrxd_forms as $form_tag => $form_ID) {
			gravity_form_enqueue_scripts($form_ID, false);
		}
	}
}
add_action('init', 'lrxd_enqueue_gf_scripts');

function lrxd_gravity_form($form_tag, $display_title=false, $display_description=false, $display_inactive=false, $field_values=null, $ajax=false){
	if (lrxd_plugin_exists('RGForms', 'Gravity Forms')) {
		global $lrxd_forms;

		$form_id = $lrxd_forms[$form_tag];
		$form = RGForms::get_form($form_id, $display_title, $display_description, $display_inactive, $field_values, $ajax);
		
		if ($form) {
			echo $form;
		}
	}
}