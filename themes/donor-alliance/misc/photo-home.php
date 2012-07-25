<?php // MUST BE INCLUDED WITHIN THE LOOP ?>

<?php if (has_post_thumbnail() ):
	$featured_image_src = wp_get_attachment_image_src( get_post_thumbnail_id( the_ID(); ), 'single-post-thumbnail' ); ?>

	<script type="text/javascript">
		!function($) {
			$(function() {
				$('#cl-connectview .flash').flash({
			        'src':'<?php bloginfo('template_url') ?>/assets/main/swf/connect-view/FWBTConnection.swf',
			        'width':<?php echo DA_IMAGE_DONOR_FEATURED_HOME_WIDTH; ?>,
			        'height':<?php echo DA_IMAGE_DONOR_FEATURED_HOME_HEIGHT; ?>,
			        'color':'#fff',
			        'quality':'high',
					'vars':{
						'sourceImage':'<?php bloginfo('template_url') ?>/assets/main/swf/connect-view/xml/config.xml',
					},
			        'access':'domain',
			        'express':'<?php bloginfo('template_url') ?>/assets/main/swf/_playerProductInstall.swf',
			        'classid':'clsid:D27CDB6E-AE6D-11cf-96B8-444553540000',
			        'codebase':'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=',
			        'plugin':'http://get.adobe.com/flashplayer',
			        'mime':'application/x-shockwave-flash',
			        'version':'9.0.24',
			    });
			});
		}(jQuery);
	</script>
<?php endif; ?>