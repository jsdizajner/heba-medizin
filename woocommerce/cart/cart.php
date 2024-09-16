<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<div class="woocommerce-cart-form-wrapper">
		<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
			<thead>
			<tr>
				<th class="product-thumbnail"><?php esc_html_e( 'Product', 'medizin' ); ?></th>
				<th class="product-name">&nbsp;</th>
				<th class="product-price"><?php esc_html_e( 'Price', 'medizin' ); ?></th>
				<th class="product-quantity"><?php esc_html_e( 'Quantity', 'medizin' ); ?></th>
				<th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'medizin' ); ?></th>
				<th class="product-remove">&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
						<td class="product-thumbnail">
							<?php
							echo \HEBA_CORE\HEBA_CORE::get_product_thumbnail($product_id);
							?>
						</td>

						<td class="product-name">
							<?php
							if ( ! $product_permalink ) {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<h6 class="product-title">%s</h6>', esc_html( $_product->get_name() ) ), $cart_item, $cart_item_key ) . '&nbsp;' );
							} else {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<h6 class="product-title"><a href="%s">%s</a></h6>', esc_url( $product_permalink ), esc_html( $_product->get_name() ) ), $cart_item, $cart_item_key ) );
							}

							do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

							// Meta data.
							echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

							// Backorder notification.
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'medizin' ) . '</p>' ) );
							}
							?>
						</td>

						<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'medizin' ); ?>">
							<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							?>
						</td>

						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'medizin' ); ?>">
							<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input(
										array(
												'input_name'   => "cart[{$cart_item_key}][qty]",
												'input_value'  => $cart_item['quantity'],
												'max_value'    => $_product->get_max_purchase_quantity(),
												'min_value'    => '0',
												'product_name' => $_product->get_name(),
										),
										$_product,
										false
								);
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
							?>
						</td>

						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'medizin' ); ?>">
							<label><?php esc_html_e( 'Subtotal :', 'medizin' ); ?></label>
							<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>

						<td class="product-remove">
							<?php
							// @codingStandardsIgnoreLine
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
									'<a href="%s" class="%s" title="%s" data-product_id="%s" data-product_sku="%s"><div class="button-content-wrapper"><span class="button-text">%s</span></div></a>',
									esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
									esc_attr( 'tm-button style-bottom-line' ),
									esc_attr__( 'Remove this item', 'medizin' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() ),
									esc_html__( 'Remove', 'medizin' )
							), $cart_item_key );
							?>
						</td>
					</tr>
					<?php
				}
			}

			do_action( 'woocommerce_cart_contents' );
			?>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
			</tbody>
		</table>
	</div>

	<div class="row actions">
		<div class="col-md-6">
			<?php
			$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
			Medizin_Templates::render_button( [
					'text'          => esc_html__( 'Continue shopping', 'medizin' ),
					'link'          => [
							'url' => $shop_page_url,
					],
					'wrapper_class' => 'btn-continue-shopping',
			] );

			Medizin_Templates::render_button( [
					'text'          => esc_html__( 'Clear shopping cart', 'medizin' ),
					'link'          => [
							'url' => wc_get_cart_url() . '?empty-cart',
					],
					'wrapper_class' => 'btn-empty-cart',
					'style'         => 'text',
					'icon'          => 'fal fa-times',
			] );
			?>
		</div>
		<div class="col-md-6">
			<div class="actions-buttons">
				<button type="submit"
						class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"
						name="update_cart"
						value="<?php esc_attr_e( 'Update cart', 'medizin' ); ?>"><?php esc_html_e( 'Update cart', 'medizin' ); ?></button>

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
			</div>
		</div>

		<div class="actions-wrap">

		</div>
	</div>

	<?php do_action( 'woocommerce_after_cart_table' ); ?>

	<div class="cart-collaterals-wrap">
		<div class="row">
			<div class="col-md-4">
				<?php if ( wc_coupons_enabled() ) { ?>
					<div class="coupon-wrap">
						<div class="coupon">
							<h6 class="coupon-heading">
								<?php esc_html_e( 'Coupon Discount', 'medizin' ); ?>
							</h6>
							<div class="coupon-description">
								<?php esc_html_e( 'Enter your coupon code if you have one.', 'medizin' ); ?>
							</div>
							<label for="coupon_code"><?php esc_html_e( 'Coupon:', 'medizin' ); ?></label>
							<input type="text" name="coupon_code" class="input-text" id="coupon_code" value=""
								   placeholder="<?php esc_attr_e( 'Coupon code', 'medizin' ); ?>"/>

							<button type="submit"
									class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"
									name="apply_coupon"
									value="<?php esc_attr_e( 'Apply coupon', 'medizin' ); ?>"><?php esc_attr_e( 'Apply coupon', 'medizin' ); ?></button>

							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					</div>
				<?php } ?>
			</div>
			<div class="col-md-8">
				<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

				<div class="cart-collaterals row">
					<?php
					$total_column_classes = 'col-md-push-6 col-md-6 cart-total-wrap';

					if ( WC()->cart->needs_shipping() ) {
						$total_column_classes = 'col-md-6 cart-total-wrap';
					}

					?>
					<div class="<?php echo esc_attr( $total_column_classes ); ?>">
						<?php
						/**
						 * Cart collaterals hook.
						 *
						 * @hooked woocommerce_cross_sell_display
						 * @hooked woocommerce_cart_totals - 10
						 */
						do_action( 'woocommerce_cart_collaterals' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<?php do_action( 'woocommerce_after_cart' ); ?>
