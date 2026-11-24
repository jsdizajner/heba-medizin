<?php
/**
 * Checkout shipping UX.
 *
 * 1) Order review (last step of the multi-step checkout): the shipping row is a read-only card
 *    with the chosen method. WooCommerce renders it through cart/cart-shipping.php, which prints
 *    radio buttons named shipping_method[n]. The same radios are already in the "Doprava" step,
 *    so the form had two radio groups with one name: the browser keeps only one checked, the
 *    review table (re-rendered on every update_checkout) won, and the "Doprava" step showed no
 *    selected card. Swapping the template only inside the review table leaves one set of radios.
 *
 * 2) "Doprava" step: the whole shipping card selects the method, not only the radio and label.
 */

defined( 'ABSPATH' ) || exit;

/**
 * True while the order review table renders its shipping row.
 */
function heba_is_review_shipping( $set = null ) {
	static $active = false;
	if ( null !== $set ) {
		$active = (bool) $set;
	}
	return $active;
}

add_action( 'woocommerce_review_order_before_shipping', function () {
	heba_is_review_shipping( true );
}, 0 );

add_action( 'woocommerce_review_order_after_shipping', function () {
	heba_is_review_shipping( false );
}, PHP_INT_MAX );

/**
 * Inside the review table use the read-only template.
 * With no available methods keep the original template, it prints WooCommerce's own notice.
 */
add_filter( 'wc_get_template', function ( $template, $template_name, $args ) {
	if ( 'cart/cart-shipping.php' !== $template_name || ! heba_is_review_shipping() ) {
		return $template;
	}
	if ( empty( $args['available_methods'] ) ) {
		return $template;
	}
	$readonly = get_stylesheet_directory() . '/woocommerce/checkout/review-order-shipping.php';
	return file_exists( $readonly ) ? $readonly : $template;
}, 10, 3 );

/**
 * Whole shipping card is clickable in the "Doprava" step.
 * Clicks on the radio, label or any interactive element are left to the browser.
 */
add_action( 'wp_enqueue_scripts', function () {
	if ( ! function_exists( 'is_checkout' ) || ! is_checkout() ) {
		return;
	}
	$js = <<<'JS'
jQuery(function ($) {
	$(document.body).on('click', 'ul#shipping_method > li', function (e) {
		if ($(e.target).closest('input, label, a, button, select, textarea').length) {
			return;
		}
		var $radio = $(this).find('input.shipping_method[type="radio"]').first();
		if ($radio.length && !$radio.prop('checked')) {
			$radio.prop('checked', true).trigger('change');
		}
	});
});
JS;
	wp_register_script( 'heba-checkout-shipping', false, array( 'jquery' ), null, true );
	wp_enqueue_script( 'heba-checkout-shipping' );
	wp_add_inline_script( 'heba-checkout-shipping', $js );
}, 20 );
