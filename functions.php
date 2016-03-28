<?php
// Bootplate Child Functions
// v0.1

// Setup Stylesheet(s)
function childplate_enqueue_styles() {
    $parent_style 	= 'bootplate';
	$child_style	= 'bootplate-child';
	
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.5' );
	
	if(is_child_theme()) {
		// Load Parent.css instead of the full style.css file (or the minified version).
		if(file_exists(get_template_directory_uri() . '/css/parent.min.css')) {
			wp_enqueue_style( $parent_style, get_template_directory_uri() . '/css/parent.min.css', array('bootstrap'), '' );
		} else {
			wp_enqueue_style( $parent_style, get_template_directory_uri() . '/css/parent.css', array('bootstrap'), '' );
		}
		// Load Child Style (min, if exists)
		if(file_exists(get_stylesheet_directory_uri() . '/style.min.css')) {
			wp_enqueue_style( $child_style, get_stylesheet_directory_uri() . '/style.min.css', array('bootstrap', $parent_style), '' );
		} else {
			wp_enqueue_style( $child_style, get_stylesheet_directory_uri(). '/style.css', array('bootstrap', $parent_style), '' );
		}
		
	} else {
		// Using Parent Theme. Load full style.css (or the minified version).
		if(file_exists(get_template_directory_uri() . '/style.min.css')) {
			wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.min.css', array('bootstrap'), '' );
		} else {
			wp_enqueue_style( $parent_style, get_stylesheet_uri(). '/style.css', array('bootstrap'), '' );
		}
	}
	
	// Load the IE-specific stylesheet.
	wp_enqueue_style( 'bootplate-ie', get_template_directory_uri() . '/css/ie.css', array( 'bootplate' ), '' );
	wp_style_add_data( 'bootplate-ie', 'conditional', 'lt IE 9' );
	
}
add_action( 'wp_enqueue_scripts', 'childplate_enqueue_styles' );


// LoadCSS - Async Load of child theme's body.css (below the fold styles)
if(!function_exists('bootplate_async_css')) {
	function bootplate_async_css() {
		$childdir = get_stylesheet_directory_uri();
		$parentdir = get_template_directory_uri();
		
		if(file_exists($childdir.'/css/body.min.css')) {
			$bodycss = $childdir.'/css/body.min.css';
		} elseif(file_exists($childdir.'/css/body.css')) {
			$bodycss = $childdir.'/css/body.min.css';
		} elseif(file_exists($parentdir.'/css/body.min.css')) {
			$bodycss = $parentdir.'/css/body.min.css';
		} else {
			$bodycss = $parentdir.'/css/body.css';
		}
		
		echo '
		<link rel="preload" href="'.$bodycss.'" as="style" onload="this.rel=\'stylesheet\'" type="text/css" />
		<noscript><link rel="stylesheet" href="'.$bodycss.'" type="text/css" /></noscript>
		<script src="'.$parentdir.'/js/loadcss.js" type="text/javascript"></script>
		';
	}
}



// Setup Scripts
function childplate_enqueue_scripts() {

	wp_deregister_script( 'html5shiv-maxcdn' );
	wp_register_script( 'html5shiv-maxcdn', '//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js', '', '', false );
	wp_enqueue_script( 'html5shiv-maxcdn' );
	wp_script_add_data( 'html5shiv-maxcdn', 'conditional', 'lt IE 9' );
	
	wp_deregister_script( 'respond-js' );
	wp_register_script( 'respond-js', '//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js', '', '', false );
	wp_enqueue_script( 'respond-js' );
	wp_script_add_data( 'respond-js', 'conditional', 'lt IE 9' );

	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', '', '', true );
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '', true );
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr-custom.js', array('jquery'), '', true );
	wp_enqueue_script( 'bootplate-plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery', 'modernizr'), '', true );
	wp_enqueue_script( 'bootplate-main', get_template_directory_uri() . '/js/main.js', array('jquery', 'modernizr', 'bootplate-plugins'), bootplate_info('version'), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'childplate_enqueue_scripts' );