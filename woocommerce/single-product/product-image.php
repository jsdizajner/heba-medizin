<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

global $post, $product;



$heba_image = new \HEBA_IMAGE\HEBA_IMAGE($product->get_id());
if ($heba_image->is_heba_image()) {
	get_template_part( 'template-parts/single-product','heba-image' );
} else {
	get_template_part( 'template-parts/single-product','medizin-image' );
}




