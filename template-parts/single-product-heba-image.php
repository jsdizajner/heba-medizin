<?php
defined( 'ABSPATH' ) || exit;
global $post, $product;

$heba_image = new \HEBA_IMAGE\HEBA_IMAGE($product->get_id(), ['alt' => $product->get_name()]);

$classes = "feature-style-single";
$attributes = [
		'data-image-id' => $heba_image->get_adc_src(),
		'class' => 'product-main-image attachment-woocommerce_thumbnail size-woocommerce_thumbnail',
		'decoding' => 'async',
		'loading' => 'lazy',
];
?>
<div class="<?php echo esc_attr( $classes ); ?>">

	<div class="tm-sticky-column">
		<div class="woo-single-images">
			<div class="feature-style-slider medizin-light-gallery">
				<div class="woo-single-gallery">
					<div class="tm-swiper medizin-main-swiper" data-lg-items="1" data-lg-gutter="30" data-speed="1000" data-effect="slide" data-auto-height="1">
						<div class="swiper-inner">
							<div class="swiper-container swiper-container-initialized swiper-container-horizontal swiper-container-autoheight">
								<div class="swiper-wrapper" style="height: 570px; transform: translate3d(0px, 0px, 0px);">
									<div class="zoom swiper-slide product-main-image swiper-slide-visible swiper-slide-active" data-sub-html="<h4><?php $product->get_name(); ?></h4>" data-src="<?php echo $heba_image->get_current_image($attributes, 'src'); ?>">
										<?php echo $heba_image->get_current_image($attributes); ?>
									</div>
								</div>
								<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>


