<?php 
	global $post; 
	$post_type = $post->post_type; 
	
	switch ($post_type) {
		case 'donor':
			$story_type = 'Donor Family';
			break;
		case 'recipient':
			$story_type = 'Recipient';
			break;
	}
	
	
	$content = lrxd_get_post_meta('aside', 'donor-recipient');
	
	switch ( lrxd_get_post_meta('gender', 'donor-recipient') ) {
		case 'f':
			$gender_possessive = 'Her';
			break;
		
		case 'm':
			$gender_possessive = 'His';
			break;

		default:
			$gender_possessive = 'Their';
			break;
	}
	
?>
<div id="slide-<?php the_ID(); ?>" <?php post_class('slide type-'.$post_type); ?>>
	<?php cfct_misc('flash-photo-home'); ?>
	<div class="slide-content">
		<div class="header">
			<h2 class="subtitle"><?php echo $story_type; ?></h2>
			<h1 class="title"><span><?php the_title(); ?></span></h1>
		</div>
		<div class="body">
			<?php echo $content; ?>
		</div>
		<div class="more">
			<a href="<?php the_permalink(); ?>"><span>Read <?php echo $gender_possessive; ?> Story</span></a>
		</div>				
	</div>
</div>