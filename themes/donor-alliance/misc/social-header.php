<ul class="nav nav-social">
<!-- 	<li class="facebook">
		<a>Facebook</a>
		<ul class="sub-menu">
			<li><a href="<?php echo cfct_get_option('fb-colorado'); ?>" target="_blank">Colorado</a></li>
			<li><a href="<?php echo cfct_get_option('fb-wyoming'); ?>" target="_blank">Wyoming</a></li>
		</ul>
	</li>
	<li class="twitter">
		<a href="<?php echo cfct_get_option('twitter'); ?>" target="_blank">Twitter</a>
		<ul class="sub-menu">
			<li><a href="<?php echo cfct_get_option('tw-colorado'); ?>" target="_blank">Colorado</a></li>
			<li><a href="<?php echo cfct_get_option('tw-wyoming'); ?>" target="_blank">Wyoming</a></li>
		</ul>
	</li> -->

	<?php 

	global $da_social;
	foreach ($da_social as $social_key => $social_pkg) : 
		$name = $social_pkg['name'];
		$links = $social_pkg['links'];
		?>
		<li class="<?php echo $social_key; ?>">
			<a class="imr icon"><?php echo $name; ?></a>
			<?php if ($links) : ?>
				<ul class="sub-menu">
					<?php foreach ($links as $link_text => $link_href): ?>
						<li><a href="<?php echo $link_href ?>" target="_blank"><?php echo $link_text; ?></a></li>
					<?php endforeach ?>
				</ul>
			<?php endif; ?>
		</li>
	
		<?php 
	endforeach; 
	?>

</ul>	