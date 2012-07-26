<?php

/**
 * Archives widget class
 *
 * @since 2.8.0
 */
class WP_Widget_Archives_Event extends  WP_Widget_Archives {

	function WP_Widget_Archives_Event() {
		$widget_ops = array( 'classname' => 'widget_archive_event', 'description' => 'A monthly archive of Donor Alliance\'s Events' );
		$this->WP_Widget( 'widget_archive_event', 'Event Archives', $widget_ops );
	}

	function widget( $args, $instance ) {
		global $wp_query;
		global $da_months;
		$query_vars = $wp_query->query_vars;
		
		extract($args);
		$c = ! empty( $instance['count'] ) ? '1' : '0';
		$d = ! empty( $instance['dropdown'] ) ? '1' : '0';
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : __($instance['title'], 'da') , $instance, $this->id_base);

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		$args = array(
			'type' => 'monthly', 
			'show_post_count' => $c
		);
		echo "<ul>";
		
		$archive_url = array(); // template for generating urls
		$url = array();
		$urls = array();	// collection of generated urls
		
		
		
		
		if (!da_is_english()) {$archive_url['lang'] = ICL_LANGUAGE_CODE;}
		$archive_url['archive_slug'] = DA_CPT_REWRITE_EVENT;
		
		
		$args = array(
			'post_type' => 'event',
			'post_status' => 'future',
			'order' => 'ASC',
		);
		
		$query = new WP_Query($args);
		$events = $query->get_posts();
		if (count($events) > 0) {
			$start_date = date_parse($events[0]->post_date);
			$archive_url['year'] = $start_date['year'];
			$archive_url['month'] = $start_date['month'];
			
			$url['name'] = $da_months[$archive_url['month']]. ' '. $archive_url['year'];
			$url['href'] = implode('/', $archive_url);
			$urls[] = $url;
			
			foreach ($events as $event) {
				$this_date = date_parse($event->post_date);
				if ($this_date['year'] != $archive_url['year']) {
					$archive_url['year'] = $this_date['year'];
					$archive_url['month'] = $this_date['month'];
					
					$url['name'] = $da_months[$archive_url['month']]. ' '. $archive_url['year'];
					$url['href'] = implode('/', $archive_url);
					$urls[] = $url;
				}
				elseif ($this_date['month'] != $archive_url['month']) {
					$archive_url['month'] = $this_date['month'];

					$url['name'] = $da_months[$archive_url['month']]. ' '. $archive_url['year'];
					$url['href'] = implode('/', $archive_url);
					$urls[] = $url;
				}
			}
		}
		
		foreach ($urls as $url) {
			?> <li><a href="/<?php echo $url['href']; ?>"><?php echo $url['name']; ?></a></li> <?php
		}
		
		echo "</ul>";

		echo $after_widget;
	}

	
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
			$instance['title'] = strip_tags($new_instance['title']);

			return $instance;
		}

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
			$title = strip_tags($instance['title']);
			$count = $instance['count'] ? 'checked="checked"' : '';
			$dropdown = $instance['dropdown'] ? 'checked="checked"' : '';
	?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
	<?php
		}
}
add_action( 'widgets_init', create_function( '', "register_widget('WP_Widget_Archives_Event');" ) );













