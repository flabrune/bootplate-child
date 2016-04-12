<?php
// Bootplate Child Starter Functions
// v0.3

// Setup Stylesheet(s)
function childplate_enqueue_styles() {
    $parent_style 	= 'bootplate';
	
	// See Issue 49 - https://github.com/jdmdigital/bootplate/issues/49
	$child_style 	= get_stylesheet();
	if(!isset($child_style) || $child_style == '') {
		$has_child_style	= false;
	} else {
		$has_child_style	= true;
	}
	
	if( get_theme_mod( 'minify_bootplate_css', 'unmin-bootplate-css' ) == 'min-bootplate-css') {$mincss = true;} else { $mincss = false; }
	if( get_theme_mod( 'minify_bootplate_js', 'unmin-bootplate-js' ) == 'min-bootplate-js') {$minjs = true;} else { $minjs = false; }
	
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), null, 'all' );
	
	if(is_child_theme() && $has_child_style) {
		// Load Parent.css instead of the full style.css file (or the minified version).
		if($mincss) {
			wp_enqueue_style( $parent_style, get_template_directory_uri() . '/css/parent.min.css', array('bootstrap'), bootplate_resource_version() );
		} else {
			wp_enqueue_style( $parent_style, get_template_directory_uri() . '/css/parent.css', array('bootstrap'), bootplate_resource_version() );
		}
		if($mincss) {
			wp_enqueue_style( $child_style, get_stylesheet_directory_uri() . '/style.min.css', array( 'bootstrap' ), bootplate_resource_version() );
		} else {
			wp_enqueue_style( $child_style, get_stylesheet_directory_uri() . '/style.css', array( 'bootstrap' ), bootplate_resource_version() );
		}
	} else {
		// Using Parent Theme. Load full style.css (or the minified version).
		if($mincss) {
			wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.min.css', array('bootstrap'), bootplate_resource_version() );
		} else {
			wp_enqueue_style( $parent_style, get_stylesheet_uri(), array('bootstrap'), bootplate_resource_version() );
		}

	}
	
}
add_action( 'wp_enqueue_scripts', 'childplate_enqueue_styles' );


// LoadCSS - Async Load of body.css (below the fold styles)
if(!function_exists('bootplate_async_css')) {
	function bootplate_async_css() {
		$tempdir = get_stylesheet_directory_uri();
		
		if(get_theme_mod( 'minify_bootplate_css', 'unmin-bootplate-css' ) == 'min-bootplate-css') {$bodycss = 'body.min.css';} else {$bodycss = 'body.css';}
		if(get_theme_mod( 'minify_bootplate_js', 'unmin-bootplate-js' ) == 'min-bootplate-js') {$loadcss = 'loadcss.min.js';} else {$loadcss = 'loadcss.js';}
		
		echo '
		<link rel="preload" href="'.$tempdir.'/css/'.$bodycss.'" as="style" onload="this.rel=\'stylesheet\'" type="text/css" />
		<noscript><link rel="stylesheet" href="'.$tempdir.'/css/'.$bodycss.'" type="text/css" /></noscript>
		<script src="'.$tempdir.'/js/'.$loadcss.'" type="text/javascript"></script>
		';
	}
}




// Setup Custom Scripts
function childplate_enqueue_scripts() {

	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', array(), null, true );
	wp_enqueue_script( 'jquery' );

}
add_action( 'wp_enqueue_scripts', 'childplate_enqueue_scripts' );