<?php
/**
 * Category mega menu.
 *
 * Every top-level item of the desktop primary menu (ul#menu-primary) that links
 * to a product category gets a panel generated from that category's subtree:
 * level 2 as column headings, level 3 as links below them. Empty categories are
 * hidden. The tree is built from one get_terms() call and cached in a transient
 * that is flushed whenever a product category changes.
 *
 * Nothing has to be maintained by hand: editing categories in WooCommerce is
 * enough. The mobile menu (ul#mobile-menu-primary) is left untouched.
 */

defined( 'ABSPATH' ) || exit;

final class Heba_Mega_Menu {

	const CACHE_KEY  = 'heba_mega_menu_tree_v1';
	const CACHE_TTL  = 6 * HOUR_IN_SECONDS;
	const MENU_UL_ID = 'menu-primary';
	const MAX_LEVEL3 = 6;

	public static function init() {
		add_filter( 'wp_nav_menu', array( __CLASS__, 'inject_panels' ), 20, 2 );

		foreach ( array( 'created_product_cat', 'edited_product_cat', 'delete_product_cat' ) as $hook ) {
			add_action( $hook, array( __CLASS__, 'flush' ) );
		}
		// Category drag & drop ordering in admin.
		add_action( 'wp_ajax_woocommerce_term_ordering', array( __CLASS__, 'flush' ), 1 );
		// Product counts (empty categories) are picked up when CACHE_TTL expires.
	}

	public static function flush() {
		delete_transient( self::CACHE_KEY );
	}

	/**
	 * Category tree: [ parent_id => [ term, ... ] ] with only non-empty terms,
	 * ordered as in WooCommerce admin.
	 */
	private static function tree() {
		$tree = get_transient( self::CACHE_KEY );
		if ( is_array( $tree ) ) {
			return $tree;
		}

		$terms = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => false, // core count ignores subcategories, filter below.
				'orderby'    => 'menu_order',
			)
		);

		$tree = array();
		if ( ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				if ( self::product_count( $term ) < 1 ) {
					continue;
				}
				$tree[ (int) $term->parent ][] = array(
					'id'   => (int) $term->term_id,
					'name' => $term->name,
					'url'  => get_term_link( $term ),
				);
			}
		}

		set_transient( self::CACHE_KEY, $tree, self::CACHE_TTL );
		return $tree;
	}

	/** Product count including subcategories (maintained by WooCommerce). */
	private static function product_count( $term ) {
		$count = get_term_meta( $term->term_id, 'product_count_product_cat', true );
		return '' === $count ? (int) $term->count : (int) $count;
	}

	public static function inject_panels( $html, $args ) {
		if ( false === strpos( $html, 'id="' . self::MENU_UL_ID . '"' ) ) {
			return $html;
		}

		$items = wp_get_nav_menu_items( $args->menu instanceof WP_Term ? $args->menu : self::menu_for( $args ) );
		if ( empty( $items ) ) {
			return $html;
		}

		$tree = self::tree();

		$doc = new DOMDocument();
		libxml_use_internal_errors( true );
		$doc->loadHTML( '<?xml encoding="utf-8"?><div id="heba-root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
		libxml_clear_errors();

		$ul = $doc->getElementById( self::MENU_UL_ID );
		if ( ! $ul ) {
			return $html;
		}

		$changed = false;
		foreach ( $items as $item ) {
			if ( (int) $item->menu_item_parent !== 0 || 'product_cat' !== $item->object ) {
				continue;
			}
			$children = isset( $tree[ (int) $item->object_id ] ) ? $tree[ (int) $item->object_id ] : array();
			if ( ! $children ) {
				continue;
			}

			$li = null;
			foreach ( $ul->childNodes as $node ) {
				if ( $node instanceof DOMElement && 'menu-item-' . $item->ID === $node->getAttribute( 'id' ) ) {
					$li = $node;
					break;
				}
			}
			if ( ! $li ) {
				continue;
			}

			$fragment = $doc->createDocumentFragment();
			$fragment->appendXML( self::panel_html( $item, $children, $tree ) );
			$li->appendChild( $fragment );
			$li->setAttribute( 'class', $li->getAttribute( 'class' ) . ' heba-mega-item' );
			$changed = true;
		}

		if ( ! $changed ) {
			return $html;
		}

		$root = $doc->getElementById( 'heba-root' );
		$out  = '';
		foreach ( $root->childNodes as $node ) {
			$out .= $doc->saveHTML( $node );
		}
		return $out;
	}

	private static function menu_for( $args ) {
		$locations = get_nav_menu_locations();
		if ( ! empty( $args->theme_location ) && isset( $locations[ $args->theme_location ] ) ) {
			return $locations[ $args->theme_location ];
		}
		return $args->menu;
	}

	/** Panel markup. Must be well-formed XML (appendXML). */
	private static function panel_html( $item, array $children, array $tree ) {
		$e = static function ( $s ) {
			return htmlspecialchars( (string) $s, ENT_XML1 | ENT_QUOTES, 'UTF-8' );
		};

		$h  = '<div class="heba-mega" role="region" aria-label="' . $e( $item->title ) . '">';
		$h .= '<div class="heba-mega__inner">';
		$h .= '<div class="heba-mega__grid">';

		foreach ( $children as $child ) {
			$h .= '<div class="heba-mega__col">';
			$h .= '<a class="heba-mega__heading" href="' . $e( $child['url'] ) . '">' . $e( $child['name'] ) . '</a>';

			$grand = isset( $tree[ $child['id'] ] ) ? $tree[ $child['id'] ] : array();
			if ( $grand ) {
				$h .= '<ul class="heba-mega__list">';
				// Never show "more (1)": one extra link costs the same space.
				$limit = count( $grand ) > self::MAX_LEVEL3 + 1 ? self::MAX_LEVEL3 : count( $grand );
				foreach ( array_slice( $grand, 0, $limit ) as $g ) {
					$h .= '<li><a href="' . $e( $g['url'] ) . '">' . $e( $g['name'] ) . '</a></li>';
				}
				if ( count( $grand ) > $limit ) {
					$h .= '<li class="heba-mega__more"><a href="' . $e( $child['url'] ) . '">' . $e( sprintf( 'Ďalšie (%d)', count( $grand ) - $limit ) ) . '</a></li>';
				}
				$h .= '</ul>';
			}
			$h .= '</div>';
		}

		$h .= '</div>';
		$h .= '<a class="heba-mega__all" href="' . $e( $item->url ) . '">' . $e( 'Zobraziť všetko: ' . $item->title ) . '</a>';
		$h .= '</div></div>';

		return $h;
	}
}

Heba_Mega_Menu::init();
