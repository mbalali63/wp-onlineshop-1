<?php
/**
* Cart totals
*
* This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
*
* HOWEVER, on occasion WooCommerce will need to update template files and you
* (the theme developer) will need to copy the new files to your theme to
* maintain compatibility. We try to do this as little as possible, but it does
* happen. When this occurs the version of the template file will be bumped and
* the readme will list any important changes.
*
* @see     https://docs.woocommerce.com/document/template-structure/
* @package WooCommerce\Templates
* @version 2.3.6
*/

defined( 'ABSPATH' ) || exit;

?>
<div class="electron-cart-totals cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

    <?php do_action( 'woocommerce_before_cart_totals' ); ?>

    <h5 class="electron-cart-total-title"><?php esc_html_e( 'Cart totals', 'electron' ); ?></h5>

    <div class="electron-cart-totals-inner">

        <div class="cart-subtotal electron-cart-total page-cart">
            <div class="cart-total-label"><?php esc_html_e( 'Subtotal', 'electron' ); ?></div>
            <div class="cart-total-value" data-title="<?php esc_attr_e( 'Subtotal', 'electron' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></div>
        </div>

        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
            <div class="electron-cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                <div class="cart-label"><?php wc_cart_totals_coupon_label( $coupon ); ?></div>
                <div class="cart-value" data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
            </div>
        <?php endforeach; ?>

        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

            <?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

            <?php wc_cart_totals_shipping_html(); ?>

            <?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

        <?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

            <div class="electron-shipping">
                <div class="cart-label"><?php esc_html_e( 'Shipping', 'electron' ); ?></div>
                <div class="cart-value" data-title="<?php esc_attr_e( 'Shipping', 'electron' ); ?>"><?php woocommerce_shipping_calculator(); ?></div>
            </div>

        <?php endif; ?>

        <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
            <div class="electron-fee">
                <div class="cart-label"><?php echo esc_html( $fee->name ); ?></div>
                <div class="cart-value" data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></div>
            </div>
        <?php endforeach; ?>

        <?php
        if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
            $taxable_address = WC()->customer->get_taxable_address();
            $estimated_text  = '';

            if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
                /* translators: %s location. */
                $estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'electron' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
            }

            if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
                foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { 
                    ?>
                    <div class="electron-tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                        <div class="cart-label"><?php echo esc_html( $tax->label ) . $estimated_text; ?></div>
                        <div class="cart-value" data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="electron-tax-total">
                    <div class="cart-label"><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; ?></div>
                    <div class="cart-value" data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></div>
                </div>
                <?php
            }
        }
        ?>

        <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

        <div class="order-total electron-cart-total page-cart">
            <div class="cart-total-label"><?php esc_html_e( 'Total', 'electron' ); ?></div>
            <div class="cart-total-value" data-title="<?php esc_attr_e( 'Total', 'electron' ); ?>"><?php wc_cart_totals_order_total_html(); ?></div>
        </div>

        <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

    </div>

    <div class="electron-wc-proceed-to-checkout">
        <?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
    </div>

    <?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
