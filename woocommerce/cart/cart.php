<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<section class="section  wow fadeInUp" style="height: 200px; background-image:url(<?php echo get_template_directory_uri() . '/img/farm4.png'; ?>);background-position: center center; background-size: cover;">
<div class="container"> 
	</div>

	<!-- <img src="<?php echo get_template_directory_uri(); ?>/img/product-banner.png" class="animated flipInX" alt="" style="position: absolute; bottom: 0px; right: 100px; width: 180px;"> -->
</section>
<section class="section" style="padding-top: 20px;">
	<div class="container"> 
		<ol class="breadcrumb">
		  <li><a href="<?php echo get_site_url(); ?>">Home</a></li> 
		  <li class="active">Cart</li>
		</ol>

<?php

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table shop_table_responsive cart table table-striped table-responsive">
	<thead>
		<tr>
			
			<th class="product-thumbnail text-center">&nbsp;</th>
			<th class="product-name text-center"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-price text-center"><?php _e( 'Price', 'woocommerce' ); ?></th>
			<th class="product-quantity text-center"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="product-subtotal text-center"><?php _e( 'Total', 'woocommerce' ); ?></th>
			<th class="product-remove text-center">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					

					<td class="product-thumbnail text-center">
						<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $product_permalink ) {
								echo $thumbnail;
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
							}
						?>
					</td>

					<td class="product-name text-center" data-title="<?php _e( 'Product', 'woocommerce' ); ?>">
						<?php
							if ( ! $product_permalink ) {
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
							} else {
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title() ), $cart_item, $cart_item_key );
							}

							// Meta data
							echo WC()->cart->get_item_data( $cart_item );

							// Backorder notification
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
							}
						?>
					</td>

					<td class="product-price text-center" data-title="<?php _e( 'Price', 'woocommerce' ); ?>">
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
					</td>

					<td class="product-quantity text-center" data-title="<?php _e( 'Quantity', 'woocommerce' ); ?>">
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0'
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
						?>
					</td>

					<td class="product-subtotal text-center" data-title="<?php _e( 'Total', 'woocommerce' ); ?>">
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</td>

					<td class="product-remove text-center">
						<?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s"><i class="fa fa-times-circle"></i></a>',
								esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
								__( 'Remove this item', 'woocommerce' ),
								esc_attr( $product_id ),
								esc_attr( $_product->get_sku() )
							), $cart_item_key );
						?>
					</td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions">

				<?php if ( wc_coupons_enabled() ) { ?>
					<div class="coupon form-group">

						<label for="coupon_code"><?php _e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="btn btn-primary" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'woocommerce' ); ?>" />

						<?php do_action( 'woocommerce_cart_coupon' ); ?>
					</div>
				<?php } ?>

				<input type="submit" class="btn btn-primary" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'woocommerce' ); ?>" />

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<div class="cart-collaterals">

	<?php do_action( 'woocommerce_cart_collaterals' ); ?>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
</div>
<img src="<?php echo get_template_directory_uri(); ?>/img/icons/mill.svg" class="icon wow visible-lg fadeInDown" alt="freepik flaticon" data-wow-delay="0.4s" style="position:absolute; bottom: -3px; left: 10.5%;"> 

  <img src="<?php echo get_template_directory_uri(); ?>/img/icons/wheat.svg" class="icon wow visible-lg fadeInUp" alt="freepik flaticon" data-wow-delay="0.4s" style="position:absolute; bottom: -3px; left: 6%;width: 70px;">

  <img src="<?php echo get_template_directory_uri(); ?>/img/icons/wheat.svg" class="icon wow visible-lg fadeInUp" alt="freepik flaticon" data-wow-delay="0.8s" style="position:absolute; bottom: -3px; left: 19%;width: 70px;">

  <img src="<?php echo get_template_directory_uri(); ?>/img/icons/wheat.svg" class="icon wow visible-lg fadeInUp" alt="freepik flaticon" data-wow-delay="0.6s" style="position:absolute; bottom: -3px; left: 24.5%;width: 70px;">

  <img src="<?php echo get_template_directory_uri(); ?>/img/icons/wheat.svg" class="icon wow visible-lg fadeInUp" alt="freepik flaticon" data-wow-delay="0.9s" style="position:absolute; bottom: -3px; left: 30%;width: 70px;">
</section>
