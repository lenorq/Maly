<?php
/**
 * Artwork custom post type + catalogue metadata.
 *
 * Native implementation — no ACF required. (ACF is offered as an optional
 * upgrade in the README; the field keys below match the ACF names so you can
 * switch without touching the templates.)
 *
 * @package maciej-malecki
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* -------------------------------------------------------------------------
 * Register the post type + taxonomy
 * ---------------------------------------------------------------------- */
function mm_register_artwork() {
	$labels = array(
		'name'               => __( 'Plates', 'maciej-malecki' ),
		'singular_name'      => __( 'Plate', 'maciej-malecki' ),
		'menu_name'          => __( 'Plates', 'maciej-malecki' ),
		'add_new'            => __( 'Add plate', 'maciej-malecki' ),
		'add_new_item'       => __( 'Add new plate', 'maciej-malecki' ),
		'edit_item'          => __( 'Edit plate', 'maciej-malecki' ),
		'new_item'           => __( 'New plate', 'maciej-malecki' ),
		'view_item'          => __( 'View plate', 'maciej-malecki' ),
		'search_items'       => __( 'Search plates', 'maciej-malecki' ),
		'not_found'          => __( 'No plates found', 'maciej-malecki' ),
		'all_items'          => __( 'All plates', 'maciej-malecki' ),
	);

	register_post_type(
		'artwork',
		array(
			'labels'        => $labels,
			'public'        => true,
			'has_archive'   => true,
			'menu_icon'     => 'dashicons-art',
			'menu_position' => 5,
			'rewrite'       => array( 'slug' => 'plates' ),
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
			'show_in_rest'  => true, // Gutenberg + REST.
		)
	);

	register_taxonomy(
		'plate_series',
		'artwork',
		array(
			'labels'            => array(
				'name'          => __( 'Series', 'maciej-malecki' ),
				'singular_name' => __( 'Series', 'maciej-malecki' ),
			),
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'series' ),
		)
	);
}
add_action( 'init', 'mm_register_artwork' );

/* -------------------------------------------------------------------------
 * Catalogue meta fields
 * ---------------------------------------------------------------------- */
function mm_artwork_fields() {
	return array(
		'mm_catalog_no'  => __( 'Catalogue no. (e.g. MŁ-007)', 'maciej-malecki' ),
		'mm_year'        => __( 'Year', 'maciej-malecki' ),
		'mm_medium'      => __( 'Medium', 'maciej-malecki' ),
		'mm_dimensions'  => __( 'Dimensions (e.g. 140 × 100 cm)', 'maciej-malecki' ),
		'mm_density'     => __( 'Density index (e.g. 0.98 / max)', 'maciej-malecki' ),
		'mm_attribute'   => __( 'Extra row label (e.g. Symmetry / Field)', 'maciej-malecki' ),
		'mm_attr_value'  => __( 'Extra row value (e.g. Bilateral)', 'maciej-malecki' ),
		'mm_status'      => __( 'Status (e.g. Original — available)', 'maciej-malecki' ),
		'mm_layout'      => __( 'Layout: full | split | duo', 'maciej-malecki' ),
	);
}

// Register meta for REST / block editor visibility.
function mm_register_meta() {
	foreach ( array_keys( mm_artwork_fields() ) as $key ) {
		register_post_meta(
			'artwork',
			$key,
			array(
				'show_in_rest'      => true,
				'single'            => true,
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
				'auth_callback'     => function () { return current_user_can( 'edit_posts' ); },
			)
		);
	}
}
add_action( 'init', 'mm_register_meta' );

function mm_add_meta_box() {
	add_meta_box(
		'mm_catalog',
		__( 'Catalogue record', 'maciej-malecki' ),
		'mm_render_meta_box',
		'artwork',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'mm_add_meta_box' );

function mm_render_meta_box( $post ) {
	wp_nonce_field( 'mm_save_catalog', 'mm_catalog_nonce' );
	echo '<style>.mm-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px 22px}.mm-grid p{margin:0}.mm-grid label{display:block;font-weight:600;margin-bottom:4px;font-size:12px}.mm-grid input{width:100%}</style>';
	echo '<div class="mm-grid">';
	foreach ( mm_artwork_fields() as $key => $label ) {
		$val = esc_attr( get_post_meta( $post->ID, $key, true ) );
		printf(
			'<p><label for="%1$s">%2$s</label><input type="text" id="%1$s" name="%1$s" value="%3$s" /></p>',
			esc_attr( $key ),
			esc_html( $label ),
			$val
		);
	}
	echo '</div>';
	echo '<p style="margin-top:12px;color:#787878">The <strong>Featured image</strong> is the plate scan shown in the grid and lightbox. Upload the full-resolution scan — WordPress generates the sized versions automatically.</p>';
}

function mm_save_meta( $post_id ) {
	if ( ! isset( $_POST['mm_catalog_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['mm_catalog_nonce'] ), 'mm_save_catalog' ) ) { return; }
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }

	foreach ( array_keys( mm_artwork_fields() ) as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}
}
add_action( 'save_post_artwork', 'mm_save_meta' );

/* -------------------------------------------------------------------------
 * Admin column: show catalogue no.
 * ---------------------------------------------------------------------- */
function mm_artwork_columns( $cols ) {
	$new = array();
	foreach ( $cols as $k => $v ) {
		$new[ $k ] = $v;
		if ( 'title' === $k ) {
			$new['mm_catalog_no'] = __( 'Cat. no.', 'maciej-malecki' );
		}
	}
	return $new;
}
add_filter( 'manage_artwork_posts_columns', 'mm_artwork_columns' );

function mm_artwork_column_content( $col, $post_id ) {
	if ( 'mm_catalog_no' === $col ) {
		echo esc_html( get_post_meta( $post_id, 'mm_catalog_no', true ) );
	}
}
add_action( 'manage_artwork_posts_custom_column', 'mm_artwork_column_content', 10, 2 );
