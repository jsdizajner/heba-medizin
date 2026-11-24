<?php
/**
 * Read-only shipping row for the order review table (last checkout step).
 *
 * Loaded instead of cart/cart-shipping.php only inside the review table, see inc/checkout-shipping.php.
 * Receives the same variables as cart/cart-shipping.php. The method is chosen in the "Doprava" step,
 * so this row prints no inputs.
 *
 * @var array  $available_methods
 * @var string $chosen_method
 * @var string $package_name
 * @var bool   $show_package_details
 * @var string $package_details
 * @var int    $index
 */

defined( 'ABSPATH' ) || exit;

$heba_chosen = null;
foreach ( $available_methods as $heba_method ) {
	if ( (string) $heba_method->id === (string) $chosen_method ) {
		$heba_chosen = $heba_method;
		break;
	}
}
?>
<tr class="woocommerce-shipping-totals shipping heba-shipping-summary">
	<th><?php echo wp_kses_post( $package_name ); ?></th>
	<td data-title="<?php echo esc_attr( $package_name ); ?>">
		<?php if ( $heba_chosen ) : ?>
			<div class="heba-shipping-card">
				<?php echo wp_kses_post( wc_cart_totals_shipping_method_label( $heba_chosen ) ); ?>
			</div>
		<?php else : ?>
			<div class="heba-shipping-card heba-shipping-card--empty">
				<?php esc_html_e( 'Vyberte spôsob dopravy v kroku Doprava.', 'heba-medizin' ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $show_package_details && ! empty( $package_details ) ) : ?>
			<p class="woocommerce-shipping-contents"><small><?php echo esc_html( $package_details ); ?></small></p>
		<?php endif; ?>
	</td>
</tr>
