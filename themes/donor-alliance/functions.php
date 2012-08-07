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

load_theme_textdomain('da');

define('CFCT_DEBUG', false);
define('CFCT_PATH', trailingslashit(TEMPLATEPATH));
define('THEME_VERSION', '1.0.1');
define('CFCT_IS_PRODUCTION', false);
define('LRXD_THEME_PREFIX', 'da');

include_once(CFCT_PATH.'carrington-core/carrington.php');
include_once(CFCT_PATH.'functions/custom-post-types.php');
include_once(CFCT_PATH.'functions/custom-post-meta.php');
include_once(CFCT_PATH.'functions/custom-taxonomies.php');
include_once(CFCT_PATH.'functions/custom-walkers.php');
include_once(CFCT_PATH.'functions/gravity-forms.php');
include_once(CFCT_PATH.'functions/sidebars.php');
include_once(CFCT_PATH.'functions/widgets.php');

include_once(CFCT_PATH.'functions/actions.php');
include_once(CFCT_PATH.'functions/filters.php');


$btn_share_your_story_text = _x('Share Your Story', 'Text for link to Share Your Story page', 'da');
define('DA_BTN_SHARE_YOUR_STORY', '<a href="'.da_get_page_url('submit-a-story').'" class="btn btn-share-your-story"><span>'.$btn_share_your_story_text.'</span></a>');
define('DA_ARCHIVE_URL_DONORS', 'donors/');
define('DA_ARCHIVE_URL_RECIPIENTS', 'recipients/');


define('DA_IMAGE_DONOR_FEATURED_HOME_WIDTH', 614);
define('DA_IMAGE_DONOR_FEATURED_HOME_HEIGHT', 472);
define('DA_IMAGE_DONOR_FEATURED_SINGLE_WIDTH', 352);
define('DA_IMAGE_DONOR_FEATURED_SINGLE_HEIGHT', 377);
define('DA_IMAGE_DONOR_FEATURED_TOUT_WIDTH', 255);
define('DA_IMAGE_DONOR_FEATURED_TOUT_HEIGHT', 190);


global $da_social;
$args = array(
	'name' => 'Facebook',
	'links' => array(
		'Colorado' => 'http://www.facebook.com/DonateLifeColorado',
		'Wyoming' => 'https://www.facebook.com/DonateLifeWyoming',
	),
);
$da_social['facebook'] = $args;

$args = array(
	'name' => 'Twitter',
	'links' => array(
		'Colorado' => 'http://twitter.com/#!/DonateLifeCO',
		'Wyoming' => 'http://twitter.com/#!/DonateLifeWY',
	),
);
$da_social['twitter'] = $args;


global $da_months;
$da_months = array();
$da_months[1] = __('January', 'da');
$da_months[2] = __('February', 'da');
$da_months[3] = __('March', 'da');
$da_months[4] = __('April', 'da');
$da_months[5] = __('May', 'da');
$da_months[6] = __('June', 'da');
$da_months[7] = __('July', 'da');
$da_months[8] = __('August', 'da');
$da_months[9] = __('September', 'da');
$da_months[10] = __('October', 'da');
$da_months[11] = __('November', 'da');
$da_months[12] = __('December', 'da');

$nav_locations = array(
	'nav-aux-join' => 'Aux - Join Our Team',
	'nav-aux-donor' => 'Aux - Become A Donor',
	'nav-main' => 'Main Navigation',
	'nav-sub' => 'Sub Navigation',
	'nav-footer' => 'Footer Navigation',
);
register_nav_menus( $nav_locations );

add_theme_support( 'post-thumbnails' );
add_image_size( 'donor-recipient-home', DA_IMAGE_DONOR_FEATURED_HOME_WIDTH, DA_IMAGE_DONOR_FEATURED_HOME_HEIGHT, true );
add_image_size( 'donor-recipient-single', DA_IMAGE_DONOR_FEATURED_SINGLE_WIDTH, DA_IMAGE_DONOR_FEATURED_SINGLE_HEIGHT, true );
add_image_size( 'donor-recipient-tout', DA_IMAGE_DONOR_FEATURED_TOUT_WIDTH, DA_IMAGE_DONOR_FEATURED_TOUT_HEIGHT, true );
add_image_size( 'quilt-square', 250, 250, true );

// Check for plugin
function lrxd_plugin_exists($plugin_class_or_function, $plugin_name = null) {
	if(class_exists($plugin_class_or_function) || function_exists($plugin_class_or_function)) {
		return true;
	} else {
		if($plugin_name != null) {
			echo 'Please install and activate the ' . $plugin_name . ' plugin!';
		}
		return false;
	}
}

function lrxd_get_post_meta($meta_name, $meta_context = null, $post_id = null) {
	
	if ($post_id == null) { $post_id = get_the_id(); }
	$post = get_post($post_id);
	if ($meta_context == null || $meta_context == '') {
		$meta_context = $post->post_type;
	}
	

	$meta_key = LRXD_THEME_PREFIX.'-'.$meta_context.'-'.$meta_name;
	$ret = get_post_meta($post_id, $meta_key);

	return ($ret[0]=='')?null:$ret[0];
}
function lrxd_post_meta($meta_name, $meta_context = null, $post_id = null) {
	echo lrxd_get_post_meta($meta_name, $meta_context, $post_id);
}

function lrxd_format_date($date, $format) {
	$timestamp = (is_array($date))?mktime($date):strtotime($date);
	return date($format, $timestamp);
}
function da_get_site_url() {
	$url = '/';
	if (!da_is_english()) {
		$url.=ICL_LANGUAGE_CODE.'/';
	}
	return $url;
}
function da_is_english() {
	$ret = true;
	if ( function_exists('icl_get_home_url') ) {
		$ret = (ICL_LANGUAGE_CODE=='en');
	}
	return $ret;
}
function da_possessify_name($name) {
	$name_rav = strrev($name);
	$last_letter = strtolower($name_rev{0});
	
	$suffix = ($last_letter == 's')
				? '&rsquo;'
				: '&rsquo;s';
	
	return $name.$suffix;
}
function da_get_archive_content($post_type) {
	if (lrxd_plugin_exists('snippets_value', 'Snippets')) {
		return snippets_value( 'archive-content-'.$post_type );
	}
}
function da_get_page_url($page_slug) {
	$args = array(
		'post_type' => 'page',
		'name' => $page_slug,
	);
	
	$pq = new WP_Query($args);
	$pc = $pq->get_posts();
	$p = $pc[0];
	
	$ret = get_permalink($p->ID);
	return $ret;
}

function da_get_post_slug_from_id($id) {
	$this_post = get_post($id);
	return $this_post->post_name;
}
function lrxd_generate_slug($phrase, $maxLength=100)
{
    $result = strtolower($phrase);

    $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
    $result = trim(preg_replace("/[\s-]+/", " ", $result));
    $result = trim(substr($result, 0, $maxLength));
    $result = preg_replace("/\s/", "-", $result);

    return $result;
}
function lrxd_get_the_post_thumbnail( $id, $size, $args=null ) {
	if ( function_exists('get_the_post_thumbnail') ) {
		if ( has_post_thumbnail() ) {
			$default_args = array(
				'class' => 'featured-image',
				'title' => '',
				'alt' => '',
			);

			$thumbnail_args = ($args)
				? array_merge($default_args, $args)
				: $default_args;
			
			return get_the_post_thumbnail($id, $size, $thumbnail_args);
		}
	}
	else {
		echo 'You need to enable Post Thumbnails!  <code>add_theme_support( \'post-thumbnails\' );</code> ';
	}
}
function lrxd_the_post_thumbnail($size, $args=null) {
	global $post;
	
	echo lrxd_get_the_post_thumbnail($post->ID, $size, $args=null);
}