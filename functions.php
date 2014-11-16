<?php
/*
 * Functions for creating the metaboxes
 */

if ( ! class_exists( 'WPAlchemy_MetaBox' ) ) include_once 'metaboxes/wpalchemy/MetaBox.php';

$simple_textarea = new WPAlchemy_MetaBox(array(
	'id' => '_single_textarea_meta',
	'title' => 'Sample WP_Editor',
	'template' => dirname ( __FILE__ ). '/metaboxes/single-textarea.php',
	'save_filter' => 'kia_single_save_filter',
	'init_action' => 'kia_metabox_init',
));

$repeating_textareas = new WPAlchemy_MetaBox(array(
	'id' => '_repeating_textareas_meta',
	'title' => 'Sample Repeating Textareas',
	'template' => dirname ( __FILE__ ). '/metaboxes/repeating-textarea.php',
	'init_action' => 'kia_metabox_init', 
	'save_filter' => 'kia_repeating_save_filter',
));

/* 
 * Sanitize the input similar to post_content
 * @param array $meta - all data from metabox
 * @param int $post_id
 * @return array
 */
function kia_single_save_filter( $meta, $post_id ){

	if( isset( $meta['test_editor'] ) ){
		$meta['test_editor'] = sanitize_post_field( 'post_content', $meta['test_editor'], $post_id, 'db' );
  	}

	return $meta;

}

/* 
 * Sanitize the input similar to post_content
 * @param array $meta - all data from metabox
 * @param int $post_id
 * @return array
 */
function kia_repeating_save_filter( $meta, $post_id ){

	if ( is_array( $meta ) && ! empty( $meta ) ){

		array_walk( $meta, function ( &$item, $key ) { 
			if( isset( $item['textarea'] ) ){
				$item['textarea'] = sanitize_post_field( 'post_content', $item['textarea'], $post_id, 'db' );
  			}

		} );

	}

	return $meta;

}

/* 
 * Enqueue styles and scripts specific to metaboxs
 */
function kia_metabox_init(){
	
	// I prefer to enqueue the styles only on pages that are using the metaboxes
	wp_enqueue_style( 'wpalchemy-metabox', get_stylesheet_directory_uri() . '/metaboxes/meta.css');

	//make sure we enqueue some scripts just in case ( only needed for repeating metaboxes )
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-widget' );
	wp_enqueue_script( 'jquery-ui-mouse' );
	wp_enqueue_script( 'jquery-ui-sortable' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	
	// special script for dealing with repeating textareas- needs to run AFTER all the tinyMCE init scripts, so make 'editor' a requirement
	wp_enqueue_script( 'kia-metabox', get_stylesheet_directory_uri() . '/metaboxes/kia-metabox' . $suffix . '.js', array( 'jquery', 'word-count', 'editor', 'quicktags', 'wplink', 'wp-fullscreen', 'media-upload' ), '1.1', true );
	
}

function kia_metabox_scripts(){
	wp_print_scripts('kia-metabox');
}

/* 
 * Recreate the default filters on the_content
 * this will make it much easier to output the meta content with proper/expected formatting
*/
add_filter( 'meta_content', 'wptexturize'        );
add_filter( 'meta_content', 'convert_smilies'    );
add_filter( 'meta_content', 'convert_chars'      );
add_filter( 'meta_content', 'wpautop'            );
add_filter( 'meta_content', 'shortcode_unautop'  );
add_filter( 'meta_content', 'prepend_attachment' );
add_filter( 'meta_content', 'do_shortcode');

/* eof */