<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @todo CHECK THUMBNAILS
 * @version 9.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="row checkout-content-wrap">
	<div class="col-md-7">
		<?php
		do_action( 'woocommerce_before_checkout_form', $checkout );

		// If checkout registration is disabled and not logged in, the user cannot checkout.
		if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
			echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', esc_html__( 'You must be logged in to checkout.', 'medizin' ) ) );

			return;
		}

		?>

		<form name="checkout" method="post" class="checkout woocommerce-checkout"
		      action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

			<?php if ( $checkout->get_checkout_fields() ) : ?>

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

				<div id="customer_details">
					<?php do_action( 'woocommerce_checkout_billing' ); ?>

					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				</div>

				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

			<?php endif; ?>

			<?php
			/**
			 * Do not edit this ID.
			 */
			?>
			<div id="order_review">

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



				<?php
				/**
				 * woocommerce_checkout_after_order_review hook.
				 *
				 * @hooked woocommerce_checkout_payment - 20
				 */
				do_action( 'woocommerce_checkout_after_order_review' );
				?>
			</div>

		</form>



		<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

	</div>

	<div class="col-md-5">
 		<div class="checkout-order-review-wrap">
			<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

			<h3 id="order_review_heading"><?php esc_html_e( 'Order summary', 'medizin' ); ?></h3>

			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

			<div class="woocommerce-checkout-review-order">
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>
		</div>
	</div>
</div>
