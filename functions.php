<?php
/*
 * Bootplate Child Starter Functions File
 * v0.5
 * Demo and Docs at: http://bootplate.jdmdigital.co/childplate/ 
 */

// Setup Stylesheet(s)
function childplate_enqueue_styles() {
    $parent_style 	= 'bootplate';
	//$child_style	= 'childplate';
	
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), bootplate_resource_version() );

	// Enqueue Google Font, if you want one using their CDN.  
	//wp_enqueue_style( 'google-font', 'https://fonts.googleapis.com/css?family=Raleway:400,300,700');
	
	// OR Enqueue Google Font using the local path
	//wp_enqueue_style( 'google-font', get_stylesheet_directory_uri() . '/fonts/whatever');
	
	// Load the IE-specific stylesheet.
	wp_enqueue_style( 'bootplate-ie', get_template_directory_uri() . '/css/ie.css', array( 'bootplate' ), '' );
	wp_style_add_data( 'bootplate-ie', 'conditional', 'lt IE 9' );
	
}
add_action( 'wp_enqueue_scripts', 'childplate_enqueue_styles' );
