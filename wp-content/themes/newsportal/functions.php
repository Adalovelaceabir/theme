<?php
/**
 * NewsPortal functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package NewsPortal
 */

if ( ! defined( 'NEWSPORTAL_VERSION' ) ) {
	define( 'NEWSPORTAL_VERSION', '1.0.0' );
}

if ( ! function_exists( 'newsportal_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function newsportal_setup() {
		// Make theme available for translation
		load_theme_textdomain( 'newsportal', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages
		add_theme_support( 'post-thumbnails' );

		// Register menus
		register_nav_menus(
			array(
				'main-menu' => esc_html__( 'Primary Menu', 'newsportal' ),
				'footer-menu' => esc_html__( 'Footer Menu', 'newsportal' ),
			)
		);

		// Switch default core markup to output valid HTML5
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature
		add_theme_support(
			'custom-background',
			apply_filters(
				'newsportal_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for core custom logo
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'newsportal_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function newsportal_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'newsportal_content_width', 1140 );
}
add_action( 'after_setup_theme', 'newsportal_content_width', 0 );

/**
 * Register widget area.
 */
function newsportal_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'newsportal' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'newsportal' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widgets', 'newsportal' ),
			'id'            => 'footer-widgets',
			'description'   => esc_html__( 'Add footer widgets here.', 'newsportal' ),
			'before_widget' => '<div class="footer-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="footer-widget-title">',
			'after_title'   => '</h5>',
		)
	);
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Header Ad', 'newsportal' ),
			'id'            => 'header-ad',
			'description'   => esc_html__( 'Add header advertisement here.', 'newsportal' ),
			'before_widget' => '<div class="header-ad-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="header-ad-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'newsportal_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function newsportal_scripts() {
	// Main stylesheet
	wp_enqueue_style( 'newsportal-style', get_stylesheet_uri(), array(), NEWSPORTAL_VERSION );
	
	// Font Awesome
	wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' );
	
	// Google Fonts
	wp_enqueue_style( 'newsportal-google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Playfair+Display:wght@400;700&display=swap' );
	
	// Main JavaScript
	wp_enqueue_script( 'newsportal-script', get_template_directory_uri() . '/assets/js/main.js', array(), NEWSPORTAL_VERSION, true );
	
	// Comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'newsportal_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Custom Admin Panel
 */
require get_template_directory() . '/admin/admin-functions.php';
