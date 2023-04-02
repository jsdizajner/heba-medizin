<header id="page-header" <?php Medizin_Header::instance()->get_wrapper_class(); ?>>
	<div class="page-header-place-holder php3"></div>
	<div id="page-header-inner" class="page-header-inner" data-sticky="1">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="header-wrap">
						<?php Medizin_THA::instance()->header_wrap_top(); ?>
						<?php get_template_part('template-parts/branding'); ?>
						<div class="header-right">
							<div class="header-right-outer">
								<?php echo do_shortcode('[fibosearch]'); ?>
								<div class="header-right-wrap">
									<!--
									<div id="header-right-inner" class="header-right-inner">

										<?php Medizin_THA::instance()->header_right_top(); ?>

										<?php Medizin_Header::instance()->print_language_switcher(); ?>

										<?php Medizin_Header::instance()->print_social_networks(); ?>

										<?php Medizin_Header::instance()->print_wishlist_button(['style' => 'svg']); ?>

										<?php Medizin_Woo::instance()->render_mini_cart(); ?>

										<?php Medizin_Header::instance()->print_login_button(['style' => 'svg']); ?>

										<?php Medizin_Header::instance()->print_button(array('size' => 'xs')); ?>

										<?php Medizin_THA::instance()->header_right_bottom(); ?>
									</div>
									-->
								</div>
							</div>

							<?php Medizin_Woo::instance()->render_mini_cart(); ?>
							<?php Medizin_Header::instance()->print_login_button(['style' => 'svg']); ?>
							<?php Medizin_Header::instance()->print_open_mobile_menu_button(['style' => '02']); ?>

						</div>

						<?php Medizin_THA::instance()->header_wrap_bottom(); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="page-header-bottom">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div class="page-header-bottom-inner">
							<div class="row">
								<div class="col-xl-12 page-navigation-wrap">
									<?php get_template_part('template-parts/navigation'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
