<?php
/**
 * Future Imperfect functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Future_Imperfect
 */

if ( ! function_exists( 'future_imperfect_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function future_imperfect_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Future Imperfect, use a find and replace
	 * to change 'future-imperfect' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'future-imperfect', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// add button styles to next/prev links on single posts
	function posts_link_attributes_next( $format ) {
		$format = str_replace('href=', 'class="button big next" href=', $format);
		return $format;
	}
	add_filter('next_post_link', 'posts_link_attributes_next');

	function posts_link_attributes_prev( $format ) {
		$format = str_replace('href=', 'class="button big previous" href=', $format);
		return $format;
	}
	add_filter('previous_post_link', 'posts_link_attributes_prev');

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
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// add custom image sizes
	add_image_size( 'future-imperfect-large', 840, 341, true );
	add_image_size( 'future-imperfect-small', 351, 176, true );
	add_image_size( 'future-imperfect-logo', 350, 170 );

	// add theme support for the custom logo size
	add_theme_support( 'custom-logo', array(
		'size' => 'future-imperfect-logo',
	) );

	/**
	* Generate custom search form
	*
	* @param string $form Form HTML.
	* @return string Modified form HTML.
	*/
	function fm_header_form( $form ) {

		$form = '<a class="fa-search" href="#search">'. esc_attr__( 'Search' ) .'</a>' . "\n";
		$form .= '<form id="search" method="get" action="' . home_url( '/' ) . '">' . "\n";
			$form .= '<input type="text" name="s" id="s" placeholder="'. esc_attr__( 'Search' ) .'" value="' . get_search_query() . '">' . "\n";
		$form .= '</form>' . "\n";

		return $form;
	}
	add_filter( 'get_search_form', 'fm_header_form' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'future-imperfect' ),
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
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'future_imperfect_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'future_imperfect_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function future_imperfect_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'future_imperfect_content_width', 640 );
}
add_action( 'after_setup_theme', 'future_imperfect_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function future_imperfect_widgets_init() {
	register_sidebar( array(
		'name'			=> esc_html__( 'Left Sidebar', 'future-imperfect' ),
		'id'			=> 'sidebar-1',
		'description'	=> '',
		'before_widget' => '<li id="%1$s" class="widget %2$s">' . "\n",
		'after_widget'	=> '</li>' . "\n",
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
	) );

	register_sidebar( array(
		'name'			=> esc_html__( 'Right Sidebar', 'future-imperfect' ),
		'id'			=> 'right-sidebar',
		'description'	=> '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">' . "\n",
		'after_widget'	=> '</section>' . "\n",
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
	) );
}
add_action( 'widgets_init', 'future_imperfect_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function future_imperfect_scripts() {

	global $wp_styles;

	// Loads the font-awesome css
	wp_enqueue_style( 'future-imperfect-font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css' );

	// load the google font
	wp_enqueue_style( 'future-imperfect-google-font', 'http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Raleway:400,800,900' );

	// Loads our main stylesheet.
	wp_enqueue_style( 'future-imperfect-style', get_stylesheet_uri() );

	// load admin css for logged in users
	if ( is_user_logged_in() ) {
		wp_enqueue_style( 'future-imperfect-admin', get_template_directory_uri() . '/assets/css/admin.css', array( 'future-imperfect-style' ), '20121010' );
	}

	// Loads HTML5 shiv
	wp_enqueue_script( 'future-imperfect-html5-shiv', get_template_directory_uri() . '/assets/js/ie/html5shiv.js' );
	wp_script_add_data( 'future-imperfect-html5-shiv', 'conditional', 'lt IE 8' );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'future-imperfect-ie8', get_template_directory_uri() . '/assets/css/ie8.css', array( 'future-imperfect-style' ), '20121010' );
	$wp_styles->add_data( 'future-imperfect-ie8', 'conditional', 'lt IE 8' );

	wp_enqueue_style( 'future-imperfect-ie9', get_template_directory_uri() . '/assets/css/ie9.css', array( 'future-imperfect-style' ), '20121010' );
	$wp_styles->add_data( 'future-imperfect-ie9', 'conditional', 'lt IE 9' );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'future_imperfect_scripts' );

/**
 * Load custom Future Imperfect Widgets
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
