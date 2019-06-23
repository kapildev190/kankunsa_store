<?php
if ( is_page_template( 'template-coming-soon-page.php' ) ) {
	return;
}

if ( ! function_exists( 'woocommerce_mini_cart' ) ) {
	return;
}

?>
<div id="mf-cart-mobile" class="mf-cart-mobile mf-els-item woocommerce mini-cart">
    <div class="widget-canvas-content">
        <div class="widget_shopping_cart_content">
			<?php woocommerce_mini_cart(); ?>
        </div>
        <div class="widget-footer-cart">
            <a href="#" class="close-cart-mobile"><?php esc_html_e('Close', 'martfury'); ?></a>
        </div>
    </div>
</div>
