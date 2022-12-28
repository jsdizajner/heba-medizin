<?php
defined( 'ABSPATH' ) || exit;

/**
 * Load Composer
 */
require __DIR__ . '/vendor/autoload.php';

/**
 * Initiate Update Checker
 */
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/jsdizajner/heba-medizin',
	__FILE__,
	'heba-medizin'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');

/**
 * Enqueue child scripts
 */
if ( ! function_exists( 'medizin_child_enqueue_scripts' ) ) {
	function medizin_child_enqueue_scripts() {
		wp_enqueue_style( 'medizin-child-style', get_stylesheet_directory_uri() . '/style.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'medizin_child_enqueue_scripts', 15 );
