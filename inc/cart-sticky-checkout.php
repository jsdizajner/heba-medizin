<?php
/**
 * Cart page on mobile: "Prejsť do pokladne →" bar fixed right above the bottom navigation.
 *
 * The native checkout button is at the very bottom of the cart, below the coupon form, out of
 * thumb reach. The bar shows the subtotal and the button; it hides itself while the native
 * button is on screen, so there are never two buttons in view.
 * Only below 961px, where the mobile bottom navigation is shown.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_footer', function () {
	if ( ! function_exists( 'is_cart' ) || ! is_cart() || ! WC()->cart || WC()->cart->is_empty() ) {
		return;
	}
	?>
	<div class="heba-sticky-checkout" id="HebaStickyCheckout" hidden>
		<div class="heba-sticky-checkout__total">
			<span class="heba-sticky-checkout__label"><?php esc_html_e( 'Medzisúčet', 'medizin' ); ?></span>
			<span class="heba-sticky-checkout__value" id="HebaStickyCheckoutTotal"><?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?></span>
		</div>
		<a class="heba-sticky-checkout__button" href="<?php echo esc_url( wc_get_checkout_url() ); ?>">
			<?php esc_html_e( 'Prejsť do pokladne', 'medizin' ); ?> <span aria-hidden="true">&rarr;</span>
		</a>
	</div>
	<style>
		.heba-sticky-checkout { display: none; }
		@media only screen and (max-width: 960px) {
			.heba-sticky-checkout:not([hidden]) {
				display: flex;
				align-items: center;
				justify-content: space-between;
				gap: 12px;
				position: fixed;
				left: 0;
				right: 0;
				bottom: var(--heba-mbn-h, 104px);
				z-index: 999998;
				padding: 10px 16px;
				background: #fff;
				border-top: 1px solid #e3e8ee;
				box-shadow: 0 -6px 16px rgba(21, 51, 72, .08);
				transition: transform .2s ease, opacity .2s ease, visibility 0s linear 0s;
			}
			.heba-sticky-checkout.is-away {
				transform: translateY(110%);
				opacity: 0;
				pointer-events: none;
				visibility: hidden;
				transition: transform .2s ease, opacity .2s ease, visibility 0s linear .2s;
			}
			.heba-sticky-checkout__total {
				display: flex;
				flex-direction: column;
				line-height: 1.2;
				min-width: 0;
			}
			.heba-sticky-checkout__label {
				font-size: 12px;
				color: #6b6b6b;
			}
			.heba-sticky-checkout__value,
			.heba-sticky-checkout__value .amount {
				font-size: 18px;
				font-weight: 700;
				color: #1f2933 !important;
			}
			.heba-sticky-checkout__button {
				flex: 0 0 auto;
				display: inline-flex;
				align-items: center;
				gap: 6px;
				min-height: 48px;
				padding: 0 20px;
				border-radius: 999px;
				background: #2b6fa8;
				color: #fff !important;
				font-weight: 600;
				font-size: 16px;
				text-decoration: none;
			}
			.heba-sticky-checkout__button:hover,
			.heba-sticky-checkout__button:focus {
				background: #235b8a;
				color: #fff !important;
			}
			body.heba-has-sticky-checkout {
				padding-bottom: calc(var(--heba-mbn-h, 104px) + 72px);
			}
		}
	</style>
	<script>
	(function () {
		var bar = document.getElementById('HebaStickyCheckout');
		if (!bar) { return; }
		var nav = document.querySelector('.mobile-navigation-bottom');
		function setNavHeight() {
			var h = nav && nav.offsetHeight ? nav.offsetHeight : 0;
			document.documentElement.style.setProperty('--heba-mbn-h', h + 'px');
		}
		function refresh() {
			setNavHeight();
			var native = document.querySelector('.wc-proceed-to-checkout .checkout-button');
			if (!native) { bar.hidden = true; document.body.classList.remove('heba-has-sticky-checkout'); return; }
			bar.hidden = false;
			document.body.classList.add('heba-has-sticky-checkout');
			var sub = document.querySelector('.cart_totals .cart-subtotal td, .cart_totals .order-total td');
			if (sub) {
				document.getElementById('HebaStickyCheckoutTotal').innerHTML = sub.innerHTML;
			}
			if ('IntersectionObserver' in window) {
				if (bar._io) { bar._io.disconnect(); }
				bar._io = new IntersectionObserver(function (entries) {
					bar.classList.toggle('is-away', entries[0].isIntersecting);
				});
				bar._io.observe(native);
			}
		}
		refresh();
		window.addEventListener('resize', setNavHeight);
		if (window.jQuery) {
			jQuery(document.body).on('updated_cart_totals updated_wc_div wc_cart_emptied', refresh);
		}
	})();
	</script>
	<?php
}, 20 );
