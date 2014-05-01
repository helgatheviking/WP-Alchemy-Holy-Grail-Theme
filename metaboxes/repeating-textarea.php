<div class="my_meta_control">
 
	<p class="warning"><?php _e( 'These textareas will NOT work without javascript enabled.' );?></p>
 
	<p><?php _e( 'Repeating Textareas cannot use WP_Editor() and must rely on tinyMCE javascript' );?></p>
 
	<a href="#" class="dodelete-repeating_textareas button"><?php _e('Remove All', 'wpalchemy-grail');?></a>
 
	<p><?php _e( 'Add new textareas by using the "Add Textarea" button.  Rearrange the order of textareas by dragging and dropping.', 'wpalchemy-grail' );?></p>
 
	<?php while( $mb->have_fields_and_multi( 'repeating_textareas' ) ): ?>

	<?php $mb->the_group_open(); ?>

	<div class="group-wrap <?php echo $mb->get_the_value( 'toggle_state' ) ? ' closed' : ''; ?>" >

		<?php $mb->the_field('toggle_state'); ?>
		<?php // @ TODO: toggle should be user specific ?>
		<input type="checkbox" name="<?php $mb->the_name(); ?>" value="1" <?php checked( 1, $mb->get_the_value() ); ?> class="toggle_state hidden" />

		<div class="group-control dodelete" title="<?php _e( 'Click to remove Slide', 'wpalchemy-grail' );?>"></div>
		<div class="group-control toggle" title="<?php _e( 'Click to toggle', 'wpalchemy-grail' );?>"></div>

		<?php $mb->the_field('textarea'); ?>
		<?php // need to html_entity_decode() the value b/c WP Alchemy's get_the_value() runs the data through htmlentities() ?>
		<h3 class="handle"><?php echo $mb->get_the_value() ? substr( strip_tags( html_entity_decode( $mb->get_the_value() ) ), 0, 30 ) : ( 'Textarea Content' );?></h3>
		
		<div class="group-inside">
		
			<p class="warning update-warning"><?php _e( 'Sort order has been changed.  Remember to save the post to save these changes.' );?></p>
	
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

	<p><a href="#" class="docopy-repeating_textareas button"><span class="icon add"></span><?php _e( 'Add Textarea', 'wpalchemy-grail' );?></a></p>	
		
	<p class="meta-save"><button type="submit" class="button-primary" name="save"><?php _e('Update');?></button></p>

</div>