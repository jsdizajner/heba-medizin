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

        <?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

            <h3 id="ship-to-different-address">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                    <input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span><?php esc_html_e( 'Ship to a different address?', 'woocommerce' ); ?></span>
                </label>
            </h3>

            <div class="shipping_address">

                <?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

                <div class="woocommerce-shipping-fields__field-wrapper">
                    <?php
                    $fields = $checkout->get_checkout_fields( 'shipping' );

                    foreach ( $fields as $key => $field ) {
                        woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                    }
                    ?>
                </div>

                <?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

            </div>

        <?php endif; ?>

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
