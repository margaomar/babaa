<?php
/**
* Create and populate fik stores menus
*
* If you need to create a new menu, add a new array with menu_name
* and menu_location and add a new function insert_{menu_location}_menu_items
* to populate the new menu
*/

function add_nav_menus() {
    $menus = array(
        array('menu_name'     => 'Primary Navigation',
              'menu_location' => 'primary_navigation'),
        array('menu_name'     => 'Cart',
              'menu_location' => 'cart_menu'),
        array('menu_name'     => 'Store Navigation',
              'menu_location' => 'store_navigation'),
        array('menu_name'     => 'Footer',
              'menu_location' => 'footer_menu'),
    );

    foreach($menus as $menu) {
        add_menu($menu['menu_name'], $menu['menu_location']);
    }
}
add_action('after_switch_theme', 'add_nav_menus');

function add_menu($menu_name, $menu_location) {
    if (!menu_exists($menu_name)) {
        $menu_id = wp_create_nav_menu($menu_name);
        insert_menu_items($menu_id, $menu_location);
        assign_menu_to_theme_location($menu_id, $menu_location);
    }
}

function insert_primary_navigation_menu_items($menu_id) {
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' =>  __('Home'),
        'menu-item-classes' => 'home',
        'menu-item-url' => home_url( '/' ),
        'menu-item-status' => 'publish'));

    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' =>  __('Blog'),
        'menu-item-classes' => 'blog',
        'menu-item-url' => home_url( '/' ),
        'menu-item-status' => 'publish'));

    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' =>  __('Store'),
        'menu-item-classes' => 'store',
        'menu-item-url' => home_url('/products/'),
        'menu-item-status' => 'publish'));
}

function insert_cart_menu_menu_items($menu_id) {
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' =>  __('Cart'),
        'menu-item-classes' => 'cart',
        'menu-item-url' => home_url( '/cart/' ),
        'menu-item-status' => 'publish'));
}

function insert_store_navigation_menu_items($menu_id) {
}

function insert_footer_menu_menu_items($menu_id) {
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' =>  __('Terms of Use, Privacy Policy and Use of Cookies'),
        'menu-item-classes' => 'terms',
        'menu-item-url' => home_url( '/terms/' ),
        'menu-item-status' => 'publish'));
}

function menu_exists($menu_name) {
    return wp_get_nav_menu_object($menu_name);
}

function assign_menu_to_theme_location($menu_id, $menu_location) {
    if( !has_nav_menu( $menu_location ) ){
        $locations = get_theme_mod('nav_menu_locations');
        $locations[$menu_location] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }
}

function insert_menu_items($menu_id, $menu_location) {
    $fun = 'insert_' . $menu_location . '_menu_items';
    $fun($menu_id);
}

/**
 * Fix nav menu active classes for custom post types
 **/
function roots_cpt_active_menu($menu) {
    if ('fik_product' === get_post_type()) {
        $menu = str_replace('active', '', $menu);
        $menu = str_replace('menu-store', 'menu-store active', $menu);
    }

    return $menu;
}
add_filter('nav_menu_css_class', 'roots_cpt_active_menu', 400);
