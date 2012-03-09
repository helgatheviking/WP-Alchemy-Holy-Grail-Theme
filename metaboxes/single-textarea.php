<div class="my_meta_control">
 
	<p><?php _e('A single textarea that uses the wp_editor() function.');?></p>
 
	<p>
		<?php $mb->the_field('test_editor'); 

		$settings = array( 
			'textarea_rows' => '10',
			'media_buttons' => 'false',
			'tabindex' =>2
		);

		$val =  html_entity_decode($mb->get_the_value()); 
		$id = $mb->get_the_name();
		
		wp_editor($val,  $id , $settings );
		?>
		
		 <span>Enter in some text</span>
	</p>
	
	<p class="meta-save"><button type="submit" class="button-primary" name="save"><?php _e('Update');?></button></p>

</div>