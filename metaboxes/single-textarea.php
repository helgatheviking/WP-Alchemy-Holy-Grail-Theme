<div class="my_meta_control">
 
	<p><?php _e('A single textarea that uses the wp_editor() function.');?></p>
 
	<p>

		<?php $mb->the_field('test_editor');

		$settings = array(
			'textarea_rows' => '10',
			'media_buttons' => true,
			'tabindex' =>2,
			'textarea_name' => $mb->get_the_name(),
		);

		// need to html_entity_decode() the value b/c WP Alchemy's get_the_value() runs the data through htmlentities()
		wp_editor( html_entity_decode( $mb->get_the_value() ),  $mb->get_the_id() , $settings );
		?>

		 <span>Enter in some text</span>
	</p>

	<p class="meta-save"><button type="submit" class="button-primary" name="save"><?php _e('Update');?></button></p>

</div>