<?php

/**
 * The header.
 *
 * This is the template that displays all of the <head> section
 *
 * @link     https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package  Heba
 * @since    1.0
 */
?>
	<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php html_class(); ?>>

	<head>
		<!-- Domain Verification -->
		<meta name="facebook-domain-verification" content="c0xpgno74m6goeodmx7gg06gma9xjw" />
		<meta name="facebook-domain-verification" content="4i9urk7hs1b126kabsrqtls1zmuch5" />

		<?php Medizin_THA::instance()->head_top(); ?>
		<meta charset="<?php echo esc_attr(get_bloginfo('charset', 'display')); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="https://gmpg.org/xfn/11">
		<?php if (is_singular() && pings_open(get_queried_object())) : ?>
			<link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url', 'display')); ?>">
		<?php endif; ?>
		<?php Medizin_THA::instance()->head_bottom(); ?>
		<?php wp_head(); ?>

        <!-- Google tag - ADS (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-625375761"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW625375761'); </script>

        <!-- Google tag - GA4 (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-PJN3JVQLV0"></script> <script>   window.dataLayer = window.dataLayer || [];   function gtag(){dataLayer.push(arguments);}   gtag('js', new Date());   gtag('config', 'G-PJN3JVQLV0'); </script>

		<?php do_action('heba_head_tag'); ?>
	</head>

<body <?php body_class(); ?> <?php Medizin::body_attributes(); ?>>

<?php wp_body_open(); ?>
<nav class="mobile-navigation-bottom">
    <ul class="mobile-navigation-bottom-nav-items">
        <li class="mobile-navigation-bottom-nav-item" id="MobileMenuToggler">
            <a href="#" class="mbm-link">
                <i class="mbm-icon">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path id="CategoriesIcon" class="CategoriesIcon " d="M3.5 4.66675H24.5V7.00008H3.5V4.66675ZM3.5 12.8334H17.5V15.1667H3.5V12.8334ZM3.5 21.0001H24.5V23.3334H3.5V21.0001Z" fill="#3886C7"/>
                    </svg>
                </i>
                <span><?php echo __('Categories', 'woocommerce'); ?></span>
            </a>
        </li>
        <li class="mobile-navigation-bottom-nav-item" id="FocusSearchInput">
            <a href="#mobileSearchFocus" class="mbm-link">
                <i class="mbm-icon"><img src="<?php echo esc_url( get_stylesheet_directory_uri()); ?>/assets/images/mobil-hladat.svg" alt="Icon Categories" /></i>
                <span><?php echo __('Search', 'woocommerce'); ?></span>
            </a>
        </li>
        <li class="mobile-navigation-bottom-nav-item">
            <a href="<?php echo wc_get_cart_url(); ?>" class="mbm-link">
                <i class="mbm-icon"><img src="<?php echo esc_url( get_stylesheet_directory_uri()); ?>/assets/images/mobil-kosik.svg" alt="Icon Categories" /></i>
                <span><?php echo __('Cart', 'woocommerce'); ?></span>
            </a>
        </li>
        <li class="mobile-navigation-bottom-nav-item">
            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="mbm-link">
                <i class="mbm-icon"><img src="<?php echo esc_url( get_stylesheet_directory_uri()); ?>/assets/images/mobil-ucet.svg" alt="Icon Categories" /></i>
                <span><?php echo __('Profile', 'woocommerce'); ?></span>
            </a>
        </li>
    </ul>
</nav>
<div class="mobile-menu-overlay" id="MobileMenuOverlay">
    <div class="mbo-top">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/mbo-logo.svg" class="mobile-menu-overlay-logo"/>
        <i class="mbo-icon" id="MBOCloseIcon"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/mobil-krizik-cierny.svg" /></i>
    </div>
    <div class="mbo-menu">
        <ul class="mbo-categories">
            <?php
            $categories = get_terms(['taxonomy' => 'product_cat','hide_empty' => false, 'parent' => 0]);
            foreach ($categories as $category) {
                echo '<li class="mbo-category">
            <a href="' . get_term_link($category->term_id) . '" class="mbo-link">'. $category->name .'</a>
            <i class="mbo-icon"><img src="'. get_stylesheet_directory_uri() .'/assets/images/mbo-chevron.svg" /></i>
        </li>';
            }
            ?>
        </ul>
    </div>
</div>
<script>
    document.getElementById("FocusSearchInput").addEventListener("click", () => {
        document.getElementById("dgwt-wcas-search-input-1").focus();
    });
    var burgerMenu = document.getElementById('MobileMenuToggler');
    var overlay = document.getElementById('MobileMenuOverlay');
    var MBOCloseIcons = document.getElementById('MBOCloseIcon');
    var MBMToggle = document.getElementById('CategoriesIcon');
    MBOCloseIcons.addEventListener('click', function () {
        overlay.classList.toggle("overlay");
    });
    burgerMenu.addEventListener('click',function(){
        this.classList.toggle("close");
        MBMToggle.classList.toggle("CategoriesClose");
        overlay.classList.toggle("overlay");
    });
</script>

<?php Medizin_Templates::pre_loader(); ?>

<div id="page" class="site">
	<div class="content-wrapper">
<?php Medizin_Templates::slider('above'); ?>
<?php Medizin_Top_Bar::instance()->render(); ?>

<?php get_template_part('template-parts/header/entry'); ?>

<?php Medizin_Templates::slider('below'); ?>
<?php Medizin_Title_Bar::instance()->render(); ?>
