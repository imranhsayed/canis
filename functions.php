<?php
/**
 * canis functions and definitions
 *
 * @package canis
 */

if ( ! defined( 'BLANK_THEME_VERSION' ) ) {
	define( 'BLANK_THEME_VERSION', 1.0 );
}
if ( ! defined( 'BLANK_THEME_TEMP_URI' ) ) {
	define( 'BLANK_THEME_TEMP_URI', get_template_directory_uri() );
}
if ( ! defined( 'BLANK_THEME_TEMP_DIR' ) ) {
	define( 'BLANK_THEME_TEMP_DIR', get_template_directory() );
}
if ( ! defined( 'BLANK_THEME_CSS_URI' ) ) {
	define( 'BLANK_THEME_CSS_URI', BLANK_THEME_TEMP_URI . '/css' );
}
if ( ! defined( 'BLANK_THEME_JS_URI' ) ) {
	define( 'BLANK_THEME_JS_URI', BLANK_THEME_TEMP_URI . '/js' );
}
if ( ! defined( 'BLANK_THEME_IMG_URI' ) ) {
	define( 'BLANK_THEME_IMG_URI', BLANK_THEME_TEMP_URI . '/images' );
}
if ( ! defined( 'BLANK_THEME_IS_DEV' ) ) {
	define( 'BLANK_THEME_IS_DEV', true );
}

do_action( 'canis_before' );

if ( ! function_exists( 'canis_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function canis_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on canis, use a find and replace
		 * to change 'canis' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'canis', BLANK_THEME_TEMP_DIR . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for custom logo.
		 */
		add_theme_support( 'custom-logo', array( 'header-text' => array( 'site-title', 'site-description' ) ) );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'canis' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'status',
			'audio',
			'chat',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'canis_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		add_theme_support( 'custom-header', apply_filters( 'canis_custom_header_args', array(
			'default-image'          => '',
			'default-text-color'     => '000000',
			'width'                  => 1000,
			'height'                 => 250,
			'flex-height'            => true,
			'wp-head-callback'       => 'canis_header_style',
		) ) );

		add_editor_style( array( 'editor-style.css', canis_main_font_url() ) );

		// Indicate widget sidebars can use selective refresh in the Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		do_action( 'canis_after_setup_theme' );
	}
endif; // canis_setup
add_action( 'after_setup_theme', 'canis_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function canis_content_width() {
	global $content_width;
	$content_width = apply_filters( 'canis_content_width', 640 );
}
add_action( 'after_setup_theme', 'canis_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function canis_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'canis' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget widget-sidebar %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'canis' ),
		'id'            => 'sidebar-2',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget widget-footer cell column %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'canis_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function canis_scripts() {
	/*==============================
	          GOOGLE FONTS
	===============================*/

	//wp_enqueue_style( 'google-font-opensanscondensed', canis_main_font_url() );

	/*==============================
	          STYLES
	===============================*/

	wp_enqueue_style( 'canis-style', get_stylesheet_uri() );

	/*==============================
	          SCRIPTS
	===============================*/

	if ( BLANK_THEME_IS_DEV ) {
		wp_register_script( 'canis-nav', BLANK_THEME_JS_URI . '/vendor/navigation.js', array( 'jquery' ), BLANK_THEME_VERSION, true );
		wp_register_script( 'canis-mmenu', BLANK_THEME_JS_URI . '/vendor/jquery.mmenu.min.all.js', array( 'jquery' ), BLANK_THEME_VERSION, true );
		wp_register_script( 'canis-slick', BLANK_THEME_JS_URI . '/vendor/slick.js', array( 'jquery' ), BLANK_THEME_VERSION, true );
		wp_register_script( 'canis-main', BLANK_THEME_JS_URI . '/main.js', array( 'jquery', 'canis-nav', 'canis-mmenu', 'canis-slick' ), BLANK_THEME_VERSION, true );
	} else {

		wp_register_script( 'canis-main', BLANK_THEME_JS_URI . '/main.min.js', array( 'jquery' ), BLANK_THEME_VERSION, true );
	}

	wp_enqueue_script( 'canis-main' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'canis_scripts' );


/*==============================
          FILE INCLUDES
===============================*/

$canis_depedencies = apply_filters( 'canis_depedencies', array(
	BLANK_THEME_TEMP_DIR . '/inc/*.php',
	BLANK_THEME_TEMP_DIR . '/admin/*.php',
));

foreach ( $canis_depedencies as $path ) {
	foreach ( glob( $path ) as $filename ) {
		include $filename;
	}
}

do_action( 'canis_after' );
