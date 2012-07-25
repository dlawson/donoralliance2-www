<?php

// This module depends on the containing Content template to have an ID of the format "#post-<< post_ID >>"
// Contained within Content templates for type-donor, type-recipient, page

global $post;
$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'donor-recipient-single' );
$image_src =  $image[0];

?>

	<script type="text/javascript">
		!function($) {
			$(function() {
				$('#post-<?php the_ID(); ?> .flash').flash({
					swf: '<?php bloginfo('template_url') ?>/assets/main/swf/photo-interior.swf',
					height: 424,
					quality: 'high',
					width: 389,
					wmode: 'transparent',
					flashvars: {
						imgX: 18,
						imgY: 17,
						imgR: -2.7,
						imgSource: '<?php echo $image_src; ?>'
					}
				});
			});
		}(jQuery);
	</script>
	<div class="flash">
		<div class="image-container">
			<?php lrxd_the_post_thumbnail('donor-recipient-single');  ?>
		</div>
	</div>