<?php
function frontend_styles_scripts() {
	// Custom stylesheet
	wp_enqueue_style( 'custom', get_stylesheet_directory_uri() . '/css/custom.css' );
	// Plugins styles
	wp_enqueue_style( 'plugins-styles', get_stylesheet_directory_uri() . '/css/plugins.css' );
	// Moernizr
	wp_enqueue_script( 'modernizr', get_stylesheet_directory_uri() . '/js/modernizr.min.js', array( 'jquery' ), false, true );
	// Styles
	wp_enqueue_script( 'flex-script', get_stylesheet_directory_uri() . '/js/misc.js', array( 'jquery' ), false, true );
}
add_action( 'wp_enqueue_scripts', 'frontend_styles_scripts' );

// Slider Post Type
require_once(dirname(__FILE__) . '/inc/responsive-slider/slider_post_type.php');

// Slider Post Type
require_once(dirname(__FILE__) . '/inc/responsive-slider/slider.php');

// Register Navagition menu(s)
register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'twenty-o-twelve' )
) );

// Add custom iage sizes
add_image_size('image-size-name', 250, 250, true);

// Utility function -- Shorten text
function shorten_text( $text, $length ) {
	$text = strip_tags( $text );

	if ( empty( $length ) || $length < 0 || $length > strlen( $text ) ) return $text;

	$subs_text = substr( $text, 0, $length );
	$arr = explode( ' ', $subs_text );
	$last_index = count( $arr ) - 1;
	if ( $arr[$last_index] != '' )
		return shorten_text( $text, ++$length );
	else
		return $subs_text . '...';
}