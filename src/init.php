<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function code_highlighter_block_cgb_block_assets() { 

	// Register block styles for both frontend + backend.
	wp_register_style(
		'code_highlighter_block-cgb-style-css',
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
		is_admin() ? array( 'wp-editor' ) : null, 
		null
	);

	// Register block editor script for backend.
	wp_register_script(
		'code_highlighter_block-cgb-block-js', 
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), 
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
		null, 
		true
	);

	// Register block editor styles for backend.
	wp_register_style(
		'code_highlighter_block-cgb-block-editor-css',
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ),
		array( 'wp-edit-blocks' ),
		null 
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
	wp_localize_script(
		'code_highlighter_block-cgb-block-js',
		'cgbGlobal', // Array containing dynamic data for a JS Global.
		[
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
			// Add more data here that you want to access from `cgbGlobal` object.
		]
	);

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 * @since 1.16.0
	 */
	register_block_type(
		'cgb/block-code-highlighter-block', array(
			// Enqueue blocks.style.build.css on both frontend & backend.
			'style'         => 'code_highlighter_block-cgb-style-css',
			// Enqueue blocks.build.js in the editor only.
			'editor_script' => 'code_highlighter_block-cgb-block-js',
			// Enqueue blocks.editor.build.css in the editor only.
			'editor_style'  => 'code_highlighter_block-cgb-block-editor-css',
		)
	);
}

// Hook: Block assets.
add_action( 'init', 'code_highlighter_block_cgb_block_assets' );

/**	
 * Libs Assets loading 
 */
function code_highlighter_block_libs_assets() {

	if( ! is_admin( )){
		// JS Libs
		wp_enqueue_script(
			'code_highlighter_block_js_lib', 
			plugins_url( '/dist/lib/js/prism.js', dirname( __FILE__ ) ), 
			array(),
			null, 
			true
		);

		// CSS Libs
		wp_enqueue_style(
			'code_highlighter_block_css_lib', 
			plugins_url( '/dist/lib/css/prism.css', dirname( __FILE__ ) ), 
			array(),
			null, 
			'all'
		);
	}

}
add_action( 'enqueue_block_assets', 'code_highlighter_block_libs_assets' );


