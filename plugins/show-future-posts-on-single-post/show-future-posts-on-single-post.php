<?php
/*
 * Plugin Name: Show Future Posts on Single Post
 * Author URI: http://www.pinoyinternetbusiness.com
 * Plugin URI: http://plugins.svn.wordpress.org/show-future-posts-on-single-post/trunk/
 * Description: Make all future posts visible in single post templates.
 * Author: Stanley Dumanig
 * Version: 1.0
 */

/*  Copyright 2009  Show Future Posts on Single Post Templates (email : stanley@dumanig.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.


*/

add_filter('the_posts', 'show_future_posts');

function show_future_posts($posts)
{
   global $wp_query, $wpdb;

   if(is_single() && $wp_query->post_count == 0)
   {
      $posts = $wpdb->get_results($wp_query->request);
   }

   return $posts;
}
?>