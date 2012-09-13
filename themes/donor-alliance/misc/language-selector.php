<?php

$lang_titles = array(
	'en' => 'Eng',
	'es' => 'Esp',
);


if ( function_exists('icl_get_languages') ) :
	$langs = icl_get_languages('skip_missing=0&orderby=code'); 
	$base_url = site_url();

	if ($langs) :
		?>



		<ul class="nav nav-language">
			<?php foreach ($langs as $lang) : ?>
				<li class="<?php echo $lang['language_code'] ?>">
					<a href="<?php echo $lang['url']; ?>" data-langcode="<?php echo $lang['language_code'] ?>">
						<?php echo $lang_titles[ $lang['language_code'] ]; ?>
					</a>
				</li>			
			<?php endforeach; ?>
		</ul>

		<?php
	endif;				
endif;