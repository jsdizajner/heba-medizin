<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>

<div id="shipping-in-form">
	<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

	<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

	<?php wc_cart_totals_shipping_html(); ?>

	<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

	<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

	<div id="shipping">
		<<?php esc_html_e( 'Shipping', 'medizin' ); ?></h3>
		<?php esc_attr_e( 'Shipping', 'medizin' ); ?>"><?php woocommerce_shipping_calculator(); ?>
	</div>

	<?php endif; ?>
</div>
