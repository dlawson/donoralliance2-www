<?php

if (is_admin()) {


/*
	Add a custom field to the field editor (See editor screenshot)
*/
	function my_standard_settings($position, $form_id){
		// Create settings on position 25 (right after Field Label)
		if($position == 25){
			?>
			<li class="admin_label_setting field_setting" style="display: list-item; ">
				<label for="field_placeholder">Placeholder Text
					<!-- Tooltip to help users understand what this field does -->
					<a href="javascript:void(0);" class="tooltip tooltip_form_field_placeholder" tooltip="&lt;h6&gt;Placeholder&lt;/h6&gt;Enter the placeholder/default text for this field.">(?)</a>
				</label>
				<input type="text" id="field_placeholder" class="fieldwidth-3" size="35" onkeyup="SetFieldProperty('placeholder', this.value);">
			</li>
			<?php
		}
	}
	add_action("gform_field_standard_settings", "my_standard_settings", 10, 2);


/*
	Now we execute some javascript technicalitites for the field to load correctly
*/
	function my_gform_editor_js(){
		?>
		<script>
		//binding to the load field settings event to initialize the checkbox
		jQuery(document).bind("gform_load_field_settings", function(event, field, form){
			jQuery("#field_placeholder").val(field["placeholder"]);
		});
		</script>
		<?php
	}
	add_action("gform_editor_js", "my_gform_editor_js");
}


if (!is_admin()) {
	/*
		We use jQuery to read the placeholder value and inject it to its field
	*/
	function my_gform_enqueue_scripts($form, $is_ajax=false){
		/*
		The next line ensures that jQuery is accessible. If it isn't, then it tries to include it.
		I'm using google's cdn to get the jQuery library, but you can replace the src attribute for
		your local library. 
		*/
		?>
		<script>!window.jQuery && document.write(unescape('%3Cscript src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.js"%3E%3C/script%3E'))</script>
		<!-- <script>!window.jQuery && document.write(unescape('%3Cscript src="<?php bloginfo('stylesheet_directory');?>/js/jquery-1.6.2.min.js"%3E%3C/script%3E'))</script> -->
		<script>
		jQuery(function(){
			<?php
			/* Go through each one of the form fields */
			foreach($form['fields'] as $i=>$field){
				/* Check if the field has an assigned placeholder */
				if(isset($field['placeholder']) && !empty($field['placeholder'])){
					/* If a placeholder text exists, inject it as a new property to the field using jQuery */
					?>
					jQuery('#input_<?php echo $form['id']?>_<?php echo $field['id']?>').attr('placeholder','<?php echo $field['placeholder']?>');
					jQuery('#input_<?php echo $form['id']?>_<?php echo $field['id']?>[placeholder]').placeholder();
					<?php
				}
			}
			?>
			/* Check if the browser supports placeholders */
			if (! ("placeholder" in document.createElement("input"))) {
				/*
				If you want this code to affect only your GravityForms, then comment/uncomment the
				following two lines.
				*/
				$('[placeholder]').each(function() {
				//$('.gform_wrapper [placeholder]').each(function() {
					$this = $(this);
					var placeholder = $(this).attr('placeholder');
					if ($(this).val() === '') {
						$this.val(placeholder);
						$this.addClass('is_placeholder');
					}
					$this.bind('focus', function(){
						if ($(this).val() === placeholder) {
							this.plchldr = placeholder;
							$(this).val('');
						}
						$(this).removeClass('is_placeholder');
					});
					$this.bind('blur', function() {
						if ($(this).val() === '' && $(this).val() !== this.plchldr) {
							$(this).val(this.plchldr);
							$(this).addClass('is_placeholder');
						} else {
							$(this).removeClass('is_placeholder');
						}
					});
				});
				$('form#new_mail').bind('submit', function() {
					$(this).find('*[placeholder]').each(function() {
						if ($(this).val() === $(this).attr('placeholder')) {
							$(this).val('');
						}
					});
				});
			}
		});
		</script>
		<?php
	}
//	add_action('gform_enqueue_scripts',"my_gform_enqueue_scripts", 10, 2);
}




?>