<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product;

?>

<?php if ( $product->is_on_sale() ) : ?>
    
    <?php
        // Get price with tax included
        $regular_tax_inc    = wc_get_price_including_tax( $product, [ 'price' => $product->get_regular_price() ] );
        $sale_tax_inc       = wc_get_price_including_tax( $product, [ 'price' => $product->get_sale_price() ] );
    ?>
    <p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo wc_format_sale_price( $regular_tax_inc, $sale_tax_inc ); ?></p>

<?php else : ?>
    <p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo wc_price( wc_get_price_including_tax( $product ) ); ?></p>
<?php endif; ?>