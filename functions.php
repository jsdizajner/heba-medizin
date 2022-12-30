<?php
defined( 'ABSPATH' ) || exit;

$HEBA_THEME_VERSION = \HEBA_CORE\HEBA_CORE::get_theme_info('Version');
ray($HEBA_THEME_VERSION);

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
if ( ! function_exists( 'heba_enqueue_scripts' ) ) {
	function heba_enqueue_scripts($HEBA_THEME_VERSION) {
		wp_enqueue_style( 'heba-style', get_stylesheet_directory_uri() . '/style.css', '[]', $HEBA_THEME_VERSION);
	}
}
add_action( 'wp_enqueue_scripts', 'heba_enqueue_scripts', 15 );

