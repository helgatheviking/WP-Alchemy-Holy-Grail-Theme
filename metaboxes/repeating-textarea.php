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
	
			<?php

			// 'html' is used for the "Text" editor tab.
			if ( 'html' === wp_default_editor() ) {
				add_filter( 'the_editor_content', 'wp_htmledit_pre' );
				$switch_class = 'html-active';
			} else {
				add_filter( 'the_editor_content', 'wp_richedit_pre' );
				$switch_class = 'tmce-active';
			}
			?>

			<div class="customEditor wp-core-ui wp-editor-wrap <?php echo 'tmce-active'; //echo $switch_class;?>">
				
				<div class="wp-editor-tools hide-if-no-js">

					<div class="wp-media-buttons custom_upload_buttons">
						<?php do_action( 'media_buttons' ); ?>
					</div>

					<div class="wp-editor-tabs">
						<a data-mode="html" class="wp-switch-editor switch-html"> <?php _ex( 'Text', 'Name for the Text editor tab (formerly HTML)' ); ?></a>
						<a data-mode="tmce" class="wp-switch-editor switch-tmce"><?php _e('Visual'); ?></a>
					</div>

				</div><!-- .wp-editor-tools -->

				<div class="wp-editor-container">
					<textarea class="wp-editor-area" rows="10" cols="50" name="<?php $mb->the_name(); ?>" rows="3"><?php echo esc_html( apply_filters( 'the_editor_content', html_entity_decode( $mb->get_the_value() ) ) ); ?></textarea>
				</div>
				<p><span><?php _e('Enter in some text');?></span></p>

			</div>

		</div><!-- .group-inside -->

	</div><!-- .group-wrap -->

	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 
	<p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-repeating_textareas button"><?php _e('Add Textarea');?></a></p>	
	
	

	
	<p class="meta-save"><button type="submit" class="button-primary" name="save"><?php _e('Update');?></button></p>

</div>