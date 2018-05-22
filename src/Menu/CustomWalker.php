<?php

namespace Ardiran\Core\Menu;

class CustomWalker extends \Walker_Nav_Menu {

    private $id;
    private $prefix_class;

    public function __construct($id, $prefix_class = "")
    {

        $this->id = $id;
        $this->prefix_class = $prefix_class;

    }

    public function start_lvl( &$output, $depth = 0, $args = array() )
    {

        $prefix_class = $this->prefix_class;

        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' );

        $display_depth = ( $depth + 1);

        $classes = array(
            $prefix_class . 'menu__submenu',
            ( $display_depth >=2 ? $prefix_class . 'menu__sub__submenu' : '' ),
        );

        $class_names = implode( ' ', $classes );

        $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";

    }

    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
    {

        global $wp_query;

        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' );

        $prefix_class = $this->prefix_class;

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        // $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
        $class_names = "";

        $active = in_array('current-menu-item', $classes) ? true : false;
        $has_submenu = in_array('menu-item-has-children', $classes) ? true : false;

        $depth_classes = array(
            ( $depth == 0 ? $prefix_class . 'menu__item' : $prefix_class . 'menu__submenu__item' ),
            ( $depth >=2 ? $prefix_class . 'menu__sub__submenu__item' : '' ),
            ( $depth == 0 && $has_submenu ? $prefix_class . 'menu__item--submenu' : '' ),
            ( $depth >=2 && $has_submenu ? $prefix_class . 'menu__submenu__item--submenu' : '' ),
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

        $class_names = trim($depth_class_names . ' ' . $class_names );

        $output .= $indent . '<li class="' . $class_names . '">';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= ' class="';
        $attributes .= $depth <= 0 && $active  ? $prefix_class . 'menu__link--active ' : '';
        $attributes .= $depth > 0 && $active  ? $prefix_class . 'menu__submenu__link--active ' : '';
        $attributes .= $depth > 0 ? $prefix_class . 'menu__submenu__link' : $prefix_class . 'menu__link';
        $attributes .= '"';

        $item_output = sprintf( '%1$s<a%2$s><span>%3$s%4$s%5$s</span></a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters( 'the_title', $item->title, $item->ID ),
            $args->link_after,
            $args->after
        );

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

    }

}