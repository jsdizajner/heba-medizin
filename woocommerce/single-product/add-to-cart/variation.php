<?php

/**
 * Single variation display
 *
 * This is a javascript-based template for single variations (see https://codex.wordpress.org/Javascript_Reference/wp.template).
 * The values will be dynamically replaced after selecting attributes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @todo CHANGE TO DEFAULT DATA VIA FILTER #at Woo v9.7 ENUMS
 * @version 9.3.0
 */

defined('ABSPATH') || exit;

?>
<script type="text/template" id="tmpl-variation-template">
	<div class="woocommerce-variation-description">{{{ data.variation.variation_description }}}</div>
	<div class="woocommerce-variation-price">{{{ data.variation.price_html }}}</div>
	<div class="woocommerce-variation-stock">

	<# if ( data.variation.get_stock_status === "instock" ) { #>
		<i class="fas fa-truck"></i> Termín dodania 1 - 3 dní.<br>

	<# } else if ( data.variation.get_stock_status === "onbackorder" ) { #>
		<span><i class="fas fa-dolly"></i> Na objednávku 3 - 7 dní.</span> <br>

	<# } else if ( data.variation.get_stock_status === "delayed_shipment" ) { #>
		<span><i class="fas fa-dolly"></i> Na objednávku do 14 dní.</span> <br>

	<# } else { #>
		<span class='nostock'><i class="fas fa-times"></i> Nie je na sklade </span>

	<# } #>

	</div>

	<div class="sku_wrapper meta-item">
		<div class="woocommerce-variation-sku"><span id="sku-check">{{{ data.variation.sku || "-" }}}</span></div>
		<div class="woocommerce-variation-availability">{{{ data.variation.availability_html }}}</div>
	</div>
</script>
<script type="text/template" id="tmpl-unavailable-variation-template">
	<p><?php esc_html_e('Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce'); ?></p>
</script>
