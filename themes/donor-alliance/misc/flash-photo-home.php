<?php
	global $post;
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'donor-recipient-home' );
	$image_src =  $image[0];
?>

	<script type="text/javascript">
		!function($) {
			$(function() {
				$('#slide-<?php the_ID(); ?> .flash').flash({
					swf: '<?php bloginfo('template_url') ?>/assets/main/swf/photo-home.swf',
					height: 550,
					quality: 'high',
					width: 660,
					wmode: 'transparent',
					flashvars: {
						imgX: 20,
						imgY: 25,
						imgR: -3,
						imgSource: '<?php echo $image_src; ?>'
					}
				});
			});
		}(jQuery);
	</script>
	<div class="flash">
		
		<?php if ($image_src): ?>
			<div class="image-container">
				<img src="<?php echo $image_src; ?>" />
				<span class="overlay"></span>
			</div>			
		<?php endif ?> 
		
	</div>