<?php

/**
 * Class for all Vendor template modification
 *
 * @version 1.0
 */
class Martfury_DCVendors {

	/**
	 * Construction function
	 *
	 * @since  1.0
	 * @return Martfury_Vendor
	 */
	function __construct() {
		// Check if Woocomerce plugin is actived
		if ( ! in_array( 'dc-woocommerce-multi-vendor/dc_product_vendor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return;
		}

		add_filter( 'wcmp_sold_by_text_after_products_shop_page', '__return_false' );

		add_action( 'woocommerce_after_shop_loop_item_title', array(
			$this,
			'template_loop_sold_by',
		), 7 );

		add_action( 'woocommerce_after_shop_loop_item_title', array(
			$this,
			'template_loop_sold_by',
		), 120 );

		add_action( 'martfury_woo_after_shop_loop_item_title', array(
			$this,
			'template_loop_sold_by',
		), 7 );

		add_action( 'martfury_single_product_header', array(
			$this,
			'template_loop_sold_by',
		) );

		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'template_loop_show_sold_by' ), 6 );

		add_action( 'init', array( $this, 'hooks' ) );

		add_filter( 'body_class', array( $this, 'wc_body_class' ) );


	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @since 1.0
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 */
	function wc_body_class( $classes ) {

		if( function_exists('wcmp_vendor_dashboard_page_id') ) {

			if ( is_page( wcmp_vendor_dashboard_page_id() ) ) {
				$classes[] = 'mf-vendor-dashboard-page';
			}
		}


		return $classes;

	}

	function hooks() {
		global $WCMp;
		if ( empty( $WCMp ) ) {
			return;
		}

		$store_header = intval( martfury_get_option( 'vendor_store_header' ) );

		if ( ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! $store_header ) {
			remove_action( 'woocommerce_archive_description', array(
				$WCMp->frontend,
				'product_archive_vendor_info',
			), 10 );
		}

	}

	function template_loop_show_sold_by() {
		if ( martfury_get_option( 'catalog_vendor_name' ) != 'display' ) {
			return;
		}

		echo '<div class="mf-vendor-name">';
		$this->template_loop_sold_by();
		echo '</div>';
	}


	function template_loop_sold_by() {
		if ( ! function_exists( 'get_wcmp_vendor_settings' ) ) {
			return;
		}

		if ( ! function_exists( 'get_wcmp_product_vendors' ) ) {
			return;
		}

		if ( 'Enable' !== get_wcmp_vendor_settings( 'sold_by_catalog', 'general' ) ) {
			return;
		}

		if ( martfury_get_option( 'catalog_vendor_name' ) == 'hidden' ) {
			return;
		}


		global $post;
		$vendor = get_wcmp_product_vendors( $post->ID );

		if ( empty( $vendor ) ) {
			return;
		}

		$sold_by_text = apply_filters( 'wcmp_sold_by_text', esc_html__( 'Sold By:', 'martfury' ) );
		echo '<div class="sold-by-meta">';
		echo '<span class="sold-by-label">' . $sold_by_text . ' ' . '</span>';
		echo sprintf(
			'<a href="%s">%s</a>',
			esc_url( $vendor->permalink ),
			$vendor->user_data->display_name
		);
		echo '</div>';
	}

}

