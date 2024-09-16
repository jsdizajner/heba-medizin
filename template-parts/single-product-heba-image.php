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
 * @version 9.0.0
 */


/**
 * This template is made to support images of class HEBA_IMAGE
 */

defined( 'ABSPATH' ) || exit;

global $post, $product;

// IMAGE OBJECT
$heba_image = new \HEBA_IMAGE\HEBA_IMAGE( $product->get_id(), [ 'alt' => $product->get_name() ] );

$is_quick_view = apply_filters( 'medizin_content_quick_view', false );

$wrapper_classes = 'woo-single-gallery';

if ( true === $is_quick_view ) {
    $feature_style = 'single';
} else {
    $feature_style = Medizin_Woo::instance()->get_single_product_style();
}

$classes = "feature-style-$feature_style";

$open_gallery = apply_filters( 'woocommerce_single_product_open_gallery', true );
if ( $open_gallery ) {
    $classes .= ' medizin-light-gallery';
}

$main_slider_slides_html   = '';
$thumbs_slider_slides_html = '';

$heba_gallery = $heba_image->get_gallery();

?>
<?php if ( ! empty( $heba_gallery ) ) {
    $number_attachments = count( $heba_gallery );
    ?>
    <div class="<?php echo esc_attr( $classes ); ?>">
        <?php if ( $feature_style === 'single' ) { ?>
            <?php

            $main_image_html = $heba_image->get_image_by_gallery_index( 0, [
                'width'		=> '510',
                'height'	=> '510',
            ] );

            echo '' . $main_image_html;
            ?>
        <?php } elseif ( $feature_style === 'slider' ) {
            if ( $number_attachments > 1 ) {
                $wrapper_classes .= ' has-thumbs-slider';
            }
            ?>
            <div class="<?php echo esc_attr( $wrapper_classes ); ?>">
                <?php
                $heba_gallery_index = 0;
                foreach ( $heba_gallery as $attachment_src ) {
                    $props = [
                        'url'		=> $attachment_src,
                        'title'		=> $product->get_title(),
                    ];

                    if ( ! $props['url'] ) {
                        continue;
                    }

                    $main_slider_slide_image_classes = array( 'zoom swiper-slide' );



                    // IF THIS IS THE FIRST IMAGE, MEANS THAT IT IS MAIN IMAGE
                    if ( $heba_gallery_index === 0 ) {
                        $main_slider_slide_image_classes[] = 'product-main-image';
                    }




                    $attributes_string = 'class="' . esc_attr( implode( ' ', $main_slider_slide_image_classes ) ) . '"';

                    if ( $open_gallery ) {
                        $sub_html = '';

                        if ( ! empty( $props['title'] ) ) {
                            $sub_html .= "<h4>{$props['title']}</h4>";
                        }

                        if ( ! empty( $props['caption'] ) ) {
                            $sub_html .= "<p>{$props['caption']}</p>";
                        }

                        if ( ! empty( $sub_html ) ) {
                            $attributes_string .= ' data-sub-html="' . $sub_html . '"';
                        }

                        $attributes_string .= ' data-src="' . $props['url'] . '"';

                    }

                    $main_image_html = $heba_image->get_image_by_gallery_index( $heba_gallery_index, [
                        'width'		=> '570',
                        'height'	=> '570',
                    ] );

                    $main_slider_slides_html .= sprintf( '<div %s>%s</div>', $attributes_string, $main_image_html );


                    $thumbs_image_html = $heba_image->get_image_by_gallery_index( $heba_gallery_index, [
                        'width'		=> '120',
                        'height'	=> '120',
                    ] );

                    $thumbs_slider_slides_html .= '<div class="swiper-slide">' . $thumbs_image_html . '</div>';




                    $heba_gallery_index++;


                }
                ?>
                <div class="tm-swiper medizin-main-swiper"
                     data-lg-items="1"
                     data-lg-gutter="30"
                     data-speed="1000"
                     data-effect="slide"
                     data-auto-height="1"
                >
                    <div class="swiper-inner">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <?php echo '' . $main_slider_slides_html; ?>
                            </div>
                        </div>
                    </div>
                </div>


                <?php if ( $number_attachments > 1 ) { ?>
                    <div class="tm-swiper medizin-thumbs-swiper"
                         data-lg-items="4"
                         data-lg-gutter="10"
                         data-speed="1000"
                         data-effect="slide"
                         data-slide-to-clicked-slide="1"
                         data-freemode="1">
                        <div class="swiper-inner">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <?php echo '' . $thumbs_slider_slides_html; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <?php


            $heba_gallery_index = 0;

            foreach ( $heba_gallery as $attachment_src ) {


                //$props = wc_get_product_attachment_props( $attachment_id, $post );

                $props = [
                    'url'		=> $attachment_src,
                    'title'		=> $product->get_title(),
                    'caption'	=> '',
                ];



                if ( ! $props['url'] ) {
                    continue;
                }

                $classes     = array( 'zoom' );
                $image_class = implode( ' ', $classes );

                $sub_html = '';

                if ( $props['title'] !== '' ) {
                    $sub_html .= "<h4>{$props['title']}</h4>";
                }

                if ( $props['caption'] !== '' ) {
                    $sub_html .= "<p>{$props['caption']}</p>";
                }

                $image = $heba_image->get_image_by_gallery_index( $heba_gallery_index, [
                    'width'  => '845',
                    'height' => '9999',
                ] );

                $_link = $props['url'];

                if ( $open_gallery === false ) {
                    $_link = get_the_permalink();
                }

                echo sprintf( '<a href="%s" class="%s" data-sub-html="%s">%s</a>', esc_url( $_link ), esc_attr( $image_class ), $sub_html, $image );


                $heba_gallery_index++;

            }
            ?>
        <?php } ?>
    </div>
<?php } else {
    echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), esc_attr__( 'Placeholder', 'medizin' ) ), $post->ID );
}
?>
