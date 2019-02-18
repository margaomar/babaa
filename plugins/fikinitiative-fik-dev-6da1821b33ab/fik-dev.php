<?php
   /*
   Plugin Name: Fik Stores Dev
   Plugin URI: http://fikstores.com
   Description: Fik Stores Themes development helper plugin
   Version: 1.0
   Author: Fik Stores
   Author URI: http://fikstores.com
   License: GPL2
   */

// Register Product Post Type
require 'FikCart.php';

function _product_post_type() {

    $labels = array(
        'name' => _x('Products', 'Product post type general name (plural)' , 'text_domain' ),
        'singular_name' => _x('Product', 'post type singular name' , 'text_domain' ),
        'add_new' => _x('Add New', 'Product' , 'text_domain' ),
        'add_new_item' => __('Add New Product' , 'text_domain'),
        'edit_item' => __('Edit Product' , 'text_domain'),
        'new_item' => __('New Product' , 'text_domain'),
        'all_items' => __('All Products' , 'text_domain'),
        'view_item' => __('View Product' , 'text_domain'),
        'search_items' => __('Search Products' , 'text_domain'),
        'not_found' => __('No products found' , 'text_domain'),
        'not_found_in_trash' => __('No products found in Trash' , 'text_domain'),
        'parent_item_colon' => __( 'Parent Product:', 'text_domain' ),
        'menu_name' => __('Products' , 'text_domain'),
        'update_item'         => __( 'Update Product', 'text_domain' ),
    );

	$args = array(
		'label'               => __( 'Products', 'text_domain' ),
		'description'         => __( 'Product post type used in Fik Stores for store products', 'text_domain' ),
		'labels'              => $labels,
		'supports' => array('title', 'editor', 'excerpt', 'custom-fields', 'page-attributes', 'thumbnail'), // thumbnail, revision or comment support can be added here
		'taxonomies'          => array( 'store_category', 'post_tag' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 8,
		'can_export'          => true,
		'has_archive'         => true,
    'rewrite' => array(
      'slug' => 'products',
        'with_front' => false ,
        'feeds' => true,
        'pages' => true
      ),
    'query_var' => 'product',
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'fik_product', $args );

}

// Hook into the 'init' action
add_action( 'init', '_product_post_type', 0 );


// Add Custom Product Variations

function product_variations_init() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name' => _x('Product Variations', 'taxonomy general name' , 'fik-stores' ),
        'singular_name' => _x('Product Variation', 'taxonomy singular name' , 'fik-stores' ),
        'search_items' => __('Search Product Variations' , 'fik-stores'),
        'popular_items' => null,
        'all_items' => __('All Product Variations' , 'fik-stores'),
        'parent_item' => __('Parent Product Variation' , 'fik-stores'),
        'parent_item_colon' => __('Parent Product Variation:' , 'fik-stores'),
        'edit_item' => __('Edit Product Variation' , 'fik-stores'),
        'update_item' => __('Update Product Variation' , 'fik-stores'),
        'add_new_item' => __('Add New Product Variation' , 'fik-stores'),
        'new_item_name' => __('New Product Variation Name' , 'fik-stores'),
        'menu_name' => __('Product Variations' , 'fik-stores'),
    );

    register_taxonomy('product-variation', array('fik_product'), array(
        'hierarchical' => true,
        'label' => _x('Product Variations', 'taxonomy general name' , 'fik-stores' ),
        'labels' => $labels,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'product-variation',
            'with_front' => true,
            'hierarchical' => true
        ),
    ));
}

add_action('init', 'product_variations_init', 0);


function fik_stores_customizer($wp_customize) {

    class fik_stores_Customize_Badge_Control extends WP_Customize_Control {

        public $type = 'select';

        public function render_content() {
        	$badge_colors = array('Default','Red', 'Green', 'Blue', 'Purple', 'Gray', 'SVGBlack', 'SVGWhite');
        	echo ('<label><span class="customize-control-title">' . esc_html($this->label) . '</span><select ' . $this->link() . '>');
        	foreach ($badge_colors as $color) {
        		echo ('<option value="' . ($color == $badge_colors[0] ? '': $color) . '"' . selected($this->value(), $color) . '>' .  $color . '</option>');
        	}
        	echo ('</select></label>');
        }

    }

    $wp_customize->add_section('fik_stores_fikstores_badge', array(
        'title' => __('Fik Stores Badge', 'fik-stores'),
        'priority' => 130,
    ));

    $wp_customize->add_setting('fik_stores_badge', array(
        'default' => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(
    	new fik_stores_Customize_Badge_Control($wp_customize, 'fik_stores_badge', array(
                'label' => __('Badge', 'fik-stores'),
                'section' => 'fik_stores_fikstores_badge',
                'settings' => 'fik_stores_badge',
            )));
}

add_action('customize_register', 'fik_stores_customizer');

function get_fikstores_badge(){
    $badge_selected = get_theme_mod('fik_stores_badge', '');

    if (strpos($badge_selected,'SVG') !== false){
        $filename = 'poweredbyfikstores' . $badge_selected . '.svg';
        $size = 'height="24"';
        $class= 'class="fikstores-badge badge-svg"';
    }else{
        $filename = 'poweredbyfikstores' . $badge_selected . '.png';
        $size = 'width="105" height="50"';
        $class= 'class="replace-2x fikstores-badge"';
    }

    $file = plugins_url('img/' . $filename, __FILE__);

    $badge = sprintf ('<a href="http://fikstores.com/" title="Better ecommerce"><img %s src="%s" %s alt="Better ecommerce"></a>',  $size, $file, $class);
    return $badge;
}

function the_fikstores_badge() {
	echo get_fikstores_badge();
	return;
}

function get_fik_previous_price(){
  $previous_price = get_post_custom_values('previous_price');
  if ($previous_price[0]){
    $previous = sprintf('<del><span itemprop="highPrice" class="highPrice"><span class="amount">%s</span>€</span></del>', $previous_price[0]);
  }else{
    $previous = false;
  }
  return $previous;
}

function the_fik_previous_price(){
	echo get_fik_previous_price();
	return;
}
function get_fik_price(){
  $price = get_post_custom_values('price');
  if ($price[0]){
    $current = sprintf('<span itemprop="price" class="price"><span class="amount">%s</span>€</span>', $price[0]);
  }else{
    $current = false;
  }
  return $current;
}

function the_fik_price(){
	echo get_fik_price();
	return;
}

function fik_product_stock_quantity(){
  $quantity = get_post_custom_values('quantity');
  if ($quantity[0]){
    $stock = $quantity[0];
  }else{
    $stock = false;
  }
  return $stock;
}

function fik_product_sku(){
  $sku = get_post_custom_values('SKU');
  if ($sku[0]){
    $sku = $sku[0];
  }else{
    $sku = false;
  }
  return $sku; 
}

function the_fik_add_to_cart_button(){
	echo('<form action="" class="fik_add_cart" method="post" enctype="multipart/form-data"><input type="hidden" name="store_product_id" value="38">'
		. get_fik_product_select_variations() . get_fik_product_select_quantity() . get_add_to_cart_button() .
		'</form>');
	return;
}

function get_fik_product_select_variations(){
  //The following example shows womens shoe sizes from 36 to 41
  return '<div class="control-group product-variations"><label class="control-label" for="variation-16">Talla mujer</label><div class="controls"><select name="variation-16" id="vv-talla-mujer" class="form-control"><option value="">Selecciona una opción …</option><option value="17">36</option><option value="18">37</option><option value="19">38</option><option value="20">39</option><option value="21">40</option><option value="22">41</option></select></div></div>';
}

function get_fik_product_select_quantity(){
  $class = 'product-quantity';
  $defaultValue = '1';
  $errorQuantity = '';


  if(current_theme_supports('bootstrap-3-forms')) {
    $quantitytemplate = '<div class="form-group ' . $class . '">';
    $quantitytemplate .= '<label for="quantity">Quantity</label>';
    $quantitytemplate .= '<input type="number" id="quantity" name="quantity" class="form-control" min="1" max="10" step="1" value="' . $defaultValue . '" required />';
    if($errorQuantity !='') {
        $quantitytemplate .= '<span class="help-inline">' . $errorQuantity . '</span>';
    }
    $quantitytemplate .= '</div>';
  }else{
    $quantitytemplate = '<div class="control-group ' . $class . '"><label class="control-label" for="quantity">Quantity</label><div class="controls"><input type="number" name="quantity" class="input-mini form-control" min="1" max="10" step="1" value="1" required=""></div></div>';
  }
  return $quantitytemplate;
}

function get_add_to_cart_button($prodID = null, $buttonClasses = "button alt btn btn-primary"){
	return '<button type="submit" class="' . $buttonClasses . '">Add to cart</button>';
}


function get_the_product_gallery_thumbnails() {
    return get_post_custom_values('product_image');
}

function the_product_gallery_thumbnails($thumnail_size = 'post-thumbnail', $image_size = 'medium', $zoom_image_size = 'large'){
    $product_image = get_post_custom_values('product_image');
    if ($product_image){
      foreach ( $product_image as $key => $image_id ) {
          $the_thumbnail = wp_get_attachment_image($image_id, $thumnail_size, false);
          $the_image = get_post($image_id);
          $the_image_url = wp_get_attachment_image_src($image_id, $image_size, false);
          $the_zoom_image_url = wp_get_attachment_image_src($image_id, $zoom_image_size, false);
          $thumblist[$image_id] = '<a target="_blank" href="' . $the_image_url[0] . '" title="' . $the_image->post_title . '" data-width="' . $the_image_url[1] . '" data-height="' . $the_image_url[2] . '" data-zoom-image="' . $the_zoom_image_url[0] . '" data-zoomimagewidth="' . $the_zoom_image_url[1] . '" data-zoomimageheight="' . $the_zoom_image_url[2] . '">' . $the_thumbnail . '</a>';
      }

      if ($thumblist == array())
          return false;

      $output = '<ul class="product-image-thumbnails thumbnails">';

      foreach ($thumblist as $thumbnail) {
          $output .= '<li class="thumbnail">' . $thumbnail . '</li>';
      }

      $output .= '</ul>';

      echo $output;
    }
    return;
}


/**
 * Returns HTML for status and/or error messages, grouped by type.
 *
 * An invisible heading identifies the messages for assistive technology.
 * Sighted users see a colored box. See http://www.w3.org/TR/WCAG-TECHS/H69.html
 * for info.
 *
 * @param string $display
 *   - display: (optional) Set to 'status', 'warning', 'help' or 'error' to display only messages
 *     of that type.
 */

function fik_messages($display = FALSE, $message = array ('error' => "This is a test message")) {
  $output = '';
  $status_heading = array(
    'success' => __('Status message', 'fik-stores'), 
    'error' => __('Error message', 'fik-stores'), 
    'warning' => __('Warning message', 'fik-stores'),
    'info' => __('Info message', 'fik-stores'), 
  );
  foreach ($message as $type => $messages) {
    if ($type) $alert_class = "alert-" . $type;
    $output .= "<div class=\"alert $alert_class\">\n";
    if (!empty($status_heading[$type])) {
      $output .= '<h4 class="hide">' . $status_heading[$type] . "</h4>\n";
    }
    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . "</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
        if(is_array($messages)){
            $output .= '<p>' . $messages[0] . '</p>';
        }else{
            $output .= '<p><ul><li>' . $messages . '</li></ul></p>';
        }
    }
    $output .= "</div>\n";
  }
  $output = apply_filters( 'fik_messages', $output);
  return $output;
}

function the_store_logo($size = "full", $args = array('class' => 'logo')){
    $logo_id = get_option('fik_store_logo');
    echo wp_get_attachment_image($logo_id['logo'], $size, false, $args);
}

// Store sections
function _store_sections_init() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name' => 'Store Sections',
        'singular_name' => _x('Store Section', 'taxonomy singular name' , 'fik-dev' ),
        'search_items' => __('Search Store Sections' , 'fik-dev'),
        'popular_items' => null, // null so popular categories will not be displayed in edit-tags.php admin page for this taxonomy
        'all_items' => __('All Store Sections' , 'fik-dev'),
        'parent_item' => __('Parent Store Section' , 'fik-dev'),
        'parent_item_colon' => __('Parent Store Section:' , 'fik-dev'),
        'edit_item' => __('Edit Store Section' , 'fik-dev'),
        'update_item' => __('Update Store Section' , 'fik-dev'),
        'add_new_item' => __('Add New Store Section' , 'fik-dev'),
        'new_item_name' => __('New Store Section Name' , 'fik-dev'),
        'menu_name' => __('Store Sections' , 'fik-dev'),
    );

    register_taxonomy('store-section', array('fik_product'), array(
        'hierarchical' => true,
        'label' => _x('Store Sections', 'taxonomy general name' , 'fik-dev' ),
        'labels' => $labels,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'section',
            'with_front' => true,
            'hierarchical' => true
        ),
    ));
}
add_action('init', '_store_sections_init', 0);

/**
 * Register the settings to use on the theme options page
 */
add_action( 'admin_init', 'fik_register_settings' );

/**
 * Function to register the settings
 */
function fik_register_settings()
{
    // Register the settings with Validation callback
    register_setting( 'store_logo', 'fik_store_logo', 'logo_validate_settings' );

    // Add settings section
    add_settings_section( 'fik_logo_section', 'Store Logo', 'fik_display_section', 'reading' );

    // Create textbox field
    $field_args = array(
      'type'      => 'media_id',
      'id'        => 'logo',
      'name'      => 'logo_input',
      'desc'      => 'Image ID from the <a href="./upload.php">media gallery</a>',
      'std'       => '',
      'label_for' => 'logo_input',
      'class'     => 'css_class',
      'option_name' => 'fik_store_logo'
    );

    add_settings_field( 'logo_textbox', 'Store logo image ID', 'fik_display_setting', 'reading', 'fik_logo_section', $field_args );
}

/**
 * Function to add extra text to display on each section
 */
function fik_display_section($section){ 

}

/**
 * Function to display the settings on the page
 * This is setup to be expandable by using a switch on the type variable.
 * In future you can add multiple types to be display from this function,
 * Such as checkboxes, select boxes, file upload boxes etc.
 */
function fik_display_setting($args)
{
    extract( $args );
    $options = get_option( $option_name );

    if(!$options){
      update_option( $option_name, '' );
      $options = get_option( $option_name );
    }

    switch ( $type ) {  
          case 'text':  
              $options[$id] = stripslashes($options[$id]);  
              $options[$id] = esc_attr( $options[$id]);  
              echo "<input class='regular-text$class' type='text' id='$id' name='" . $option_name . "[$id]' value='$options[$id]' />";  
              echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
          break;  
          case 'media_id':  
              $options[$id] = stripslashes($options[$id]);  
              $options[$id] = esc_attr( $options[$id]);  
              echo "<input class='regular-text$class' type='number' id='$id' name='" . $option_name . "[$id]' value='$options[$id]' />";  
              echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
          break;  
    }
}

/**
 * Callback function to the register_settings function will pass through an input variable
 * You can then validate the values and the return variable will be the values stored in the database.
 */
function logo_validate_settings($input)
{
  foreach($input as $k => $v)
  {
    $newinput[$k] = trim($v);
    
    // Check the input is a letter or a number
    if(!preg_match('/^[A-Z0-9 _]*$/i', $v)) {
      $newinput[$k] = '';
    }
  }

  return $newinput;
}




add_action('admin_menu', 'add_admin_menu');

function add_admin_menu(){
     add_menu_page( 'Options - Fik Theme DEV', 'Fik Theme DEV', 'manage_options', 'fikdev', 'fik_admin_function' );
 
}

function fik_admin_function(){
  ?>
    <div class="section panel">
      <h1>Fik Theme DEV Options</h1>
      <form method="post" enctype="multipart/form-data" action="options.php">
        <?php 
          settings_fields('store_logo'); 
        
          do_settings_sections('reading');
        ?>
            <p class="submit">  
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />  
            </p>  
            
      </form>

    </div>
    <?php
}

class store_sections_widget extends WP_Widget {

    function store_sections_widget(){
        $widget_ops = array('classname' => 'store_sections_widget', 'description' => "Display the store sections belongs to a product" );
        $this->WP_Widget('store_sections_widget', "Store Sections Widget", $widget_ops);
    }

    function widget($args,$instance){
        echo '<div class="product-store-categories">' . get_the_term_list($post->ID, 'store-section', '', ', ', '' ) . '</div>';
    }

    function update($new_instance, $old_instance){
    }

    function form($instance){
    }
}

function store_sections_create_widget(){
    register_widget('store_sections_widget');
}
add_action('widgets_init','store_sections_create_widget');

function get_fik_checkout(){
    $fik_cart = new FikCart();
    return $fik_cart->build_cart();
}

function the_fik_checkout()
{
    echo get_fik_checkout();
}

function fik_order_get() {
    $cookie_name = 'dev-store';
    //TODO: get form options or localstorage
     if (isset($_COOKIE[$cookie_name]) && ($_COOKIE[$cookie_name] != FALSE)) {
        $order_cookie = unserialize(urldecode($_COOKIE[$cookie_name]));
    }else{
      $order_cookie = FALSE;
    }
    return $order_cookie;
}

add_image_size('largest', 1200, 1200);

function fik_slider($atts) {
    global $wp_query;
    if (isset($atts['ids'])) {
        $ids = explode(',', $atts['ids']);
        if (is_array($ids)) {
            if (!isset($atts['indicators'])) {
                $atts['indicators'] = 'true';
            }
            if (!isset($atts['indicators'])) {
                $atts['indicators'] = 'true';
            }
            if (!isset($atts['navigation'])) {
                $atts['navigation'] = 'true';
            }
            if (!isset($atts['captions'])) {
                $atts['captions'] = 'true';
            }
            if (!isset($atts['max-width'])) {
                $atts['max-width'] = '100%';
            }
            if (!isset($atts['id'])) {
                $atts['id'] = 'myCarousel';
            }
            $slides = array();
            foreach ($ids as $key => $id) {
                $image = wp_get_attachment_image($id, 'largest');
                if ($image != '') {
                    $slides[$key]['id'] = $id;
                    $slides[$key]['img'] = $image;
                    $attachment = get_post($id);
                    $slides[$key]['title'] = $attachment->post_title;
                    $slides[$key]['description'] = $attachment->post_content;
                    if (isset($atts['link' . $id])) {
                        $slides[$key]['link'] = $atts['link' . $id];
                    }
                } else {
                    unset($slides[$key]);
                }
            }
            $slides = array_values($slides);
            if ($slides != array()) {
                //We show the slider
                // Add javascript and css to output!
                if(!current_theme_supports('bootstrap-3')) {
                    wp_enqueue_script('bootstrap-carousel', '/wp-content/mu-plugins/assets/js/bootstrap-carousel.js', array('jquery'), '1.01', true);
                    
                    wp_enqueue_style('bootstrap-carousel', '/wp-content/mu-plugins/assets/css/fik-bootstrap-carousel.css');
                }
                $maxwidth = ' style="max-width:' . $atts['max-width'] . ';"';
                $slider = '<div id="' . $atts['id'] . '" class="carousel slide"' . $maxwidth . '>';
                // Carousel Indicators
                if ((isset($atts['indicators'])) && ($atts['indicators'] == 'true')) {
                    $slider .= '<ol class="carousel-indicators">';
                    foreach ($slides as $key => $slide) {
                        if ($key == 0) {
                            $class = ' class="active"';
                        } else {
                            $class = '';
                        }
                        $slider .= '<li data-target="#' . $atts['id'] . '" data-slide-to="' . $key . '"' . $class . '></li>';
                    }
                    $slider .= '</ol>';
                }
                // Carousel Items
                $slider .= '<div class="carousel-inner">';
                foreach ($slides as $key => $slide) {
                    if ($key == 0) {
                        $class = ' class="active item"';
                    } else {
                        $class = ' class="item"';
                    }
                    $slider .= '<div' . $class . '>';
                    // Image with or without link:
                    if (isset($slide['link'])) {
                        $slider .= '<a href="' . $slide['link'] . '" title="' . $slide['title'] . '">';
                        $slider .= $slide['img'];
                        $slider .= '</a>';
                    } else {
                        $slider .= $slide['img'];
                    }
                    // Image caption if requested:
                    if ((isset($atts['captions'])) && ($atts['captions'] == 'true')) {
                        $slider .= '<div class="carousel-caption">';
                        $slider .= '<h4>' . $slide['title'] . '</h4>';
                        $slider .= '<p>' . $slide['description'] . '</p>';
                        $slider .= '</div>';
                    }
                    $slider .= '</div>'; // Closes each of the slides
                }
                $slider .= '</div>'; // Closes carousel-inner
                // Carousel Navigation
                if ((isset($atts['navigation'])) && ($atts['navigation'] == 'true')) {
                    $slider .= '<a class="carousel-control left" href="#' . $atts['id'] . '" data-slide="prev"><span>&lsaquo;</span></a>';
                    $slider .= '<a class="carousel-control right" href="#' . $atts['id'] . '" data-slide="next"><span>&rsaquo;</span></a>';
                }
                $slider .= '</div>'; // Closes carousel
            }
        }

        return $slider;
    }
}

add_shortcode('fikslider', 'fik_slider');

/*
 * Add a list of products through the product content field by adding a shortcode life [fiksection slug="slug"]
 */

function fik_section_product_list_in_content($atts) {
    global $wp_query;
    if (isset($atts['slug'])) {
        $args = array(
            'post_type' => 'fik_product',
            'tax_query' => array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'store-section',
                    'field' => 'slug',
                    'terms' => $atts['slug']
                )
            )
        );
        $temp_query = $wp_query;
        query_posts($args);
        if ($wp_query->have_posts()) {
            ?>
            <ul class="product-list">
                <?php
                /* Start the Loop */
                while (have_posts()) : the_post();

                    /* Include the post format-specific template for the content. If you want to
                     * this in a child theme then include a file called called content-___.php
                     * (where ___ is the post format) and that will be used instead.
                     */
                    get_template_part('content', 'fik_product');

                endwhile;
                ?>
            </ul>
            <?php
        }
        $wp_query = $temp_query;
    }
}

add_shortcode('fiksection', 'fik_section_product_list_in_content');

/* Add a shortcode for the cart page*/
add_shortcode('cart-page', 'get_fik_checkout');

/* Add JS for false cart badge */

function cart_number_badge() {
	wp_enqueue_script('cart-badge', plugins_url( 'cart-badge.js', __FILE__ ), array(), '1.0', true);
}

add_action( 'wp_enqueue_scripts', 'cart_number_badge' );
