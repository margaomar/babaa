<?php
/**
 * Roots initial setup and constants
 */
function roots_setup() {
  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/roots-translations
  load_theme_textdomain('roots', get_template_directory() . '/lang');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'roots'),
    'cart_menu' => __('Cart Menu', 'roots'),
    'store_navigation' => __('Store Navigation', 'roots'),
    'footer_menu' => __('Footer Menu', 'roots')
  ));

  // Add post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');
  add_image_size('page-header-custom-thumbnail', 2000, 600, true);
  add_image_size('post-custom-thumbnail', 1020, 600, true);
  add_image_size('latest-post-custom-thumbnail', 660, 300, true);
  add_image_size('store-product-custom-thumbnail', 728, 686, true);
  add_image_size('store-single-product-custom-thumbnail', 700, false);
  add_image_size('store-single-product-custom-thumbnail-zoom', 1500, false);

  // Add post formats
  // http://codex.wordpress.org/Post_Formats
  add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'));

  // Tell the TinyMCE editor to use a custom stylesheet
  add_editor_style('/assets/css/editor-style.css');
}
add_action('after_setup_theme', 'roots_setup');
