<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.0.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="electron-lost-reset-password-wrapper row electron-justify-center">
    <div class="col-12 col-md-10 col-lg-5">
        <?php do_action( 'woocommerce_before_lost_password_form' ); ?>
        <form method="post" class="woocommerce-ResetPassword lost_reset_password">

            <p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'electron' ) ); ?></p>

            <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first electron-flex">
                <label for="user_login"><?php esc_html_e( 'Username or email', 'electron' ); ?></label>
                <input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" aria-required="true" />
            </p>

            <div class="clear"></div>

            <?php do_action( 'woocommerce_lostpassword_form' ); ?>

            <p class="woocommerce-form-row form-row">
                <input type="hidden" name="wc_reset_password" value="true" />
                <button type="submit" class="electron-btn-large electron-btn electron-btn-primary" value="<?php esc_attr_e( 'Reset password', 'electron' ); ?>"><?php esc_html_e( 'Reset password', 'electron' ); ?></button>
            </p>

            <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

        </form>
        <?php do_action( 'woocommerce_after_lost_password_form' ); ?>
    </div>
</div>
