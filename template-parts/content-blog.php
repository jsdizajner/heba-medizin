<?php
/**
 * Template part for displaying blog content in home.php, archive.php.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Medizin
 * @since   1.0
 */
$style   = Medizin::setting( 'blog_archive_style', 'grid' );
$classes = [
	'medizin-main-post',
	'medizin-grid-wrapper',
	'medizin-blog',
	'medizin-animation-zoom-in',
	"medizin-blog-" . $style,
	'medizin-blog-overlay-style-float-02',
];

$lg_columns = $md_columns = $sm_columns = 1;

$sidebar_status = Medizin_Global::instance()->get_sidebar_status();

// Handle Columns
switch ( $style ) {
	case 'grid':
		$lg_columns = 3;
		$md_columns = 2;
		$sm_columns = 1;
		break;
	case 'grid-wide' :
		$lg_columns = 4;
		$md_columns = 2;
		$sm_columns = 1;
		break;
}

if ( 'none' !== $sidebar_status ) {
	$lg_columns--;
}

$grid_options = [
	'type'          => ( '1' === Medizin::setting( 'blog_archive_masonry' ) ) ? 'masonry' : 'grid',
	'columns'       => $lg_columns,
	'columnsTablet' => $md_columns,
	'columnsMobile' => $sm_columns,
	'gutter'        => 30,
];

$caption_style = Medizin::setting( 'blog_archive_caption_style' );
$classes[]     = 'medizin-blog-caption-style-' . $caption_style;

if ( have_posts() ) : ?>
	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
	     data-grid="<?php echo esc_attr( wp_json_encode( $grid_options ) ); ?>"
	>
		<div class="medizin-grid">
			<?php if ( in_array( $style, array( 'grid', 'grid-02', 'grid-wide' ) ) ) : ?>
				<div class="grid-sizer"></div>
			<?php endif; ?>

			<?php while ( have_posts() ) : the_post();
				$classes = array( 'grid-item', 'post-item' );
				?>
				<div <?php post_class( implode( ' ', $classes ) ); ?>>
					<div class="post-wrapper medizin-box">

						<?php if ( has_post_thumbnail() ) { ?>
							<div class="post-feature post-thumbnail medizin-image">
								<a href="<?php the_permalink(); ?>">
									<?php Medizin_Image::the_post_thumbnail( array( 'size' => '480x285' ) ); ?>
								</a>

								<?php Medizin_Post::instance()->the_categories( array(
									'classes'   => 'post-overlay-categories',
									'separator' => ' ',
								) ); ?>

							</div>
						<?php } ?>

						<div class="post-caption">
							<div class="post-meta">
								<div class="inner">
									<?php Medizin_Post::instance()->meta_date_template(); ?>
									<?php Medizin_Post::instance()->meta_view_count_template(); ?>
								</div>
							</div>

							<?php $post_title = get_the_title(); ?>
							<?php if ( empty( $post_title ) ) : ?>
								<div class="post-excerpt">
									<a href="<?php the_permalink(); ?>">
										<?php Medizin_Templates::excerpt( array(
											'limit' => 24,
											'type'  => 'word',
										) ); ?>
									</a>
								</div>
							<?php else: ?>
								<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
							<?php endif; ?>

							<?php
							$read_more_text = esc_html__( 'Read more', 'medizin' );

							Medizin_Templates::render_button( [
								'style'         => 'text',
								'text'          => $read_more_text,
								'icon'          => 'far fa-long-arrow-right',
								'icon_align'    => 'right',
								'link'          => [
									'url' => get_the_permalink(),
								],
								'size'          => 'nm',
								'wrapper_class' => 'post-read-more',
							] );
							?>
						</div>

					</div>
				</div>
			<?php endwhile; ?>


		</div>

		<div class="medizin-grid-pagination">
			<?php Medizin_Templates::paging_nav(); ?>
		</div>
	</div>

<?php else : get_template_part( 'template-parts/content', 'none' ); ?>
<?php endif; ?>
