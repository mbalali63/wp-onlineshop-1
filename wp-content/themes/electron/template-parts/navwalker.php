<?php

/*************************************************
## Register Menu
*************************************************/
/**
* Extended Walker class for use with the  Bootstrap toolkit Dropdown menus in Wordpress.
* Edited to support n-levels submenu and Title and Description text.
* @author @jaycbrf4 https://github.com/jaycbrf4/wp-bootstrap-navwalker
*  Original work by johnmegahan https://gist.github.com/1597994, Emanuele 'Tex' Tessore https://gist.github.com/3765640
* @license CC BY 4.0 https://creativecommons.org/licenses/by/4.0/
*/
if ( ! class_exists( 'Electron_Wp_Bootstrap_Navwalker' ) ) {
    class Electron_Wp_Bootstrap_Navwalker extends Walker_Nav_Menu
    {
        public function start_lvl(&$output, $depth = 0, $args = array())
        {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"submenu depth_$depth\">\n";
        }

        public function end_lvl(&$output, $depth = 0, $args = array())
        {
            $output .= "</ul>";
        }

        public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
        {
            $indent = ($depth) ? str_repeat("\t", $depth) : '';

            $class_names = '';

            $id = esc_attr($item->ID);

            $classes = empty($item->classes) ? array() : (array) $item->classes;

            // managing divider: add divider class to an element to get a divider before it.
            $divider_class_position = array_search('divider', $classes);

            if ( $divider_class_position !== false ) {
                $output .= "<li class=\"divider\"></li>\n";
                unset($classes[$divider_class_position]);
            }

            $classes[] = ($args->has_children) ? 'has-dropdown' : '';
            $classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
            $classes[] = 'menu-item-' . $id;

            $megamenu   = get_post_meta( $id, '_menu_item_megamenu', true );
            $mega_col   = get_post_meta( $id, '_menu_item_megamenu_columns', true );
            $shortcode  = get_post_meta( $id, '_menu_item_menushortcode', true );
            $shortcode2 = get_post_meta( $id, '_menu_item_menushortcode_sidebar', true );
            $hidetitle  = get_post_meta( $id, '_menu_item_menuhidetitle', true );
            $menulabel  = get_post_meta( $id, '_menu_item_menulabel', true);
            $labelcolor = get_post_meta( $id, '_menu_item_menulabelcolor', true);
            $icon_url   = get_post_meta( $id, '_menu_item_icon_url', true);

            $svg_content = $icon_url && function_exists('convert_url_to_svg') ? convert_url_to_svg($icon_url) : '';
            $menulabel   = $menulabel != '' ? '<span class="menu-label" data-label-color="'.$labelcolor.'">'.$menulabel.'</span>' : '';

            $classes[] = $svg_content ? 'has-icon' : '';
            $classes[] = $menulabel != '' ? 'has-label' : '';

            if ( $depth === 0 ) {
                $classes[] = $megamenu ? 'mega-parent column-'.$mega_col : '';
                $classes[] = !empty( $shortcode ) ? 'has-shortcode' : '';
            }

            $classes[] = $depth === 1 && $args->has_children ? 'mega-menu-title' : '';
            $classes[] = $depth && $args->has_children || !empty( $shortcode ) ? 'has-submenu menu-item--has-child' : '';

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
            $class_names = ' class="' . esc_attr($class_names) . '"';

            $itemId  = apply_filters('nav_menu_item_id', 'menu-item-'.$id, $item, $args);
            $attrId  = strlen($itemId) ? ' id="'.esc_attr($itemId).'"' : '';
            $datId   = ' data-id="'.$id.'"';

            $output .= $indent . '<li' . $attrId . $datId . $class_names . '>';

            $attributes  = ! empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) .'"' : '';
            $attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target) .'"' : '';
            $attributes .= ! empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) .'"' : '';
            $attributes .= ! empty($item->url) ? ' href="' . esc_attr($item->url) .'"' : '';
            $attributes .= $depth === 1 && $args->has_children  ? ' class="column-title"' : '';

            /** This filter is documented in wp-includes/post-template.php */
            $title = apply_filters( 'the_title', $item->title, $id );

            /**
             * Filters a menu item's title.
             *
             * @since 4.4.0
             *
             * @param string   $title The menu item's title.
             * @param WP_Post  $item  The current menu item.
             * @param stdClass $args  An object of wp_nav_menu() arguments.
             * @param int      $depth Depth of menu item. Used for padding.
             */
            $title        = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
            $hover_title  = $title;
            $dropdown_btn = ( $args->has_children || !empty( $shortcode ) ) ? '<span class="nt-icon-up-chevron dropdown-btn"></span>' : '';
            $is_lang      = array_search('lang-item', $classes) || array_search('wpml-ls-menu-item', $classes) ? true : false;
            $header_temp  = apply_filters( 'electron_header_template', electron_settings( 'header_template', 'default' ) );
            $shortcode    = $header_temp == 'sidebar' && !empty( $shortcode2 ) ? $shortcode2 : $shortcode;
            $item_output  = '';

            $item_output  = $args->before;
            $item_output .= '<a'. $attributes .'>'.$svg_content.$menulabel;
            if ( $is_lang !== false ) {
                $item_output .= $args->link_before.$hover_title.$args->link_after.$dropdown_btn;
            } else {
                $item_output .= $args->link_before.'<span data-hover="'.$hover_title.'"></span>'.$args->link_after.$dropdown_btn;
            }
            $item_output .= '</a>';
            $item_output .= $args->after;

            if ( $depth === 0 && $megamenu ) {
                $ajax_menu    = electron_settings( 'megamenu_ajax', '0' );
                $mega_class   = 'mega-container';
                $mega_class  .= '1' == $ajax_menu ? ' menu-load-ajax' : '';
                $mega_class  .= !empty( $shortcode ) ? ' has-el-template' : '';

                $mega_content = !empty( $shortcode ) && '1' != $ajax_menu ? do_shortcode( $shortcode ) : '';

                $item_output .= '<div class="'.$mega_class.'" data-id="'.$id.'">'.$mega_content;
            }

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }


        public function end_el( &$output, $item, $depth = 0, $args = null ) {

            $megamenu = get_post_meta( $item->ID, '_menu_item_megamenu', true );

            $output .= $depth === 0 && $megamenu ? '</div>' : '</li>';
        }


        public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
        {
            if (!$element) {
                return;
            }

            $id_field = $this->db_fields['id'];

            //display this element
            if (is_array($args[0])) {
                $args[0]['has_children'] = ! empty($children_elements[$element->$id_field]);
            } elseif (is_object($args[0])) {
                $args[0]->has_children = ! empty($children_elements[$element->$id_field]);
            }
            $cb_args = array_merge(array(&$output, $element, $depth), $args);
            call_user_func_array(array(&$this, 'start_el'), $cb_args);

            $id = $element->$id_field;

            // descend only when the depth is right and there are childrens for this element
            if (($max_depth == 0 || $max_depth > $depth+1) && isset($children_elements[$id])) {
                foreach ($children_elements[ $id ] as $child) {
                    if (!isset($newlevel)) {
                        $newlevel = true;

                        // start the child delimiter
                        $cb_args = array_merge(array(&$output, $depth), $args);
                        call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
                    }

                    $this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output);
                }

                unset($children_elements[ $id ]);
            }

            if (isset($newlevel) && $newlevel) {

            // end the child delimiter
                $cb_args = array_merge(array(&$output, $depth), $args);
                call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
            }

            // end this element
            $cb_args = array_merge(array(&$output, $element, $depth), $args);
            call_user_func_array(array(&$this, 'end_el'), $cb_args);
        }

        /**
         * Menu Fallback
         *
         * @since 1.0.0
         *
         * @param array $args passed from the wp_nav_menu function.
         */
        public static function fallback($args)
        {
            $output = '';
            if ( current_user_can('edit_theme_options') ) {
                $output .= '<li class="menu-item"><a href="' . admin_url('nav-menus.php') . '">' . esc_html__('Add a menu', 'electron') . '</a></li>';
            } else {
                $output .= '<li class="electron-default-menu-item-empty"></li>';
            }
            return $output;
        }
    }
}

if ( ! class_exists( 'Electron_Sliding_Navwalker' ) ) {
    class Electron_Sliding_Navwalker extends Walker_Nav_Menu
    {
        public function start_lvl(&$output, $depth = 0, $args = array())
        {
            $indent = str_repeat("\t", $depth);
            $submenu = ($depth > 0) ? '' : '';
            $output	.= "\n$indent<ul class=\"submenu depth_$depth\">\n";
        }
        public function end_lvl(&$output, $depth = 0, $args = array())
        {
            $output	.= "</ul>";
        }


        public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
        {
            $indent = ($depth) ? str_repeat("\t", $depth) : '';

            $li_attributes = '';
            $class_names = $value = '';

            $classes = empty($item->classes) ? array() : (array) $item->classes;

            // managing divider: add divider class to an element to get a divider before it.
            $divider_class_position = array_search('divider', $classes);

            if ( $divider_class_position !== false ) {
                $output .= "<li class=\"divider\"></li>\n";
                unset($classes[$divider_class_position]);
            }

            $classes[] = ($args->has_children) ? 'has-dropdown' : '';
            $classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
            $classes[] = 'menu-item-' . $item->ID;

            if ( $depth && $args->has_children ) {
                $classes[] = 'has-submenu menu-item--has-child';
            }
            $dropdown_btn = ( $args->has_children ) ? '<div class="dropdown-btn"><span class="fas fa-angle-down"></span></div>' : '';

            $shortcode  = get_post_meta( $item->ID, '_menu_item_menushortcode', true );
            $shortcode2 = get_post_meta( $item->ID, '_menu_item_menushortcode_sidebar', true );
            $shortcode  = !empty( $shortcode2 ) ? $shortcode2 : $shortcode;
            $icon_url   = get_post_meta($id, '_menu_item_icon_url', true);

            $svg_content = $icon_url && function_exists('convert_url_to_svg') ? convert_url_to_svg($icon_url) : '';

            $classes[] = $svg_content ? 'has-icon' : '';

            if ( !empty( $shortcode ) ) {
                $classes[] = 'has-dropdown has-submenu menu-item-has-children menu-item-shortcode-parent';
            }

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
            $class_names = ' class="' . esc_attr($class_names) . '"';

            $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
            $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

            $output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

            $attributes  = ! empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) .'"' : '';
            $attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target) .'"' : '';
            $attributes .= ! empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) .'"' : '';
            $attributes .= ! empty($item->url) ? ' href="' . esc_attr($item->url) .'"' : '';


            /** This filter is documented in wp-includes/post-template.php */
            $title = apply_filters( 'the_title', $item->title, $item->ID );

            /**
             * Filters a menu item's title.
             *
             * @since 4.4.0
             *
             * @param string   $title The menu item's title.
             * @param WP_Post  $item  The current menu item.
             * @param stdClass $args  An object of wp_nav_menu() arguments.
             * @param int      $depth Depth of menu item. Used for padding.
             */
            $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

            $item_output  = '';
            $item_output .= $args->before;
            $item_output .= '<a'. $attributes .'>'.$svg_content;
            $item_output .= $args->link_before . $title . $args->link_after.$dropdown_btn;
            $item_output .= '</a>';
            $item_output .= $args->after;

            if ( !empty( $shortcode ) ) {
                if ( '1' == electron_settings( 'megamenu_ajax', '0' ) ) {
                    $item_output .='<ul class="submenu"><li class="item-shortcode-li"><div class="item-shortcode-wrapper sliding-menu-load-ajax" data-id="'.$item->ID.'"></div></li></ul>';
                } else {
                    $item_output .='<ul class="submenu"><li class="item-shortcode-li"><div class="item-shortcode-wrapper has-el-template">'.do_shortcode( $shortcode ).'</div></li></ul>';
                }
            }

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        } // start_el

        public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
        {
            if (!$element) {
                return;
            }

            $id_field = $this->db_fields['id'];

            //display this element
            if (is_array($args[0])) {
                $args[0]['has_children'] = ! empty($children_elements[$element->$id_field]);
            } elseif (is_object($args[0])) {
                $args[0]->has_children = ! empty($children_elements[$element->$id_field]);
            }
            $cb_args = array_merge(array(&$output, $element, $depth), $args);
            call_user_func_array(array(&$this, 'start_el'), $cb_args);

            $id = $element->$id_field;

            // descend only when the depth is right and there are childrens for this element
            if (($max_depth == 0 || $max_depth > $depth+1) && isset($children_elements[$id])) {
                foreach ($children_elements[ $id ] as $child) {
                    if (!isset($newlevel)) {
                        $newlevel = true;

                        // start the child delimiter
                        $cb_args = array_merge(array(&$output, $depth), $args);
                        call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
                    }

                    $this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output);
                }

                unset($children_elements[ $id ]);
            }

            if (isset($newlevel) && $newlevel) {

            // end the child delimiter
                $cb_args = array_merge(array(&$output, $depth), $args);
                call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
            }

            // end this element
            $cb_args = array_merge(array(&$output, $element, $depth), $args);
            call_user_func_array(array(&$this, 'end_el'), $cb_args);
        }

        /**
         * Menu Fallback
         *
         * @since 1.0.0
         *
         * @param array $args passed from the wp_nav_menu function.
         */
        public static function fallback($args)
        {
            $output = '';
            if ( current_user_can('edit_theme_options') ) {
                $output .= '<li class="menu-item"><a href="' . admin_url('nav-menus.php') . '">' . esc_html__('Add a menu', 'electron') . '</a></li>';
            } else {
                $output .= '<li class="electron-default-menu-item-empty"></li>';
            }
            return $output;
        }
    }
}

if ( !class_exists('Electron_WooCommerce_Categories_Walker') ) {
    class Electron_WooCommerce_Categories_Walker extends Walker
    {
        /**
        * DB fields to use.
        *
        * @var array
        */
        public $db_fields = array(
            'parent' => 'parent',
            'id'     => 'term_id',
            'slug'   => 'slug'
        );
        /**
        * Starts the list before the elements are added.
        *
        * @see Walker::start_lvl()
        * @since 2.1.0
        *
        * @param string $output Passed by reference. Used to append additional content.
        * @param int    $depth Depth of category. Used for tab indentation.
        * @param array  $args Will only append content if style argument value is 'list'.
        */
        public function start_lvl( &$output, $depth = 0, $args = array() ) {
            if ( 'list' !== $args['style'] ) {
                return;
            }
            $rtl = is_rtl() ? 'left' : 'right';
            $indent  = str_repeat( "\t", $depth );
            $output .= "$indent<ul class='electron-wc-cats-children submenu depth-$depth'>\n";
        }

        /**
        * Ends the list of after the elements are added.
        *
        * @see Walker::end_lvl()
        * @since 2.1.0
        *
        * @param string $output Passed by reference. Used to append additional content.
        * @param int    $depth Depth of category. Used for tab indentation.
        * @param array  $args Will only append content if style argument value is 'list'.
        */
        public function end_lvl( &$output, $depth = 0, $args = array() ) {
            if ( 'list' !== $args['style'] ) {
                return;
            }

            $indent  = str_repeat( "\t", $depth );
            $output .= "$indent</ul>\n";
        }

        /**
        * Start the element output.
        *
        * @see Walker::start_el()
        * @since 2.1.0
        *
        * @param string  $output            Passed by reference. Used to append additional content.
        * @param object  $cat               Category.
        * @param int     $depth             Depth of category in reference to parents.
        * @param array   $args              Arguments.
        * @param integer $current_object_id Current object ID.
        */
        public function start_el( &$output, $cat, $depth = 0, $args = array(), $current_object_id = 0 ) {
            $catId      = intval( $cat->term_id );
            $elTemp     = get_term_meta( $catId, 'electron_wc_cat_header', true );
            $elTempM    = get_term_meta( $catId, 'electron_wc_cat_header_mobile', true );
            $elTemplate = wp_is_mobile() && $elTemp && $elTempM == 'yes' ? '' : $elTemp;
            $thumbId    = get_term_meta( $catId, 'thumbnail_id', true );
            $svgId      = get_term_meta( $catId, 'electron_product_cat_svgimage_id', true );
            $img        = isset( $args['thumb'] ) ? $args['thumb'] : 1;
            $imgId      = $img && isset( $args['thumb_type'] ) == 'svg' ? $svgId : $thumbId;
            $imgUrl     = wp_get_attachment_image_url($imgId,[30,30]);
            $imgSrc     = $imgUrl ? $imgUrl : '';
            $name       = $cat->name;
            $has_child  = false;
            $thumb      = '1' == $img && $imgSrc ? '<img width="30" height="30" src="'.esc_url( $imgSrc ).'" alt="'.esc_attr( $name ).'"/>' : '';
            $link       = !empty($catId) ? get_term_link( $catId ) : '';

            $output .= '<li class="cat-item cat-item-'.$catId;

            if ( $args['has_children'] && $args['hierarchical'] && ( empty( $args['max_depth'] ) || $args['max_depth'] > $depth + 1 ) ) {
                $output .= ' menu-item-has-children';
                $has_child = true;
            }
            if ( $elTemp ) {
                $output .= ' menu-item-has-children has-template';
                $output .= $elTempM == 'yes' ? ' hidden-on-mobile' : '';
                $has_child = true;
            }

            $output .= '">';
            $output .= '<a class="product_cat" href="'.esc_url( $link ).'">';
            $output .= $thumb;
            $output .= '<span class="category-title" data-hover="'.$name.'"></span>';
            $output .= ( $has_child && true == $args['mobile'] ) ? '<span class="nt-icon-up-chevron dropdown-btn"></span>' : '';
            $output .= isset( $args['cat_count'] ) ? '<span class="category-count">'.$cat->count.'</span>' : '';
            $output .= '</a>';
            $output .= $elTemplate ? '<ul class="header-cat-template electron-wc-cats-children"><li>'.do_shortcode( $elTemplate ).'</li></ul>' : '';

        }

        /**
        * Ends the element output, if needed.
        *
        * @see Walker::end_el()
        * @since 2.1.0
        *
        * @param string $output Passed by reference. Used to append additional content.
        * @param object $cat    Category.
        * @param int    $depth  Depth of category. Not used.
        * @param array  $args   Only uses 'list' for whether should append to output.
        */
        public function end_el( &$output, $cat, $depth = 0, $args = array() ) {
            $output .= "</li>\n";
        }

        /**
        * Traverse elements to create list from elements.
        *
        * Display one element if the element doesn't have any children otherwise,
        * display the element and its children. Will only traverse up to the max.
        * depth and no ignore elements under that depth. It is possible to set the.
        * max depth to include all depths, see walk() method.
        *
        * This method shouldn't be called directly, use the walk() method instead.
        *
        * @since 2.5.0
        *
        * @param object $element           Data object.
        * @param array  $children_elements List of elements to continue traversing.
        * @param int    $max_depth         Max depth to traverse.
        * @param int    $depth             Depth of current element.
        * @param array  $args              Arguments.
        * @param string $output            Passed by reference. Used to append additional content.
        * @return null Null on failure with no changes to parameters.
        */
        public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
            if ( ! $element || ( 0 === $element->count && ! empty( $args[0]['hide_empty'] ) ) ) {
                return;
            }
            parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
        }
    }
}
