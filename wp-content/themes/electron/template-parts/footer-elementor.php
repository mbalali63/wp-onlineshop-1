<?php

/**
* Custom template parts for this theme.
*
* Eventually, some of the functionality here could be replaced by core features.
*
* @package electron
*/

if ( '0' != electron_settings( 'footer_visibility', '1' ) ) {

    if ( 'elementor' == electron_settings( 'footer_template', 'default' ) ) {
        if ( '1' == electron_settings( 'footer_ajax', '0' ) ) {
            echo '<div class="electron-elementor-footer"></div>';
        } else {
            $ID = electron_settings( 'footer_elementor_templates' );
            $ID = isset($_GET['footer_style']) ? esc_html($_GET['footer_style']) : $ID;
            $ID = apply_filters( 'electron_translated_template_id', $ID );
            $footerTemp = new WP_Query( array('p' => $ID, 'post_type' => 'elementor_library') );
            if ( $footerTemp->have_posts() ) {
                while ( $footerTemp->have_posts() ) {
                    $footerTemp->the_post();
                    the_content();
                }
            }
            wp_reset_postdata();
        }
    } else {

        get_template_part( 'template-parts/footer-default' );

    }
}
