<div class="my_meta_control">
 
	<p class="warning"><?php _e('These textareas will NOT work without javascript enabled.');?></p>
 
	<p><?php _e('Repeating Textareas cannot use WP_Editor() and must rely on tinyMCE javascript');?></p>
 
 
	<a style="float:right; margin:0 10px;" href="#" class="dodelete-repeating_textareas button"><?php _e('Remove All');?></a>
 
	<p><?php _e('Add new textareas by using the "Add Textarea" button.  Rearrange the order of textareas by dragging and dropping.');?></p>
 
	<?php while($mb->have_fields_and_multi('repeating_textareas')): ?>
	<?php $mb->the_group_open(); ?>
 
	<h3 class="handle"><?php _e('Textarea Content');?></h3>
	
	<a href="#" class="dodelete button"><?php _e('Remove Textarea');?></a>
	  
	<div class="inside">
	
		<p class="warning update-warning"><?php _e('Sort order has been changed.  Remember to save the post to save these changes.');?></p>
 
		<div class="customEditor">
			<?php $mb->the_field('textarea'); ?>
			
			<div class="wp-editor-tools">
				<div class="custom_upload_buttons hide-if-no-js wp-media-buttons"><?php do_action( 'media_buttons' ); ?></div>
			</div>
			<textarea id="<?php $mb->the_name(); ?>" rows="10" cols="50" name="<?php $mb->the_name(); ?>" rows="3"><?php echo esc_html( wp_richedit_pre($mb->get_the_value()) ); ?></textarea>
			<p><span><?php _e('Enter in some text');?></span></p>
		</div>
	
	</div>

	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 
	<p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-repeating_textareas button"><?php _e('Add Textarea');?></a></p>	
	
	

	
	<p class="meta-save"><button type="submit" class="button-primary" name="save"><?php _e('Update');?></button></p>

</div>