<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
?>

<?php if ( $product->get_price_html() ) : ?>

	<?php if ( $product->is_on_sale() ) : ?>
		<span class="price"><?php echo $product->get_price_html(); //this will display the sale price ?></span>
	<?php else : ?>
		<span class="price"><?php echo wc_price( wc_get_price_including_tax( $product ) ); ?></span>
	<?php endif; ?>

<?php endif; ?>