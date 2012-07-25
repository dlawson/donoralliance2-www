<?php $bucket_positions = array('left', 'middle', 'right'); ?>

<ul class="buckets clearfix">
<?php
foreach ($bucket_positions as $position) :
	$title = cfct_get_option('bucket-title-'.$position);
	$link = cfct_get_option('bucket-link-'.$position);
	$content = cfct_get_option('bucket-content-'.$position);
	
	
	if ($title) :
		$title = ($link=='')
			? $title
			:'<a href="'.$link.'">'.$title.'</a>';
			?>
			<li>
				<h2 class="title"><?php echo $title; ?></h2>
				<div class="content">
					<?php echo $content; ?>
				</div>
			</li>
		<?php
	endif;
endforeach 
?>
</ul>