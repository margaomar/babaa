<?php

/*
*   Add support for upload SVG
*/

function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

/*
*   Add shortcode support on text widgets
*/

add_filter('widget_text', 'do_shortcode');

/*
*   Add wpautop
*/

add_filter( 'the_content', 'wpautop', 10 );

/* 
 * This functions allows to get the contents of a template into a variable,
 * needed for shortcodes. 
 */

if ( !function_exists( 'load_template_part' ) ){
	function load_template_part($template_name, $part_name=null) {
	    ob_start();
	    get_template_part($template_name, $part_name);
	    $var = ob_get_contents();
	    ob_end_clean();
	    return $var;
	}
}

/*
 * This functions allows to detect is some page is blog
 */

function is_blog () {
	global  $post;
	$posttype = get_post_type($post );
	return ( ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ( $posttype == 'post')  ) ? true : false ;
}
