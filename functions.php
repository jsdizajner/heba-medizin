<?php
defined( 'ABSPATH' ) || exit;

/**
 * Enqueue child scripts
 */
if ( ! function_exists( 'medizin_child_enqueue_scripts' ) ) {
	function medizin_child_enqueue_scripts() {
		wp_enqueue_style( 'medizin-child-style', get_stylesheet_directory_uri() . '/style.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'medizin_child_enqueue_scripts', 15 );
