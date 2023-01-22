<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$product_id = $product->get_id();

$custom_thumbnail_size = false;

if ( isset( $settings ) ) {
	$custom_thumbnail_size = Medizin_Image::elementor_parse_image_size( $settings, false );
}
?>
<div <?php wc_product_class( 'grid-item', $product ); ?>>
	<div class="product-wrapper">
		<div class="product-thumbnail">
			<?php
			if ( function_exists( 'woocommerce_show_product_loop_sale_flash' ) ) {
				woocommerce_show_product_loop_sale_flash();
			}
			?>

			<div class="thumbnail">
				<?php woocommerce_template_loop_product_link_open(); ?>

				<div class="product-main-image">
					<?php
					if ( \HEBA_CORE\HEBA_CORE::is_imported_product_image($product->get_id()) ) {
						echo '<img width="480" height="500" src="'. HEBA_CORE\HEBA_CORE::get_product_thumbnail($product->get_id()) .'" class="wp-post-image" alt="" decoding="async" loading="lazy">';
					}
					else {
						$thumbnail_id = get_post_thumbnail_id();
						if ( ! $custom_thumbnail_size ) {
							Medizin_Woo::instance()->get_product_image( array(
									'id'          => $thumbnail_id,
									'extra_class' => 'wp-post-image',
							) );
						} else {
							Medizin_Image::the_attachment_by_id( array(
									'id'   => $thumbnail_id,
									'size' => $custom_thumbnail_size,
							) );
						}
					}
					?>
				</div>

				<?php
				$image_hover_enable = Medizin::setting( 'shop_archive_hover_image' );
				if ( '1' === $image_hover_enable && ! Medizin::is_handheld() ) {
					$attachment_ids = $product->get_gallery_image_ids();
					if ( $attachment_ids && ! empty( $attachment_ids ) ) {
						?>
						<div class="product-hover-image">
							<?php
							if ( ! $custom_thumbnail_size ) {
								Medizin_Woo::instance()->get_product_image( array(
									'id' => $attachment_ids[0],
								) );
							} else {
								Medizin_Image::the_attachment_by_id( array(
									'id'   => $attachment_ids[0],
									'size' => $custom_thumbnail_size,
								) );
							}
							?>
						</div>
						<?php
					}
				}
				?>

				<?php woocommerce_template_loop_product_link_close(); ?>
			</div>

			<div class="product-actions">
				<?php
				$button_settings = [
					'tooltip_position' => 'top',
					'style'            => '01',
				];

				woocommerce_template_loop_add_to_cart();

				Medizin_Woo::instance()->get_quick_view_button_template( $button_settings );
				Medizin_Woo::instance()->get_wishlist_button_template( $button_settings );
				Medizin_Woo::instance()->get_compare_button_template( $button_settings );
				?>
			</div>
		</div>

		<div class="product-info">
			<?php
			do_action( 'woocommerce_before_shop_loop_item_title' );

			/**
			 * woocommerce_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_template_loop_product_title - 10
			 */
			do_action( 'woocommerce_shop_loop_item_title' );

			/**
			 * woocommerce_after_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
			?>
		</div>
	</div>
</div>
