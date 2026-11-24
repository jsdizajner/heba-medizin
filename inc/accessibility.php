<?php
/**
 * Accessibility (WCAG 2.1 AA) fixes, 2026-11-24.
 *
 * - "Preskočiť na obsah" skip link.
 * - Product images: empty or file-name alt text (e.g. "Tlakomer_OMRON_M2_1", "Bez názvu-3")
 *   is replaced by the product name. Only for the product's own image and gallery images.
 * - Accessible names for icon-only controls rendered by the parent theme
 *   (account icon, quantity +/- buttons, mobile menu toggle).
 *
 * Colours and focus styles are in style.css.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_body_open', function () {
	echo '<a class="heba-skip-link" href="#page-content">' . esc_html__( 'Preskočiť na obsah', 'medizin' ) . '</a>';
}, 1 );

/**
 * True when an alt text is missing or looks like a file name.
 */
function heba_is_junk_alt( $alt ) {
	$alt = trim( (string) $alt );
	if ( '' === $alt ) {
		return true;
	}
	if ( preg_match( '/^(image|img|obrazok|photo|bez[\s_-]*n[aá]zvu|aHR0)/iu', $alt ) ) {
		return true;
	}
	// One "word" with digits, underscores or dashes: a file name, not a description.
	return ! preg_match( '/\s/u', $alt ) && preg_match( '/[\d_\-]/', $alt );
}

add_filter( 'wp_get_attachment_image_attributes', function ( $attr, $attachment ) {
	if ( ! isset( $attr['alt'] ) || ! heba_is_junk_alt( $attr['alt'] ) ) {
		return $attr;
	}
	$product = isset( $GLOBALS['product'] ) ? $GLOBALS['product'] : null;
	if ( ! $product instanceof WC_Product ) {
		return $attr;
	}
	$ids = array_map( 'intval', array_merge( array( $product->get_image_id() ), $product->get_gallery_image_ids() ) );
	if ( $product->is_type( 'variable' ) ) {
		foreach ( $product->get_children() as $child_id ) {
			$ids[] = (int) get_post_thumbnail_id( $child_id );
		}
	}
	if ( in_array( (int) $attachment->ID, $ids, true ) ) {
		$attr['alt'] = $product->get_name();
	}
	return $attr;
}, 20, 2 );

add_action( 'wp_enqueue_scripts', function () {
	$js = <<<'JS'
(function () {
	function label(sel, text) {
		document.querySelectorAll(sel).forEach(function (el) {
			if (!el.getAttribute('aria-label') && !el.textContent.trim()) {
				el.setAttribute('aria-label', text);
			}
		});
	}
	function run() {
		label('a.header-login-link', 'Môj účet');
		label('a.mini-cart__button', 'Košík');
		label('.quantity button.decrease, .quantity .decrease', 'Znížiť množstvo');
		label('.quantity button.increase, .quantity .increase', 'Zvýšiť množstvo');
		document.querySelectorAll('.quantity svg, a.header-login-link svg').forEach(function (s) {
			s.setAttribute('aria-hidden', 'true');
			s.setAttribute('focusable', 'false');
		});
	}
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', run);
	} else {
		run();
	}
	// Cart and checkout re-render fragments.
	if (window.jQuery) {
		jQuery(document.body).on('updated_wc_div updated_cart_totals updated_checkout wc_fragments_refreshed', run);
	}
})();
JS;
	wp_register_script( 'heba-a11y', false, array(), null, true );
	wp_enqueue_script( 'heba-a11y' );
	wp_add_inline_script( 'heba-a11y', $js );
}, 20 );
