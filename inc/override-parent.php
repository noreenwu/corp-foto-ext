<?php
/**
 * Override parent functions
 *
 * @package Corporate Fotografie
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * Override Parent functions
 * @param array $classes Classes for the body element.
 * @return array
 */
function fotografie_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Always add a front-page class to the front page.
	if ( is_front_page() && ! is_home() ) {
		$classes[] = 'page-template-front-page';
	}

	// Adds a class with respect to layout selected.
	$layout  = fotografie_get_theme_layout();

	$sidebar = '';
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$sidebar = 'sidebar-1'; // Primary Sidebar.
	}

	if ( 'right-sidebar' === $layout ) {
		if ( '' !== $sidebar ) {
			$classes[] = 'two-columns-layout content-left';
		}
	}

	// Add a class if there is a custom header.
	if ( has_header_image() && is_front_page() ) {
		$classes[] = 'has-header-image';
	}

	// Adds a class of (full-width|box) to blogs.
	if ( 'boxed' === get_theme_mod( 'fotografie_layout_type' ) ) {
		$classes[] = 'boxed-layout';
	} else {
		$classes[] = 'fluid-layout';
	}

	return $classes;
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * overwriting parent theme content width
 */
function fotografie_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fotografie_content_width', 1000 );
}

/**
 * Set up the WordPress core custom header feature.
 *
 * Overwriting parent theme custom header
 */
function fotografie_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'fotografie_custom_header_args', array(
		'default-image'      => get_stylesheet_directory_uri() . '/assets/images/header.jpg',
		'default-text-color' => 'ffffff',
		'width'              => 1920,
		'height'             => 1080,
		'flex-height'        => true,
		'flex-width'         => true,
		'wp-head-callback'   => 'fotografie_header_style',
		'video'              => true,
	) ) );

	register_default_headers( array(
		'blond' => array(
			'thumbnail_url' => get_stylesheet_directory_uri() . '/assets/images/header-thumb.jpg',
			'url'           => get_stylesheet_directory_uri() . '/assets/images/header.jpg',
			'description'   => esc_html__( 'Blond', 'corporate-fotografie' ),
		),
		'closeup' => array(
			'thumbnail_url' => get_stylesheet_directory_uri() . '/assets/images/header2-thumb.jpg',
			'url'           => get_stylesheet_directory_uri() . '/assets/images/header2.jpg',
			'description'   => esc_html__( 'Closeup', 'corporate-fotografie' ),
		),
	) );
}

/**
 * Register Google fonts for Corporate Fotografie.
 *
 * Overwriting fotografie_fonts_url() function in a child theme.
 */
function fotografie_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Lato, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Raleway font: on or off', 'corporate-fotografie' ) ) {
		$fonts[] = 'Raleway:300,400,700,300italic,400italic,700italic';
	}

	/* translators: If there are characters in your language that are not supported by Playfair Display, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Source Serif Pro font: on or off', 'corporate-fotografie' ) ) {
		$fonts[] = 'Source Serif Pro:300,400,700,300italic,400italic,700italic';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return esc_url( $fonts_url );
}

/**
 * Get theme layout
 *
 * Override Parent function
 * @return [type] [description]
 */
function fotografie_get_theme_layout() {
	$layout = get_theme_mod( 'fotografie_default_layout', 'right-sidebar' );

	if ( is_home() || is_archive() ) {
		$layout = get_theme_mod( 'corporatefotografie_homepage_layout', 'right-sidebar' );
	}

	return $layout;
}
