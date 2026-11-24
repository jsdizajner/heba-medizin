<?php
/**
 * Slovak fallbacks for strings that show up in English on the site
 * (result count on shop / category / search pages, FiboSearch "in" in suggestions).
 *
 * Applied only while the string is still untranslated, so an updated language pack wins.
 * The result count is matched by its English text in any text domain: on this site it stays
 * English although it is printed by the standard WooCommerce template, so the domain is not
 * a reliable key.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Slovak text for an untranslated English source string, or null.
 */
function heba_sk_fallback_for( $text, $domain ) {
	static $map = null;
	if ( null === $map ) {
		$map = array(
			'Showing the single result'                   => 'Zobrazený 1 produkt',
			'Showing all %d result'                       => 'Počet produktov: %d',
			'Showing all %d results'                      => 'Počet produktov: %d',
			'Showing %1$d&ndash;%2$d of %3$d result'      => 'Zobrazené %1$d&ndash;%2$d z %3$d produktov',
			'Showing %1$d&ndash;%2$d of %3$d results'     => 'Zobrazené %1$d&ndash;%2$d z %3$d produktov',
			"Showing %1\$d\u{2013}%2\$d of %3\$d results" => "Zobrazené %1\$d\u{2013}%2\$d z %3\$d produktov",
		);
	}
	if ( isset( $map[ $text ] ) ) {
		return $map[ $text ];
	}
	if ( 'ajax-search-for-woocommerce' === $domain && 'in' === $text ) {
		return 'v';
	}
	return null;
}

add_filter( 'gettext', function ( $translation, $text, $domain ) {
	if ( $translation !== $text ) {
		return $translation;
	}
	$sk = heba_sk_fallback_for( $text, $domain );
	return null === $sk ? $translation : $sk;
}, 20, 3 );

add_filter( 'gettext_with_context', function ( $translation, $text, $context, $domain ) {
	if ( $translation !== $text ) {
		return $translation;
	}
	$sk = heba_sk_fallback_for( $text, $domain );
	return null === $sk ? $translation : $sk;
}, 20, 4 );

function heba_sk_fallback_plural( $translation, $single, $plural, $domain ) {
	if ( $translation !== $single && $translation !== $plural ) {
		return $translation;
	}
	$sk = heba_sk_fallback_for( $translation, $domain );
	return null === $sk ? $translation : $sk;
}

add_filter( 'ngettext', function ( $translation, $single, $plural, $number, $domain ) {
	return heba_sk_fallback_plural( $translation, $single, $plural, $domain );
}, 20, 5 );

add_filter( 'ngettext_with_context', function ( $translation, $single, $plural, $number, $context, $domain ) {
	return heba_sk_fallback_plural( $translation, $single, $plural, $domain );
}, 20, 6 );
