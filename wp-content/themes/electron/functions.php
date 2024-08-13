<?php

/**
 *
 * @package WordPress
 * @subpackage electron
 * @since Electron 1.0
 *
**/


define('ELECTRON_DIRECTORY_URI', get_template_directory_uri());
define('ELECTRON_DIRECTORY', get_template_directory());

load_theme_textdomain('electron', get_template_directory() . '/languages');
/*************************************************
## GOOGLE FONTS
*************************************************/
if ( ! function_exists( 'electron_fonts_url' ) ) {
    function electron_fonts_url()
    {
        $fonts_url  = '';
        $roboto     = _x( 'on', 'Roboto font: on or off', 'electron' );

        if (  'off' !== $roboto ) {

            $font_families = array();

            if ( 'off' !== $roboto ) {
                $font_families[] = 'Roboto:300,400,500,600';
            }

            $query_args = array(
                'family' => urlencode( implode( '|', $font_families ) ),
                'subset' => urlencode( 'latin,latin-ext' ),
                'display' => urlencode( 'swap' ),
            );

            $fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
        }

        return esc_url_raw( $fonts_url );
    }
}

/*************************************************
## STYLES AND SCRIPTS
*************************************************/

function electron_theme_scripts()
{
    $rtl = is_rtl() ? 'rtl/' : '';
    // theme inner pages files

    wp_enqueue_style( 'electron-fonts', electron_fonts_url(), array(), null );

    if ( is_404() ) {
        wp_enqueue_style( 'error-page', ELECTRON_DIRECTORY_URI . '/css/error-page.css', false, '1.0' );
    }

    wp_enqueue_style( 'header-top', ELECTRON_DIRECTORY_URI . '/css/header-top.css', false, '1.0' );
    wp_enqueue_style( 'electron-main-style', ELECTRON_DIRECTORY_URI . '/css/style-main.css', false, '1.0' );

    // swiper
    wp_enqueue_script( 'electron-swiper', ELECTRON_DIRECTORY_URI . '/js/swiper/swiper-bundle.min.js', array( 'jquery' ), '1.0', true );

    // electron live search scripts
    wp_enqueue_style( 'electron-ajax-product-search', ELECTRON_DIRECTORY_URI . '/css/ajax-product-search.css', false, '1.0' );
    wp_register_script( 'electron-ajax-product-search', ELECTRON_DIRECTORY_URI. '/js/ajax-product-search.js', array( 'jquery' ), '1.0', false );

    // electron-main
    wp_enqueue_script( 'electron-main', ELECTRON_DIRECTORY_URI . '/js/scripts.js', array( 'jquery' ), '1.0', true );
    wp_localize_script( 'electron-main', 'electron_vars', electron_theme_all_settings() );

    wp_enqueue_style( 'electron-page-hero', ELECTRON_DIRECTORY_URI . '/css/page-hero.css', false );

    wp_register_style( 'electron-deals', ELECTRON_DIRECTORY_URI . '/css/product-deals.css');
    wp_register_style( 'electron-banner', ELECTRON_DIRECTORY_URI . '/css/elementor-banner.css');
    wp_register_style( 'electron-main-slider', ELECTRON_DIRECTORY_URI . '/css/elementor-main-slider.css');
    wp_register_style( 'electron-main-slider2', ELECTRON_DIRECTORY_URI . '/css/elementor-main-slider2.css');
    wp_register_style( 'electron-testimonials', ELECTRON_DIRECTORY_URI . '/css/elementor-testimonials.css');
    wp_register_style( 'electron-team', ELECTRON_DIRECTORY_URI . '/css/elementor-team.css');
    wp_register_style( 'electron-instagram', ELECTRON_DIRECTORY_URI . '/css/elementor-instagram.css');
    wp_register_style( 'electron-category-slider', ELECTRON_DIRECTORY_URI . '/css/elementor-category-slider.css');
    wp_register_style( 'woocommerce-tab-slider', ELECTRON_DIRECTORY_URI . '/css/woocommerce-tab-slider.css');
    wp_register_style( 'electron-product-list', ELECTRON_DIRECTORY_URI . '/css/elementor-product-list.css');
    wp_register_style( 'electron-taxonomy-list', ELECTRON_DIRECTORY_URI . '/css/elementor-taxonomy-list.css');
    wp_register_style( 'creative-slider', ELECTRON_DIRECTORY_URI . '/css/creative-slider.css');
    wp_register_style( 'creative-slider2', ELECTRON_DIRECTORY_URI . '/css/creative-slider2.css' );
    wp_register_script( 'creative-slider', ELECTRON_DIRECTORY_URI . '/js/creative-slider.js', array( 'jquery' ), '1.0', true );
    wp_register_style( 'electron-wc-custom-reviews-slider', ELECTRON_DIRECTORY_URI . '/css/woocommerce-custom-reviews-slider.css',false, '1.0');

    if ( class_exists( '\Elementor\Plugin' ) ) {
        $elementor_data = Elementor\Plugin::instance()->frontend->get_builder_content(get_the_ID());

        if (strpos($elementor_data, 'electron-product-deals-single') !== false || strpos($elementor_data, 'electron-woo-special-offer') !== false ) {
            wp_enqueue_style( 'electron-deals');
        }
        if (strpos($elementor_data, 'electron-woo-banner') !== false || strpos($elementor_data, 'electron-woo-banner-slider') !== false ) {
            wp_enqueue_style( 'electron-banner' );
        }
        if (strpos($elementor_data, 'electron-home-slider') !== false) {
            wp_enqueue_style( 'electron-main-slider' );
        }
        if (strpos($elementor_data, 'electron-slideshow') !== false) {
            wp_enqueue_style( 'electron-main-slider2' );
        }
        if (strpos($elementor_data, 'electron-testimonials') !== false) {
            wp_enqueue_style( 'electron-testimonials' );
        }
        if (strpos($elementor_data, 'electron-team-slider') !== false) {
            wp_enqueue_style( 'electron-team' );
        }
        if (strpos($elementor_data, 'electron-instagram-slider') !== false) {
            wp_enqueue_style( 'electron-instagram' );
        }
        if (strpos($elementor_data, 'electron-woo-category-grid') !== false) {
            wp_enqueue_style( 'electron-category-slider' );
        }
        if (strpos($elementor_data, 'electron-woo-tab-two') !== false) {
            wp_enqueue_style( 'woocommerce-tab-slider' );
        }
        if (strpos($elementor_data, 'electron-woo-products-list') !== false) {
            wp_enqueue_style( 'electron-product-list' );
        }
        if (strpos($elementor_data, 'electron-woo-taxonomy-list') !== false || strpos($elementor_data, 'electron-woo-taxonomy-products') !== false) {
                    wp_enqueue_style( 'electron-taxonomy-list' );
                }
        if (strpos($elementor_data, 'electron-woo-creative-slider') !== false) {
            wp_enqueue_style( 'creative-slider' );
        }
        if (strpos($elementor_data, 'electron-woo-creative-slider2') !== false) {
            wp_enqueue_style( 'creative-slider2' );
            wp_enqueue_script( 'creative-slider' );
        }
        if (strpos($elementor_data, 'electron-woo-custom-reviews') !== false) {
            wp_enqueue_style( 'electron-wc-custom-reviews-slider' );
        }
    }

    // fancybox lightbox
    wp_register_style( 'fancybox', ELECTRON_DIRECTORY_URI . '/js/fancybox/jquery.fancybox.css', false, '1.0' );
    wp_register_script( 'fancybox', ELECTRON_DIRECTORY_URI . '/js/fancybox/jquery.fancybox.min.js', array(), '1.0', true );

    // electron-framework-style
    wp_enqueue_style( 'electron-framework-style', ELECTRON_DIRECTORY_URI . '/css/framework-style.css', false, '1.0' );
    // electron-main-style
    wp_enqueue_script( 'magnific', ELECTRON_DIRECTORY_URI. '/js/magnific/magnific-popup.min.js', array( 'jquery' ), '1.0', true );

    wp_register_style( 'electron-wishlist', ELECTRON_DIRECTORY_URI . '/css/wishlist.css', false, '1.0' );
    wp_register_style( 'electron-compare', ELECTRON_DIRECTORY_URI . '/css/compare.css', false, '1.0' );
    wp_register_style( 'electron-canvas-menu', ELECTRON_DIRECTORY_URI . '/css/canvas-menu.css', false, '1.0' );
    wp_register_style( 'electron-sliding-menu', ELECTRON_DIRECTORY_URI . '/css/header-sliding-menu.css', false, '1.0' );

    wp_register_style( 'electron-blog-post', ELECTRON_DIRECTORY_URI . '/css/style-blog-post-item.css', false, '1.0' );

    if ( is_singular(array('product','post','page')) ) {
        wp_enqueue_style( 'electron-comment-form', ELECTRON_DIRECTORY_URI . '/css/comment-form.css', false, '1.0' );
    }

    wp_register_style( 'electron-bottom-mobile-menu', ELECTRON_DIRECTORY_URI . '/css/bottom-mobile-menu.css', false, '1.0' );

    // nice-select
    wp_register_script( 'jquery-nice-select', ELECTRON_DIRECTORY_URI . '/js/nice-select/jquery-nice-select.min.js', array( 'jquery' ), '1.0', true );


    // select2-full
    if ( class_exists( 'WooCommerce' ) ) {

        $type = isset($_GET['product_style']) ? esc_html($_GET['product_style']) : electron_settings( 'shop_product_type', '2' );
        $type = apply_filters( 'electron_loop_product_type', $type );

        wp_register_style( 'select2-full', ELECTRON_DIRECTORY_URI . '/js/select2/select2.min.css' );
        wp_register_script( 'select2-full', ELECTRON_DIRECTORY_URI . '/js/select2/select2.full.min.js', array( 'jquery' ), '1.0', true );
        wp_register_style( 'woocommerce-account-popup', ELECTRON_DIRECTORY_URI . '/css/woocommerce-account-popup.css' );

        if ( class_exists( 'Ivole' ) && is_product() ) {
            wp_enqueue_style( 'electron-wc-custom-reviews', ELECTRON_DIRECTORY_URI . '/css/woocommerce-custom-reviews.css',false, '1.0');
        }
        if ( is_cart() ) {
            wp_enqueue_style( 'electron-wc-cart-page', ELECTRON_DIRECTORY_URI . '/css/woocommerce-cart-page.css',false, '1.0');
        }
        if ( is_checkout() ) {
            wp_enqueue_style( 'electron-wc-checkout-page', ELECTRON_DIRECTORY_URI . '/css/woocommerce-checkout-page.css',false, '1.0');
        }
        if ( '1' == electron_settings('free_shipping_progressbar_visibility', '1' ) ) {
            wp_register_style( 'electron-wc-free-shipping-progressbar', ELECTRON_DIRECTORY_URI . '/css/woocommerce-free-shipping-progressbar.css');
        }

        wp_enqueue_style( 'electron-minicart', ELECTRON_DIRECTORY_URI . '/css/style-side-panel-cart.css', false, '1.0' );
        wp_enqueue_style( 'electron-wc', ELECTRON_DIRECTORY_URI . '/css/woocommerce-general.css',false, '1.0');
        wp_enqueue_style( 'electron-product-box-style', ELECTRON_DIRECTORY_URI . '/css/woocommerce-product-box-style.css',false, '1.0');
        if ( 'list' != $type ) {
            wp_enqueue_style( 'product-box-style', ELECTRON_DIRECTORY_URI . '/css/product-box-style-'.$type.'.css',false, '1.0');
        }
        wp_register_style( 'product-box-style1', ELECTRON_DIRECTORY_URI . '/css/product-box-style-1.css',false, '1.0');
        wp_enqueue_style( 'electron-wc-sidebar', ELECTRON_DIRECTORY_URI . '/css/woocommerce-sidebar.css',false, '1.0');
        wp_enqueue_style( 'electron-wc-product-page', ELECTRON_DIRECTORY_URI . '/css/woocommerce-product-page.css',false, '1.0');

        wp_enqueue_script( 'electron-wc', ELECTRON_DIRECTORY_URI . '/woocommerce/assets/js/woocommerce-general.js', array('jquery'), '1.0', true);

        if ( '1' == electron_settings('ajax_addtocart', '1' ) ) {
            wp_enqueue_script( 'electron-wc-ajax-addtocart', ELECTRON_DIRECTORY_URI . '/woocommerce/assets/js/ajax-addtocart.js', array('jquery'), '1.0', true);
        }

        if ( '1' == electron_settings('quick_shop', '1' ) ) {
            wp_enqueue_script( 'wc-add-to-cart-variation' );
            wp_enqueue_script( 'electron-quick-shop', ELECTRON_DIRECTORY_URI . '/woocommerce/assets/js/quick-shop.js', array('jquery'), '1.0', true);
        }

        if ( 'popup' == electron_settings('header_compare_btn_action', 'page' ) ) {
            wp_enqueue_style( 'electron-compare' );
        }

        if ( is_product() && '2' == electron_settings('product_zoom_type', 'default' ) ) {
            wp_enqueue_style( 'drift', ELECTRON_DIRECTORY_URI . '/js/drift/drift-basic.css',false, '1.0');
            wp_enqueue_script( 'drift', ELECTRON_DIRECTORY_URI . '/js/drift/Drift.min.js', array('jquery'), '1.0', true);
        }

        wp_register_script( 'electron-product-page', ELECTRON_DIRECTORY_URI . '/woocommerce/assets/js/product-page.js', array('jquery'), '1.0', true);
        wp_register_script( 'electron-product-bottom-popup-cart', ELECTRON_DIRECTORY_URI . '/woocommerce/assets/js/product-bottom-popup-cart.js', array('jquery'), '1.0', true);
        wp_register_script( 'electron-multi-step-checkout', ELECTRON_DIRECTORY_URI . '/woocommerce/assets/js/multi-step-checkout.js', array('jquery'), '1.0', true);
        wp_register_script( 'electron-sidepanel-timer', ELECTRON_DIRECTORY_URI . '/woocommerce/assets/js/sidepanel-timer.js', array('jquery'), '1.0', true);

        wp_register_script( 'pjax', ELECTRON_DIRECTORY_URI . '/woocommerce/assets/js/pjax.min.js', array('jquery'), '1.0', true );
        wp_register_script( 'shopAjaxFilter', ELECTRON_DIRECTORY_URI . '/woocommerce/assets/js/shopAjaxFilter.js', array('jquery', 'pjax'), '1.0', true );
        wp_register_script( 'electron-infinite-scroll', ELECTRON_DIRECTORY_URI. '/woocommerce/assets/js/infinite-scroll.js', array( 'jquery' ), false, '1.0' );
        wp_register_script( 'electron-load-more', ELECTRON_DIRECTORY_URI. '/woocommerce/assets/js/load_more.js', array( 'jquery' ), false, '1.0' );

        wp_enqueue_script( 'electron-quantity-button', ELECTRON_DIRECTORY_URI . '/woocommerce/assets/js/quantity_button.js', array('jquery'), '1.0.0', true );

        if ( !is_product() ) {
            wp_dequeue_script( 'cr-frontend-js' );
            wp_deregister_script( 'cr-frontend-js' );
        }
    }

    if ( is_rtl() ) {
        wp_enqueue_style( 'electron-style-rtl', ELECTRON_DIRECTORY_URI . '/css/style-rtl.css');
    }

    wp_dequeue_style( 'redux-extendify-styles' );
    wp_deregister_style( 'redux-extendify-styles' );

    // custom reviews
    wp_dequeue_style( 'cr-badges-css' );
    wp_deregister_style( 'cr-badges-css' );
    wp_dequeue_style( 'ivole-frontend-css' );
    wp_deregister_style( 'ivole-frontend-css' );
    wp_dequeue_script( 'cr-reviews-slider' );
    wp_deregister_script( 'cr-reviews-slider' );
    wp_dequeue_script( 'cr-colcade' );
    wp_deregister_script( 'cr-colcade' );

    if ( 'woo' != electron_settings( 'product_thumbs_layout', 'slider' ) ) {
        wp_dequeue_script( 'photoswipe' );
        wp_deregister_script( 'photoswipe' );
        wp_dequeue_script( 'photoswipe-ui-default' );
        wp_deregister_script( 'photoswipe-ui-default' );
        wp_dequeue_style( 'photoswipe-default-skin' );
        wp_deregister_style( 'photoswipe-default-skin' );
    }

    if ( '1' == electron_settings( 'theme_blocks_styles', '0' ) ) {

        wp_dequeue_style( 'wp-block-library' );
        wp_deregister_style( 'wp-block-library' );

        // woocommerce
        wp_dequeue_style( 'woocommerce-inline' );
        wp_deregister_style( 'woocommerce-inline' );

        wp_dequeue_style( 'global-styles' );

        global $wp_styles;
        foreach ( $wp_styles->queue as $handle ) {
            if ( str_starts_with( $handle, 'wc-blocks' ) ) {
                wp_deregister_style( $handle );
                wp_dequeue_style( $handle );
            }
        }
    }

    wp_deregister_style( 'contact-form-7' );
    wp_dequeue_style( 'contact-form-7' );
    wp_deregister_style( 'contact-form-7-rtl' );
    wp_dequeue_style( 'contact-form-7-rtl' );

    $is_elementor = get_post_meta( get_the_ID(), '_elementor_edit_mode', true);
    if ( class_exists( '\Elementor\Plugin' ) && $is_elementor != 'builder' ) {
        $elementor = \Elementor\Plugin::instance();
        $elementor->frontend->enqueue_styles();
        $elementor->frontend->enqueue_scripts();
    }
}
add_action( 'wp_enqueue_scripts', 'electron_theme_scripts', 999999 );

/*************************************************
## ADMIN STYLE AND SCRIPTS
*************************************************/

function electron_inline_styles($name='')
{
    return $name;
}
function electron_admin_scripts()
{
	if ( !is_customize_preview() ) {
		wp_register_style( 'select2-full', ELECTRON_DIRECTORY_URI . '/js/select2/select2.min.css' );
		wp_register_script( 'select2-full', ELECTRON_DIRECTORY_URI . '/js/select2/select2.full.min.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'electron-framework-admin', ELECTRON_DIRECTORY_URI . '/js/framework-admin.js', array('jquery', 'wp-color-picker' ) );
	}
}
add_action('admin_enqueue_scripts', 'electron_admin_scripts');


// Theme admin menu
require_once get_parent_theme_file_path( '/inc/core/merlin/admin-menu.php' );

// Template-functions
include ELECTRON_DIRECTORY . '/inc/template-functions.php';

// Theme parts
include ELECTRON_DIRECTORY . '/template-parts/navwalker.php';
include ELECTRON_DIRECTORY . '/template-parts/post-formats.php';
include ELECTRON_DIRECTORY . '/template-parts/single-post-formats.php';
include ELECTRON_DIRECTORY . '/template-parts/paginations.php';
include ELECTRON_DIRECTORY . '/template-parts/comment-parts.php';
include ELECTRON_DIRECTORY . '/template-parts/breadcrumbs.php';
include ELECTRON_DIRECTORY . '/template-parts/custom-style.php';
include ELECTRON_DIRECTORY . '/rtl-electron/loader.php';

// TGM plugin activation
include ELECTRON_DIRECTORY . '/inc/core/class-tgm-plugin-activation.php';

// Redux theme options panel
include ELECTRON_DIRECTORY . '/inc/core/theme-options/options.php';
include ELECTRON_DIRECTORY . '/inc/core/theme-options/header-options.php';


// WooCommerce init
if ( class_exists( 'WooCommerce' ) ) {
    include ELECTRON_DIRECTORY . '/woocommerce/init.php';
}

/*************************************************
## THEME SETUP
*************************************************/

if ( ! isset( $content_width ) ) {
    $content_width = 960;
}

function electron_theme_setup()
{
    /*
    * This theme styles the visual editor to resemble the theme style,
    * specifically font, colors, icons, and column width.
    */
    add_editor_style( 'custom-editor-style.css' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );
    add_image_size( 'electron-quickview', 60, 60, true );
    add_image_size( 'electron-panel', 80, 80, true );
    add_image_size( 'electron-mini', 300, 300, true );
    add_image_size( 'electron-medium', 370, 370, true );
    add_image_size( 'electron-square', 500, 500, true );
    add_image_size( 'electron-grid', 767, 767, true );
    /*
    * Enable support for Post Thumbnails on posts and pages.
    *
    * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
    */
    add_theme_support( 'post-thumbnails' );

    // theme supports
    add_theme_support( 'title-tag' );
    add_theme_support( 'custom-background' );
    add_theme_support( 'custom-header' );
    add_theme_support( 'html5', array( 'search-form' ) );
    add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );
    remove_theme_support( 'widgets-block-editor' );
    add_filter( 'use_widgets_block_editor', '__return_false' );
    add_filter('use_block_editor_for_post', '__return_false', 10);
    add_filter('use_block_editor_for_page', '__return_false', 10);

    // Make theme available for translation
    // Translations can be filed in the /languages/ directory
    //load_theme_textdomain( 'electron', ELECTRON_DIRECTORY . '/languages' );
    if ( class_exists('Redux' ) ) {
        register_nav_menus(array(
            'header_menu'          => esc_html__( 'Header Menu', 'electron' ),
            'canvas_menu'          => esc_html__( 'Canvas Sidebar Menu', 'electron' ),
            'left_menu'            => esc_html__( 'Left Menu ( for logo center )', 'electron' ),
            'rigt_menu'            => esc_html__( 'Right Menu ( for logo center )', 'electron' ),
            'header_mini_menu'     => esc_html__( 'Header Mini Menu', 'electron' ),
            'header_dropdown_menu' => esc_html__( 'Header Dropdown Mini Menu', 'electron' ),
            'mobile_bottom_menu'   => esc_html__( 'Mobile Bottom Menu', 'electron' ),
            'custom_mobile_menu'   => esc_html__( 'Custom Mobile Menu', 'electron' )
        ));
    } else {
        register_nav_menus(array(
            'header_menu' => esc_html__( 'Header Menu', 'electron' )
        ));
    }
}
add_action( 'after_setup_theme', 'electron_theme_setup' );

// disable srcset on frontend
if ( !function_exists('electron_disable_wp_responsive_images') ){
    function electron_disable_wp_responsive_images() {
        return 1;
    }
    add_filter('max_srcset_image_width', 'electron_disable_wp_responsive_images');
}


add_filter('wpcf7_autop_or_not', '__return_false');

/*************************************************
## WIDGET COLUMNS
*************************************************/

function electron_widgets_init()
{
    if ( class_exists( 'WooCommerce' ) ) {
        // Shop page sidebar
        register_sidebar( array(
            'id' => 'shop-page-sidebar',
            'name' => esc_html__( 'Shop Page Sidebar', 'electron' ),
            'description' => esc_html__( 'These widgets for the Shop page.','electron' ),
            'before_widget' => '<div class="nt-sidebar-inner-widget shop-widget electron-widget-show %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h6 class="nt-sidebar-inner-widget-title shop-widget-title"><span class="nt-sidebar-widget-title">',
            'after_title' => '</span><span class="nt-sidebar-widget-toggle"></span></h6>'
        ));
        // Single product sidebar
        register_sidebar( array(
            'id' => 'shop-single-sidebar',
            'name' => esc_html__( 'Shop Single Page Sidebar', 'electron' ),
            'description' => esc_html__( 'These widgets for the Shop Single page.','electron' ),
            'before_widget' => '<div class="nt-sidebar-inner-widget shop-widget electron-widget-show %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h6 class="nt-sidebar-inner-widget-title shop-widget-title"><span class="electron-sidebar-widget-title">',
            'after_title' => '</span><span class="electron-sidebar-widget-toggle"></span></h6>'
        ));
    }
    // Blog Sidebar
    register_sidebar(array(
        'name' => esc_html__( 'Blog Sidebar', 'electron' ),
        'id' => 'sidebar-1',
        'description' => esc_html__( 'These widgets for the Blog page.', 'electron' ),
        'before_widget' => '<div class="nt-sidebar-inner-widget widget blog-sidebar-widget mb-40 %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="nt-sidebar-inner-widget-title blog-sidebar-title"><h6>',
        'after_title' => '</h6></div>'
    ));
    if ( class_exists( 'Redux' ) ) {
        if ( 'sidebar' == electron_header_settings( 'canvas_menu_content_type', 'menu' ) ) {
            register_sidebar(array(
                'name' => esc_html__( 'Canvas Sidebar', 'electron' ),
                'id' => 'electron-canvas-sidebar',
                'before_widget' => '<div class="nt-sidebar-inner-widget widget blog-sidebar-widget mb-40 %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="nt-sidebar-inner-widget-title blog-sidebar-title"><h6>',
                'after_title' => '</h6></div>'
            ));
        }
        if ( 'full-width' != electron_settings( 'electron_page_layout' ) ) {
            register_sidebar(array(
                'name' => esc_html__( 'Default Page Sidebar', 'electron' ),
                'id' => 'electron-page-sidebar',
                'description' => esc_html__( 'These widgets for the Default Page pages.', 'electron' ),
                'before_widget' => '<div class="nt-sidebar-inner-widget widget blog-sidebar-widget mb-40 %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="nt-sidebar-inner-widget-title blog-sidebar-title"><h6>',
                'after_title' => '</h6></div>'
            ));
        }
        if ( 'full-width' != electron_settings( 'archive_layout', 'full-width' ) ) {
            register_sidebar(array(
                'name' => esc_html__( 'Archive Sidebar', 'electron' ),
                'id' => 'electron-archive-sidebar',
                'description' => esc_html__( 'These widgets for the Archive pages.', 'electron' ),
                'before_widget' => '<div class="nt-sidebar-inner-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="nt-sidebar-inner-widget-title blog-sidebar-title"><h5>',
                'after_title' => '</h5></div>'
            ));
        }
        if ( 'full-width' != electron_settings( 'search_layout', 'full-width' ) ) {
            register_sidebar(array(
                'name' => esc_html__( 'Search Sidebar', 'electron' ),
                'id' => 'electron-search-sidebar',
                'description' => esc_html__( 'These widgets for the Search pages.', 'electron' ),
                'before_widget' => '<div class="nt-sidebar-inner-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="nt-sidebar-inner-widget-title blog-sidebar-title"><h6>',
                'after_title' => '</h6></div>'
            ));
        }
        if ( 'full-width' != electron_settings( 'single_layout', 'right-sidebar' ) ) {
            register_sidebar(array(
                'name' => esc_html__( 'Blog Single Sidebar', 'electron' ),
                'id' => 'electron-single-sidebar',
                'description' => esc_html__( 'These widgets for the Blog single page.', 'electron' ),
                'before_widget' => '<div class="nt-sidebar-inner-widget widget blog-sidebar-widget mb-40 %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="nt-sidebar-inner-widget-title blog-sidebar-title"><h6>',
                'after_title' => '</h6></div>'
            ));
        }
    } // end if redux exists
} // end electron_widgets_init
add_action( 'widgets_init', 'electron_widgets_init' );


/*************************************************
## INCLUDE THE TGM_PLUGIN_ACTIVATION CLASS.
*************************************************/

function electron_register_required_plugins()
{
    $plugins = array(
        array(
            'name' => esc_html__( 'Contact Form 7', 'electron' ),
            'slug' => 'contact-form-7'
        ),
        array(
            'name' => esc_html__( 'Safe SVG', 'electron' ),
            'slug' => 'safe-svg'
        ),
        array(
            'name' => esc_html__( 'Theme Options Panel', 'electron' ),
            'slug' => 'redux-framework',
            'required' => true
        ),
        array(
            'name' => esc_html__( 'Elementor', 'electron' ),
            'slug' => 'elementor',
            'required' => true
        ),
        array(
            'name' => esc_html__( 'WooCommerce', 'electron' ),
            'slug' => 'woocommerce',
            'required' => true
        ),
        array(
            'name' => esc_html__( 'Customer Reviews for WooCommerce', 'electron' ),
            'slug' => 'customer-reviews-woocommerce',
            'required' => false
        ),
        array(
            'name' => esc_html__( 'WPC Bought Together', 'electron' ),
            'slug' => 'woo-bought-together',
            'required' => false
        ),
        array(
            'name' => esc_html__( 'Electron Elementor Addons', 'electron' ),
            'slug' => 'electron-elementor-addons',
            'source' => ELECTRON_DIRECTORY . '/plugins/electron-elementor-addons.zip',
            'required' => true,
            'version' => '1.1.7'
        )
        // end plugins list
    );

    $config = array(
        'id' => 'tgmpa',
        'default_path' => '',
        'menu' => 'tgmpa-install-plugins',
        'parent_slug' => apply_filters( 'ninetheme_parent_slug', 'themes.php' ),
        'has_notices' => true,
        'dismissable' => true,
        'dismiss_msg' => '',
        'is_automatic' => true,
        'message' => ''
    );

    tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'electron_register_required_plugins' );



/*************************************************
## ONE CLICK DEMO IMPORT
*************************************************/


/*************************************************
## THEME SETUP WIZARD
    https://github.com/richtabor/MerlinWP
*************************************************/
if ( is_admin() ) {
    require_once get_parent_theme_file_path( '/inc/core/merlin/class-merlin.php' );
    require_once get_parent_theme_file_path( '/inc/core/demo-wizard-config.php' );

    function electron_merlin_local_import_files() {
        $rtl = is_rtl() ? '-rtl' : '';
        return array(
            array(
                'import_file_name' => esc_html__( 'Home 1','electron' ),
                'import_preview_url' => 'https://ninetheme.com/themes/electron/v1/',
                // XML data
                'local_import_file' => get_parent_theme_file_path( 'inc/core/merlin/demodata/demo1/data'.$rtl.'.xml' ),
                // Widget data
                'local_import_widget_file' => get_parent_theme_file_path( 'inc/core/merlin/demodata/demo1/widgets.wie' ),
                // Theme options
                'local_import_redux' => array(
                    array(
                        'file_path' => trailingslashit( ELECTRON_DIRECTORY ). 'inc/core/merlin/demodata/demo1/redux.json',
                        'option_name' => 'electron'
                    ),
                    array(
                        'file_path' => trailingslashit( ELECTRON_DIRECTORY ). 'inc/core/merlin/demodata/demo1/redux_header.json',
                        'option_name' => 'electron_header'
                    )
                )
            )
        );
    }
    add_filter( 'merlin_import_files', 'electron_merlin_local_import_files' );

    function electron_disable_size_images_during_import() {
        add_filter( 'intermediate_image_sizes_advanced', function( $sizes ){
            unset( $sizes['thumbnail'] );
            unset( $sizes['medium'] );
            unset( $sizes['medium_large'] );
            unset( $sizes['large'] );
            unset( $sizes['1536x1536'] );
            unset( $sizes['2048x2048'] );
            unset( $sizes['electron-single'] );
            unset( $sizes['electron-square'] );
            unset( $sizes['electron-grid'] );
            unset( $sizes['electron-quickview'] );
            unset( $sizes['electron-panel'] );
            unset( $sizes['electron-medium'] );
            return $sizes;
        });
    }
    ///add_action( 'import_start', 'electron_disable_size_images_during_import');

    /**
     * Execute custom code after the whole import has finished.
     */
    function electron_merlin_after_import_setup() {
        // Assign menus to their locations.
        $primary    = get_term_by( 'name', 'Header Menu', 'nav_menu' );
        $mini_menu  = get_term_by( 'name', 'Header Dropdown Mini Menu', 'nav_menu' );
        $mini_menu2 = get_term_by( 'name', 'Header Top Mini Menu', 'nav_menu' );

        wp_update_term_count( $primary->term_id, 'nav_menu', true );
        wp_update_term_count( $mini_menu->term_id, 'nav_menu', true );
        wp_update_term_count( $mini_menu2->term_id, 'nav_menu', true );

        set_theme_mod( 'nav_menu_locations', array(
            'header_menu'          => $primary->term_id,
            'canvas_menu'          => $primary->term_id,
            'header_dropdown_menu' => $mini_menu->term_id,
            'header_mini_menu'     => $mini_menu2->term_id
        ));

        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title( 'Home 7 - Advanced' );
        $blog_page_id  = get_page_by_title( 'Blog' );

        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page_id->ID );
        update_option( 'page_for_posts', $blog_page_id->ID );

        if ( did_action( 'elementor/loaded' ) ) {

            // update some default elementor global settings after setup theme
            $kit = get_page_by_title( 'Imported Kit', OBJECT, 'elementor_library' );
            update_option( 'elementor_active_kit', $kit->ID );
            update_option( 'elementor_experiment-e_font_icon_svg', 'active' );
            update_option( 'elementor_experiment-container', 'active' );
            update_option( 'elementor_experiment-e_dom_optimization', 'active' );
            update_option( 'elementor_experiment-e_optimized_assets_loading', 'active' );
            update_option( 'elementor_experiment-e_optimized_css_loading', 'inactive' );
            update_option( 'elementor_experiment-a11y_improvements', 'active' );
            update_option( 'elementor_experiment-additional_custom_breakpoints', 'active' );
            update_option( 'elementor_experiment-e_import_export', 'active' );
            update_option( 'elementor_experiment-e_hidden_wordpress_widgets', 'active' );
            update_option( 'elementor_experiment-landing-pages', 'inactive' );
            update_option( 'elementor_experiment-elements-color-picker', 'active' );
            update_option( 'elementor_experiment-favorite-widgets', 'active' );
            update_option( 'elementor_experiment-admin-top-bar', 'active' );
            update_option( 'elementor_disable_color_schemes', 'yes' );
            update_option( 'elementor_disable_typography_schemes', 'yes' );
            update_option( 'elementor_global_image_lightbox', 'yes' );
            update_option( 'elementor_load_fa4_shim', 'yes' );

            $cpt_support = get_option( 'elementor_cpt_support' );
            if ( !is_array( $cpt_support ) || ! in_array( ['post','page','product'], $cpt_support ) ) {
                $cpt_support = ['post','page','product'];
                update_option( 'elementor_cpt_support', $cpt_support );
            }
            update_option( 'taxonomy_25', array('brand_thumbnail_id'=>11676) );
            update_option( 'taxonomy_34', array('brand_thumbnail_id'=>11678) );
            update_option( 'taxonomy_44', array('brand_thumbnail_id'=>11681) );
            update_option( 'taxonomy_49', array('brand_thumbnail_id'=>11685) );
        }

        /*
        * Customer Reviews for WooCommerce Plugins Settings
        * update some options after demodata insall
        */
        if ( class_exists( 'Ivole' ) ) {
            update_option( 'ivole_attach_image', 'yes' );
            update_option( 'ivole_attach_image_quantity', 2 );
            update_option( 'ivole_attach_image_size', 2 );
            update_option( 'ivole_ajax_reviews_per_page', 3 );
            update_option( 'ivole_disable_lightbox', 'yes' );
            update_option( 'ivole_reviews_histogram', 'yes' );
            update_option( 'ivole_reviews_voting', 'yes' );
            update_option( 'ivole_reviews_nobranding', 'yes' );
            update_option( 'ivole_ajax_reviews', 'yes' );
            update_option( 'ivole_ajax_reviews_form', 'yes' );
            update_option( 'ivole_questions_answers', 'yes' );
            update_option( 'ivole_qna_count', 'yes' );
            update_option( 'ivole_reviews_shortcode', 'yes' );
            update_option( 'ivole_ajax_reviews', 'no' );
        }

        if ( class_exists( 'WPCleverWoobt' ) ) {
            $woobt_settings = get_option('woobt_settings');
            if ( is_array( $woobt_settings ) ) {
                $woobt_settings['default']       = [ 0 => 'default', 1 => 'related', 2 => 'upsells' ];
                $woobt_settings['default_limit'] = '4';
                $woobt_settings['position']      = 'after';
                $woobt_settings['search_same']   = 'yes';
                update_option( 'woobt_settings', $woobt_settings );
            } else {
                $woobt_settings = array();
                $woobt_settings['default']       = [ 0 => 'default', 1 => 'related', 2 => 'upsells' ];
                $woobt_settings['default_limit'] = '4';
                $woobt_settings['position']      = 'after';
                $woobt_settings['search_same']   = 'yes';
                update_option( 'woobt_settings', $woobt_settings );
            }
        }

        if ( class_exists( 'WooCommerce' ) ) {
            $args = array(
                'post_type'   => 'product',
                'numberposts' => -1
            );
            $all_posts = get_posts($args);
            foreach ( $all_posts as $single_post ) {
                wp_update_post( $single_post );
                wp_update_term_count( $single_post->ID, 'product_cat', true );
                wp_update_term_count( $single_post->ID, 'product_tag', true );
                wp_update_term_count( $single_post->ID, 'electron_product_brands', true );
            }
            wp_reset_postdata();
        }

        $cartPage = get_option('woocommerce_cart_page_id');
        $cart_page_data = array(
            'ID' => $cartPage,
            'post_content' => '[woocommerce_cart]'
        );
        wp_update_post( $cart_page_data );

        $checkoutPage = get_option('woocommerce_checkout_page_id');
        $checkout_page_data = array(
            'ID' => $checkoutPage,
            'post_content' => '[woocommerce_checkout]'
        );
        wp_update_post( $checkout_page_data );

        // removes block widgets from sidebars after demodata install
        if ( is_active_sidebar( 'sidebar-1' ) ) {
            $sidebars_widgets = get_option( 'sidebars_widgets' );
            $sidebar_1_array  = $sidebars_widgets['sidebar-1'];
            foreach( $sidebar_1_array as $k => $v ) {
                if( substr( $v, 0, strlen("block-") ) === "block-" ) {
                    unset($sidebars_widgets['sidebar-1'][$k]);
                }
            }
            update_option( 'sidebars_widgets', $sidebars_widgets);
        }
    }
    add_action( 'merlin_after_all_import', 'electron_merlin_after_import_setup' );

    add_action('init', 'do_output_buffer'); function do_output_buffer() { ob_start(); }

    add_filter( 'woocommerce_prevent_automatic_wizard_redirect', '__return_true' );

    add_action( 'admin_init', function() {
        if ( did_action( 'elementor/loaded' ) ) {
            remove_action( 'admin_init', [ \Elementor\Plugin::$instance->admin, 'maybe_redirect_to_getting_started' ] );
        }
    }, 1 );
}
function electron_register_elementor_locations( $elementor_theme_manager )
{
    $elementor_theme_manager->register_location( 'header' );
    $elementor_theme_manager->register_location( 'footer' );
    $elementor_theme_manager->register_location( 'single' );
    $elementor_theme_manager->register_location( 'archive' );
}
add_action( 'elementor/theme/register_locations', 'electron_register_elementor_locations' );
