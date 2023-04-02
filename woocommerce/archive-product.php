<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

get_header('shop');

$page_sidebar1 = Medizin_Global::instance()->get_sidebar_1();
$page_sidebar2 = Medizin_Global::instance()->get_sidebar_2();

$category_per_page = 4;

if ($page_sidebar1 !== 'none') {
	$category_per_page = 3;
}


?>
	<div id="page-content" class="page-content">
		<div class="container">
			<div class="row">

				<?php Medizin_Templates::render_sidebar('left'); ?>
				<div class="page-main-content">

					<?php
					/**
					 * Setup query to show the ‘services’ post type with ‘8’ posts.
					 * Output the title with an excerpt.
					 */
					$args = array(
						'post_type' => 'bannerad',
						'post_status' => 'publish',
						'posts_per_page' => 4
					);

					$loop = new WP_Query($args);
					?>
					<div class="splide advertisingbanner" id="splide">
						<div class="splide__track">
							<ul class="splide__list">
								<?php while ($loop->have_posts()) : $loop->the_post(); ?>
									<li class="splide__slide">
										<a href="<?php echo get_field("ad_url") ?>">
											<img class="banner" src="<?php echo get_field("banner_image") ?>" alt="Reklamný Slide" id="<?php
											$bannerTagID = get_field('banner_tracking_id');
											if (isset($bannerTagID)) {
												echo get_field('banner_tracking_id');
											} else {
												echo "top-banner-" . get_the_ID();
											};
											?>" onclick="dataLayer.push({'event': 'Banner_Reklama'});">
										</a>
									</li>
								<?php endwhile;
								wp_reset_postdata(); ?>
							</ul>
						</div>
						<div class="splide__progress">
							<div class="splide__progress__bar">
							</div>
						</div>
					</div>
					<?php // END OF ADVERTISING SLIDER
					?>

					<div class="mobile-search">
						<h3 class="text-center">Vyhľadávanie</h3>
						<?php echo do_shortcode('[wcas-search-form]'); ?>
					</div>


					<?php
					/**
					 * woocommerce_archive_description hook.
					 *
					 * @hooked woocommerce_taxonomy_archive_description - 10
					 * @hooked woocommerce_product_archive_description - 10
					 */
					do_action('woocommerce_archive_description');
					?>

					<?php
					$shop_page_display = get_option('woocommerce_shop_page_display', '');

					if (function_exists('is_shop') && is_shop() && $shop_page_display !== '') {
						woocommerce_output_product_categories(array(
							'before' => '<div class="cats tm-swiper tm-slider" data-lg-items="' . $category_per_page . '" data-sm-items="1" data-lg-gutter="30" data-nav="1" data-loop="1"><div class="swiper-inner"><div class="swiper-container"><div class="swiper-wrapper">',
							'after'  => '</div></div></div></div>',
						));
					}
					?>

					<?php if (have_posts()) : ?>

						<?php if (!is_shop() || $shop_page_display !== 'subcategories') : ?>
							<?php
							/**
							 * Hook: woocommerce_before_shop_loop.
							 *
							 * @hooked wc_print_notices - 10
							 * @hooked woocommerce_result_count - 20
							 * @hooked woocommerce_catalog_ordering - 30
							 */
							do_action('woocommerce_before_shop_loop');
							?>

							<?php if (wc_get_loop_prop('total')) { ?>
								<?php
								$classes = [
									'medizin-main-post',
									'medizin-grid-wrapper',
									'medizin-product',
									'style-grid-01',
								];

								$grid_class = 'medizin-grid';
								$lg_columns = intval(Medizin::setting('shop_archive_lg_columns'));
								$md_columns = Medizin::setting('shop_archive_md_columns');
								$sm_columns = Medizin::setting('shop_archive_sm_columns');

								if ('none' === Medizin_Global::instance()->get_sidebar_status()) {
									$lg_columns++;
								}

								$grid_class .= " grid-lg-{$lg_columns}";
								$grid_class .= " grid-md-{$md_columns}";
								$grid_class .= " grid-sm-{$sm_columns}";

								$grid_options = [
									'type'          => 'grid',
									'columns'       => $lg_columns,
									'columnsTablet' => $md_columns,
									'columnsMobile' => $sm_columns,
									'gutter'        => 30,
								];
								?>
								<div class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-grid="<?php echo esc_attr(wp_json_encode($grid_options)); ?>">
									<div class="<?php echo esc_attr($grid_class); ?>">
										<div class="grid-sizer"></div>
										<?php
										while (have_posts()) {
											the_post();
											//the_content();
											/**
											 * Hook: woocommerce_shop_loop.
											 *
											 * @hooked WC_Structured_Data::generate_product_data() - 10
											 */
											do_action('woocommerce_shop_loop');

											wc_get_template_part('content-product');
										}
										?>
									</div>
								</div>

							<?php } ?>

							<?php
							/**
							 * woocommerce_after_shop_loop hook.
							 *
							 * @hooked woocommerce_pagination - 10
							 */
							do_action('woocommerce_after_shop_loop');
							?>
						<?php endif; ?>

					<?php else : ?>

						<?php
						/**
						 * Hook: woocommerce_no_products_found.
						 *
						 * @hooked wc_no_products_found - 10
						 */
						do_action('woocommerce_no_products_found');
						?>

					<?php endif; ?>
				</div>

				<?php Medizin_Templates::render_sidebar('right'); ?>

			</div>
		</div>
	</div>
<?php
get_footer('shop');
