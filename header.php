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
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
		<?php wp_head(); ?>
		<!-- Google tag (gtag.js) --> <script async
											  src="https://www.googletagmanager.com/gtag/js?id=AW-625375761"></script> <script>
			window.dataLayer = window.dataLayer || []; function
			gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW625375761'); </script>
	</head>

<body <?php body_class(); ?> <?php Medizin::body_attributes(); ?>>

<?php wp_body_open(); ?>

<?php Medizin_Templates::pre_loader(); ?>

<div id="page" class="site">
	<div class="content-wrapper">
<?php Medizin_Templates::slider('above'); ?>
<?php Medizin_Top_Bar::instance()->render(); ?>

<?php get_template_part('template-parts/header/entry'); ?>

<?php Medizin_Templates::slider('below'); ?>
<?php Medizin_Title_Bar::instance()->render(); ?>
