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

if ( \HEBA_CORE\HEBA_CORE::is_imported_product_image($product->get_id()) ) {
	echo '<img width="480" height="600" src="'. HEBA_CORE\HEBA_CORE::get_product_thumbnail($product->get_id()) .'" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" decoding="async" loading="lazy">';
}
else {
	$attachment_ids = $product->get_gallery_image_ids();

	if ( has_post_thumbnail() ) {
		$thumbnail_id = (int) get_post_thumbnail_id();
		array_unshift( $attachment_ids, $thumbnail_id );
	}

	$attachment_id = $attachment_ids[0];
	$main_image_html = Medizin_Image::get_attachment_by_id(array(
		'id' => $attachment_id,
		'size' => '510x510',
	));

	echo '' . $main_image_html;
}



