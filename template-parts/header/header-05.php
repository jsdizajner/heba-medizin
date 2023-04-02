<header id="page-header" <?php Medizin_Header::instance()->get_wrapper_class(); ?>>
	<div class="page-header-place-holder"></div>
	<div id="page-header-inner" class="page-header-inner" data-sticky="1">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="header-wrap">
						<?php Medizin_THA::instance()->header_wrap_top(); ?>

						<?php get_template_part( 'template-parts/branding' ); ?>

						<div class="header-right">
							<div id="header-right-inner" class="header-right-inner">
								<?php Medizin_THA::instance()->header_right_top(); ?>

								<?php Medizin_Header::instance()->print_language_switcher(); ?>

								<?php Medizin_Header::instance()->print_social_networks(); ?>

								<?php Medizin_Woo::instance()->render_mini_cart(); ?>

								<?php Medizin_Header::instance()->print_login_button(); ?>

								<?php Medizin_Header::instance()->print_search(); ?>

								<?php Medizin_Header::instance()->print_button( array( 'size' => 'xs' ) ); ?>

								<?php Medizin_THA::instance()->header_right_bottom(); ?>
							</div>

							<?php Medizin_Header::instance()->print_open_canvas_menu_button(); ?>

							<?php Medizin_Header::instance()->print_open_mobile_menu_button(); ?>

							<?php Medizin_Header::instance()->print_more_tools_button(); ?>
						</div>

						<?php Medizin_THA::instance()->header_wrap_bottom(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php get_template_part( 'template-parts/off-canvas' ); ?>
</header>
