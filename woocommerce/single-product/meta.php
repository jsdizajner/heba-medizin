<?php

/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see           https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @todo UPDATED ENUMS
 * @version       9.7.0
 */
//use Automattic\WooCommerce\Enums\ProductType;

defined('ABSPATH') || exit;

global $product;
?>
<div class="entry-product-meta">

	<?php do_action('woocommerce_product_meta_start'); ?>

	<div class="sku_wrapper meta-item">
		<?php if ($product->is_type('variable') == false) { ?>
			<span class="woocommerce-variation-stock">

				<?php if ($product->get_stock_status() === 'instock') { ?>

					<i class="fas fa-truck"></i> Termín dodania 1 - 3 dní.<br>
					<span style="font-weight: normal;color:#696969;">V prípade výnimiek v doprave Vás budeme kontaktovať e-mailom.</span>

				<?php } elseif ($product->get_stock_status() === 'onbackorder') { ?>

					<span><i class="fas fa-dolly"></i> Na objednávku 3 - 7 dní.</span> <br>
					<span style="font-weight: normal;color:#696969;">V prípade výnimiek v doprave Vás budeme kontaktovať e-mailom.</span>

				<?php  } elseif ($product->get_stock_status() === 'delayed_shipment') { ?>

					<span><i class="fas fa-dolly"></i> Na objednávku do 14 dní.</span> <br>
					<span style="font-weight: normal;color:#696969;">V prípade výnimiek v doprave Vás budeme kontaktovať e-mailom.</span>

				<?php } else { ?>

					<span class='nostock'><i class="fas fa-times"></i> Nie je na sklade.</span>

				<?php } ?>

			</span>
		<?php } ?>
	</div>

	<div class="sku_wrapper meta-item">
		<br>
		<?php if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable') === false)) { ?>
			<label class="meta-label"><?php esc_html_e('Sku:', 'medizin'); ?></label>
			<div class="meta-content">
				<span class="sku">
					<?php if ($sku = $product->get_sku()) : ?>
						<?php Medizin_Helper::e($sku); ?>
					<?php else : ?>
						-
					<?php endif; ?>
				</span>
			</div>
		<?php  } ?>
	</div>

	<?php if (Medizin::setting('single_product_tags_enable') === '1') : ?>
		<?php echo wc_get_product_tag_list($product->get_id(), ' / ', '<div class="tagged_as meta-item"><label class="meta-label">' . _n('Tag:', 'Tags:', count($product->get_tag_ids()), 'medizin') . '</label><div class="meta-content">', '</div></div>'); ?>
	<?php endif; ?>

	<?php do_action('woocommerce_product_meta_end'); ?>

</div>