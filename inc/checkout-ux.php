<?php
/**
 * Checkout UX fixes from the UX audit (2026-11-24).
 *
 * 1) Phone: the old script disabled the "Ďalej" button on page load and enabled it only after the
 *    customer typed into the phone field. A pre-filled phone (returning customer) left the button
 *    disabled with no message, and "+421 905 123 456" or "0905 123 456" were rejected.
 *    Now the button stays enabled. The number is normalised to 09XXXXXXXX (spaces, +421 and 00421
 *    are accepted) and a click on "Ďalej" with an invalid number shows the message at the field,
 *    scrolls to it and stops the step change.
 *
 * 2) Order total next to the order button: the totals table is above the payment methods, so the
 *    COD fee changed the total out of view. The total is repeated right above the button.
 *    The payment block is a checkout fragment, so it refreshes on every update_checkout.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Normalise a Slovak mobile number to 09XXXXXXXX. Returns the input unchanged when it does not fit.
 */
function heba_normalize_sk_phone( $phone ) {
	$raw = preg_replace( '/[\s\-\/\.\(\)]/', '', (string) $phone );
	if ( preg_match( '/^(?:\+|00)421(9\d{8})$/', $raw, $m ) ) {
		$raw = '0' . $m[1];
	}
	return preg_match( '/^09\d{8}$/', $raw ) ? $raw : $phone;
}

// Server side: store the same format the front end shows.
add_filter( 'woocommerce_process_checkout_field_billing_phone', 'heba_normalize_sk_phone' );

add_action( 'wp_enqueue_scripts', function () {
	if ( ! function_exists( 'is_checkout' ) || ! is_checkout() || is_order_received_page() ) {
		return;
	}
	$js = <<<'JS'
jQuery(function ($) {
	var MSG = 'Napíšte prosím mobilné číslo vo formáte 09XX XXX XXX (môže byť aj s +421).';

	function normalize(v) {
		var raw = String(v || '').replace(/[\s\-\/\.\(\)]/g, '');
		var m = raw.match(/^(?:\+|00)421(9\d{8})$/);
		if (m) { raw = '0' + m[1]; }
		return raw;
	}
	function isValid(v) { return /^09\d{8}$/.test(normalize(v)); }

	function field() { return $('input[name="billing_phone"]'); }

	function clearError($f) {
		$f.removeClass('woocommerce-invalid');
		$f.closest('.form-row').removeClass('woocommerce-invalid woocommerce-invalid-phone');
		$f.siblings('.phone-error-message').remove();
	}
	function showError($f) {
		clearError($f);
		$f.addClass('woocommerce-invalid');
		$f.closest('.form-row').addClass('woocommerce-invalid woocommerce-invalid-phone');
		$f.after('<span class="phone-error-message" role="alert">' + MSG + '</span>');
	}
	function check($f, showEmpty) {
		var v = $.trim($f.val());
		if (isValid(v)) {
			clearError($f);
			$f.addClass('woocommerce-validated');
			return true;
		}
		$f.removeClass('woocommerce-validated');
		if (v !== '' || showEmpty) { showError($f); } else { clearError($f); }
		return false;
	}

	// The old version disabled the button until the phone was typed. Make sure it is usable.
	$('#action-next').prop('disabled', false);

	var timer;
	$(document.body).on('input', 'input[name="billing_phone"]', function () {
		var $f = $(this);
		clearTimeout(timer);
		timer = setTimeout(function () { check($f, false); }, 600);
	});
	$(document.body).on('blur', 'input[name="billing_phone"]', function () {
		var $f = $(this);
		if (isValid($f.val())) { $f.val(normalize($f.val())); }
		check($f, false);
	});

	// Capture phase: runs before the multi-step plugin's own click handler.
	document.addEventListener('click', function (e) {
		var btn = e.target.closest && e.target.closest('#action-next');
		if (!btn) { return; }
		var $f = field();
		// Only on the step where the phone field is visible.
		if (!$f.length || !$f.is(':visible')) { return; }
		if (check($f, true)) {
			$f.val(normalize($f.val()));
			return;
		}
		e.preventDefault();
		e.stopImmediatePropagation();
		$('html, body').animate({ scrollTop: $f.offset().top - 220 }, 250);
		$f.trigger('focus');
	}, true);

	// If a pre-filled number is invalid, say so right away.
	var $initial = field();
	if ($initial.length && $.trim($initial.val()) !== '') {
		if (isValid($initial.val())) { $initial.val(normalize($initial.val())); }
		check($initial, false);
	}
});
JS;
	wp_register_script( 'heba-checkout-ux', false, array( 'jquery' ), null, true );
	wp_enqueue_script( 'heba-checkout-ux' );
	wp_add_inline_script( 'heba-checkout-ux', $js );
}, 20 );

/**
 * Order total right above the "Objednať s povinnosťou platby" button.
 */
add_action( 'woocommerce_review_order_before_submit', function () {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return;
	}
	echo '<div class="heba-order-total">';
	echo '<span class="heba-order-total__label">' . esc_html__( 'Celkom k úhrade', 'medizin' ) . '</span> ';
	echo '<span class="heba-order-total__value">';
	wc_cart_totals_order_total_html();
	echo '</span></div>';
} );
