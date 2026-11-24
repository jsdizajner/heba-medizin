<?php
/**
 * Slovak fallbacks for strings that show up in English on the site
 * (WooCommerce result count, FiboSearch "in" in suggestions).
 *
 * Applied only while the string is still untranslated, so an updated language pack wins.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'gettext', 'heba_sk_fallback_gettext', 20, 3 );
add_filter( 'gettext_with_context', function ( $translation, $text, $context, $domain ) {
	return heba_sk_fallback_gettext( $translation, $text, $domain );
}, 20, 4 );

function heba_sk_fallback_gettext( $translation, $text, $domain ) {
	if ( $translation !== $text ) {
		return $translation;
	}
	if ( 'woocommerce' === $domain && 'Showing the single result' === $text ) {
		return 'Zobrazený 1 produkt';
	}
	if ( 'ajax-search-for-woocommerce' === $domain && 'in' === $text ) {
		return 'v';
	}
	return $translation;
}

add_filter( 'ngettext', 'heba_sk_fallback_ngettext', 20, 5 );
add_filter( 'ngettext_with_context', function ( $translation, $single, $plural, $number, $context, $domain ) {
	return heba_sk_fallback_ngettext( $translation, $single, $plural, $number, $domain );
}, 20, 6 );

function heba_sk_fallback_ngettext( $translation, $single, $plural, $number, $domain ) {
	if ( 'woocommerce' !== $domain || ( $translation !== $single && $translation !== $plural ) ) {
		return $translation;
	}
	// Wording avoids Slovak plural forms: "Počet produktov: 32", "1–20 z 32 produktov".
	if ( 0 === strpos( $single, 'Showing all %d result' ) ) {
		return 'Počet produktov: %d';
	}
	if ( 0 === strpos( $single, 'Showing %1$d&ndash;%2$d of %3$d result' ) ) {
		return 'Zobrazené %1$d&ndash;%2$d z %3$d produktov';
	}
	return $translation;
}
