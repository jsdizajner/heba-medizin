<?php
/**
 * Result count, in Slovak (heba-medizin).
 *
 * The standard WooCommerce strings stayed in English on the site, so the text is set here.
 * Wording avoids Slovak plural forms.
 *
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;
?>
<p class="woocommerce-result-count" <?php echo ( empty( $orderedby ) || 1 === intval( $total ) ) ? '' : 'role="alert" aria-relevant="all" data-is-sorted-by="true"'; ?>>
	<?php
	// phpcs:disable WordPress.Security
	if ( 1 === intval( $total ) ) {
		echo 'Zobrazený 1 produkt';
	} elseif ( $total <= $per_page || -1 === $per_page ) {
		printf( 'Počet produktov: %d', $total );
	} else {
		$first = ( $per_page * $current ) - $per_page + 1;
		$last  = min( $total, $per_page * $current );
		printf( 'Zobrazené %1$d&ndash;%2$d z %3$d produktov', $first, $last, $total );
	}
	// phpcs:enable WordPress.Security
	?>
</p>
