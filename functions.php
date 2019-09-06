<?php
/**
 * Components functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @packageCorporate_Fotografie
 */

/**
 * Loads the child theme textdomain.
 */
function corporatefotografie_setup() {
    load_child_theme_textdomain( 'corporate-fotografie', get_stylesheet_directory() . '/languages' );

    /** Override Parent Image Sizes */
	set_post_thumbnail_size( 1083, 542, true );

	add_image_size( 'fotografie-hero-image', 725, 725, true );
}
add_action( 'after_setup_theme', 'corporatefotografie_setup', 11 );


/**
 * Enqueue scripts and styles.
 */
function corporatefotografie_scripts() {
	/* If using a child theme, auto-load the parent theme style. */
	if ( is_child_theme() ) {
		wp_enqueue_style( 'fotografie-style', trailingslashit( esc_url( get_template_directory_uri() ) ) . 'style.css' );
	}

	/* Always load active theme's style.css. */
	wp_enqueue_style( 'corporatefotografie-style', get_stylesheet_uri() );

	wp_enqueue_script( 'corporatefotografie-global', get_stylesheet_directory_uri() . '/assets/js/global.min.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'corporatefotografie_scripts' );

/**
 * Prints HTML with meta information for the categories.
 */
function corporatefotografie_entry_categories() {
	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( esc_html__( ', ', 'corporate-fotografie' ) );
	if ( $categories_list && fotografie_categorized_blog() ) {
		echo '<span class="cat-links"><span class="screen-reader-text">' . esc_html__( 'Categories: ', 'corporate-fotografie' ) . '</span>' . $categories_list . '</span>'; // WPCS: XSS OK.
	}
}


/**
 * Prints HTML with meta information for the author.
 */
function corporatefotografie_entry_author() {
	$byline = sprintf(
		/* translators: used between spans and before author */
		esc_html_x( '%1$sby%2$s%3$s', 'post author', 'corporate-fotografie' ),
		'<span class="screen-reader-text">',
		' </span>',
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="byline">' . $byline . '</span>'; // WPCS: XSS OK.
}


/**
 * Prints HTML with meta information for the comment.
 */
function corporatefotografie_entry_comment() {
	echo '<span class="comments-link">';
	comments_popup_link( esc_html__( 'Leave a comment', 'corporate-fotografie' ), esc_html__( '1 Comment', 'corporate-fotografie' ), esc_html__( '% Comments', 'corporate-fotografie' ) );
	echo '</span>';
}

if ( ! function_exists( 'corporatefotografie_header_media_text' ) ) :
	/**
	 * Display Header Media Text
	 * @return void
	 */
	function corporatefotografie_header_media_text() {
		$title    = get_theme_mod( 'corporatefotografie_header_media_title', esc_html__( 'Header Media', 'corporate-fotografie' ) );
		$text     = get_theme_mod( 'corporatefotografie_header_media_text', esc_html__( 'This is Header Media Text.', 'corporate-fotografie' ) );
		$url      = get_theme_mod( 'corporatefotografie_header_media_button_url', '#' );
		$url_text = get_theme_mod( 'corporatefotografie_header_media_button_text', esc_html__( 'Explore', 'corporate-fotografie' ) );
		$base     = get_theme_mod( 'corporatefotografie_header_media_button_base' );
		$target   = '_self';

		if ( '' != $url ) {
			//support for qtranslate custom link
			if ( function_exists( 'qtrans_convertURL' ) ) {
				$url = qtrans_convertURL( $url );
			}

			//Checking Link Target
			if ( $base ) {
				$target = '_blank';
			}
		}

		if ( '' !== $title || '' !== $text || '' !== $url ) : ?>
			<div class="custom-header-content section header-media-section">
				<div class="custom-header-content-wrapper">
					<?php if ( '' !== $title ) : ?>
						<h2 class="entry-title section-title"><?php echo wp_kses_post( $title ); ?></h2>
					<?php endif; ?>

					<p class="site-header-text"><?php echo wp_kses_post( $text ); ?>

					<span class="header-button"><a href="<?php echo esc_url( $url ); ?>" target="<?php echo $target; // WPCS: XSS OK. ?>" class="button"><?php echo wp_kses_data( $url_text ); ?><span class="screen-reader-text"><?php echo wp_kses_post( $title ); ?></span></a></span>
				</div><!-- .custom-header-content-wrapper -->
			</div>
		<?php endif;
	}
endif; // corporatefotografie_header_media_text().

/**
 * Change Custom background default color
 * @param  array $params parent theme Custom Background parameters
 * @return array Modified child theme Custom Background Parameters
 */
function corporatefotografie_custom_background_parameters( $params ) {
	$params['default-color'] = '#1a1a1a';
	return $params;
}
add_filter( 'fotografie_custom_background_args', 'corporatefotografie_custom_background_parameters' );

/**
 * Change Custom header default color
 * @param  array $params parent theme Custom Background parameters
 * @return array Modified child theme Custom Background Parameters
 */
function corporatefotografie_custom_header_parameters( $params ) {
	$params['default-text-color'] = '#383838';
	return $params;
}
add_filter( 'fotografie_custom_header_args', 'corporatefotografie_custom_header_parameters' );

/** allows a sidebar to display on the right side for pages using News template */
add_filter( 'body_class','news_body_classes' );
function news_body_classes( $classes ) {
 
	if ( is_page_template( 'news-page.php' ) ) {
		$classes[] = 'two-columns-layout';
		$classes[] = 'content-left';
	}
    return $classes;     
}


/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Corporate Fotografie 0.1
 */
function corporatefotografie_widgets_init() {
	if ( class_exists( 'Catch_Instagram_Feed_Gallery_Widget' ) ||  class_exists( 'Catch_Instagram_Feed_Gallery_Widget_Pro' ) ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Instagram', 'corporate-fotografie' ),
			'id'            => 'sidebar-instagram',
			'description'   => esc_html__( 'Appears above footer. This sidebar is only for Widget from plugin Catch Instagram Feed Gallery Widget and Catch Instagram Feed Gallery Widget Pro', 'corporate-fotografie' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
	}
}
add_action( 'widgets_init', 'corporatefotografie_widgets_init' );


/**
 * Load Customizer Options
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/customizer.php';

/**
 * Load Upgrade to pro button
 */
require trailingslashit( get_stylesheet_directory() ) . 'class-customize.php';

/**
 * Parent theme override functions
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/override-parent.php';
