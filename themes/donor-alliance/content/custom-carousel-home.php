<?php 
	global $post; 
	$post_type = $post->post_type; 
	
	$story_type_donor_family = _x('Donor Family', 'Donor Story type label on homepage carousel', 'da');
	$story_type_recipient = _x('Recipient', 'Donor Story type label on homepage carousel', 'da');

	switch ($post_type) {
		case 'donor':
			$story_type = $story_type_donor_family;
			break;
		case 'recipient':
			$story_type = $story_type_recipient;
			break;
	}
	
	
	$content = lrxd_get_post_meta('aside', 'donor-recipient');
	


	$gender_possessive_male = _x('His', 'Gender possessive male adjective for homepage carousel read-more link.  "Read His Story"', 'da');
	$gender_possessive_female = _x('Her', 'Gender possessive female adjective for homepage carousel read-more link.  "Read Her Story"', 'da');
	$gender_possessive_neutral = _x('Their', 'Gender possessive neutral adjective for homepage carousel read-more link.  "Read Their Story"', 'da');

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
	
	$read_more_format =  _x('Read %s\'s Story', 'Homepage carousel Read More link.  %s is the slot for the possessive adjective. "Read ___ Story"', 'da');
	$read_more = sprintf($read_more_format, $gender_possessive);
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
			<a href="<?php the_permalink(); ?>"><span><?php echo $read_more; ?></span></a>
		</div>				
	</div>
</div>