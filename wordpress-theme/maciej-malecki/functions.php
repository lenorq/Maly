<?php
/**
 * Maciej Małecki — Drawing Archive
 * Theme bootstrap: supports, assets, menus, includes.
 *
 * @package maciej-malecki
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'MM_VERSION', '1.0.0' );
define( 'MM_DIR', get_template_directory() );
define( 'MM_URI', get_template_directory_uri() );

/* -------------------------------------------------------------------------
 * 1 · Theme supports
 * ---------------------------------------------------------------------- */
function mm_setup() {
	load_theme_textdomain( 'maciej-malecki', MM_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support(
		'custom-logo',
		array( 'height' => 48, 'width' => 48, 'flex-height' => true, 'flex-width' => true )
	);

	// Image sizes tuned for the huge scanned plates.
	add_image_size( 'mm-full', 2000, 0, false );   // lightbox / hero
	add_image_size( 'mm-grid', 1280, 0, false );   // gallery tiles
	add_image_size( 'mm-thumb', 720, 0, false );    // ticker / crops

	register_nav_menus(
		array(
			'primary' => __( 'Primary navigation', 'maciej-malecki' ),
			'footer'  => __( 'Footer — index', 'maciej-malecki' ),
		)
	);
}
add_action( 'after_setup_theme', 'mm_setup' );

/* -------------------------------------------------------------------------
 * 2 · Assets
 * ---------------------------------------------------------------------- */
function mm_enqueue_assets() {
	// Google Fonts — Archivo (display) + Space Mono (telemetry/labels).
	wp_enqueue_style(
		'mm-fonts',
		'https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800;900&family=Space+Mono:wght@400;700&display=swap',
		array(),
		null
	);

	// Design system.
	wp_enqueue_style( 'mm-style', MM_URI . '/assets/css/style.css', array( 'mm-fonts' ), MM_VERSION );

	// WordPress requires the root style.css to be enqueued for child-theme overrides.
	wp_enqueue_style( 'mm-theme', get_stylesheet_uri(), array( 'mm-style' ), MM_VERSION );

	// Interaction layer (reveals, HUD clock, lightbox). Deferred.
	wp_enqueue_script( 'mm-main', MM_URI . '/assets/js/main.js', array(), MM_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mm_enqueue_assets' );

// Add defer to the main script (progressive enhancement).
function mm_defer_main( $tag, $handle ) {
	if ( 'mm-main' === $handle ) {
		return str_replace( ' src', ' defer src', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'mm_defer_main', 10, 2 );

// Preconnect to Google Fonts.
function mm_resource_hints( $hints, $relation ) {
	if ( 'preconnect' === $relation ) {
		$hints[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'mm_resource_hints', 10, 2 );

/* -------------------------------------------------------------------------
 * 3 · Includes
 * ---------------------------------------------------------------------- */
require_once MM_DIR . '/inc/cpt.php';          // Artwork custom post type + meta.
require_once MM_DIR . '/inc/customizer.php';   // Editable site text (studio, contact…).
require_once MM_DIR . '/inc/template-helpers.php'; // Catalog rendering helpers + seed data.

/* -------------------------------------------------------------------------
 * 4 · Misc niceties
 * ---------------------------------------------------------------------- */
// Body theme-color meta + cleaner <head>.
function mm_head_meta() {
	echo '<meta name="theme-color" content="#0a0a0a" />' . "\n";
}
add_action( 'wp_head', 'mm_head_meta', 1 );

// Let the lightbox open full-size scans: expose a reasonable big size.
function mm_excerpt_more() { return ' …'; }
add_filter( 'excerpt_more', 'mm_excerpt_more' );
