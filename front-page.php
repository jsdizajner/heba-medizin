<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Medizin
 * @since   1.0
 */
get_header();
$slides = carbon_get_theme_option( 'heba_crb_slider' );


if (!empty($slides)) { ?>
<div class="container d-none d-md-block">
    <div class="row">
        <div class="col-md-12">
            <section class="splide" aria-label="Image Slider" id="slider1">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php
                        foreach ($slides as $slide) {
                            echo '<li class="splide__slide">';
                            echo '<a href="'. $slide["url"] .'">';
                            echo '<img src="'. $slide["slider-image-desktop"] .'" class="img-fluid" />';
                            echo '</a>';
                            echo '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </section>

        </div>
    </div>
</div>

<div class="container-fluid d-sm-block d-md-none">
    <div class="row no-gutters p-0 m-0">
        <div class="col-sm-12">
            <section class="splide" aria-label="Image Slider" id="slider2">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php
                        foreach ($slides as $slide) {
                            echo '<li class="splide__slide">';
                            echo '<a href="'. $slide["url"] .'">';
                            echo '<img src="'. $slide["slider-image-mobile"] .'" class="img-fluid" />';
                            echo '</a>';
                            echo '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </section>
        </div>
    </div>
</div>

    <script>
        const splide = new Splide('#slider1', {
            type   : 'loop',
            autoplay: true,
            interval: 5000,
        } );
        splide.mount();

        const splideM = new Splide('#slider2', {
            type   : 'loop',
            mediaQuery: 'max',
            breakpoints: {
                760: {
                    arrows: false,
                },
            },
            autoplay: true,
            interval: 5000,
        } );
        splideM.mount();
    </script>

<?php
} // END IF

$post_type = get_post_type();

switch ( $post_type ) {
	default:
		get_template_part( 'template-parts/content-single', 'page' );
		break;
}

get_footer();
