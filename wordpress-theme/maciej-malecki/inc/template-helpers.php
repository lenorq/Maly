<?php
/**
 * Template helpers — catalogue rendering + placeholder seed data.
 *
 * The front page queries the `artwork` post type. Until the client adds real
 * plates, mm_seed_plates() returns the seven bundled demo plates so the design
 * is never empty. Once even one real Artwork exists, the seed is ignored.
 *
 * @package maciej-malecki
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* -------------------------------------------------------------------------
 * Placeholder seed — mirrors the static landing page exactly.
 * ---------------------------------------------------------------------- */
function mm_seed_plates() {
	$img = MM_URI . '/assets/img/';
	return array(
		array(
			'no' => 'MŁ-007', 'title' => 'Great Works', 'layout' => 'full',
			'grid' => $img . 'work-07-panorama-grid', 'full' => $img . 'work-07-panorama-full.webp',
			'w' => 1280, 'h' => 905,
			'alt' => 'Panoramic ink drawing of a sprawling fortified megastructure: arches, cranes and lattice towers rendered in dense white line on black.',
			'meta' => array( 'Medium' => 'Ink on millimetre paper', 'Dimensions' => '140 × 100 cm', 'Density index' => '0.98 / max', 'Status' => 'Original — available' ),
			'lightbox_meta' => 'Ink on millimetre paper · 140 × 100 cm',
		),
		array(
			'no' => 'MŁ-001', 'title' => 'Ascension Shaft', 'layout' => 'split',
			'grid' => $img . 'work-01-ascension-grid', 'full' => $img . 'work-01-ascension-full.webp',
			'w' => 890, 'h' => 1280,
			'alt' => 'Tall vertical ink drawing: a triangular shaft of light driven through a collapsing geometric city, with circular dials ranged down the right edge.',
			'desc' => 'A central wedge of negative space splits a black accretion of towers and instrument dials — the eye is thrown upward through a structure that refuses a single vanishing point.',
			'meta' => array( 'Medium' => 'Ink on paper', 'Dimensions' => '100 × 70 cm', 'Orientation' => 'Portrait', 'Status' => 'Original — available' ),
			'lightbox_meta' => 'Ink on paper · 100 × 70 cm',
		),
		array(
			'no' => 'MŁ-003', 'title' => 'Reliquary Grid', 'layout' => 'duo',
			'grid' => $img . 'work-03-reliquary-grid', 'full' => $img . 'work-03-reliquary-full.webp',
			'w' => 1280, 'h' => 906,
			'alt' => 'Symmetrical white-on-black drawing resembling an ornate reliquary or circuit, built on a faint graph-paper grid.',
			'meta' => array( 'Medium' => 'Ink · mm paper', 'Dimensions' => '70 × 50 cm', 'Symmetry' => 'Bilateral' ),
			'lightbox_meta' => 'Ink on millimetre paper · 70 × 50 cm',
		),
		array(
			'no' => 'MŁ-005', 'title' => 'Transept Engine', 'layout' => 'duo',
			'grid' => $img . 'work-05-transept-grid', 'full' => $img . 'work-05-transept-full.webp',
			'w' => 1280, 'h' => 906,
			'alt' => 'Dense symmetrical drawing of a cruciform machine-cathedral, white linework over a dark grid field.',
			'meta' => array( 'Medium' => 'Ink · mm paper', 'Dimensions' => '70 × 50 cm', 'Symmetry' => 'Bilateral' ),
			'lightbox_meta' => 'Ink on millimetre paper · 70 × 50 cm',
		),
		array(
			'no' => 'MŁ-002', 'title' => 'Interior, No Horizon', 'layout' => 'full',
			'grid' => $img . 'work-02-interior-grid', 'full' => $img . 'work-02-interior-full.webp',
			'w' => 1280, 'h' => 1097,
			'alt' => 'Explosive multi-perspective ink interior — staircases, gantries and lattices radiating from many vanishing points with no fixed horizon.',
			'meta' => array( 'Medium' => 'Ink on paper', 'Dimensions' => '70 × 60 cm', 'Perspective' => 'Multi-point', 'Status' => 'Original — available' ),
			'lightbox_meta' => 'Ink on paper · 70 × 60 cm',
		),
		array(
			'no' => 'MŁ-004', 'title' => 'Event Basin', 'layout' => 'duo',
			'grid' => $img . 'work-04-basin-grid', 'full' => $img . 'work-04-basin-full.webp',
			'w' => 1280, 'h' => 906,
			'alt' => 'Wide drawing with a dark central basin crossed by fine radiating filaments, framed by towers of repeated ornament.',
			'meta' => array( 'Medium' => 'Ink · mm paper', 'Dimensions' => '70 × 50 cm', 'Field' => 'Radial' ),
			'lightbox_meta' => 'Ink on millimetre paper · 70 × 50 cm',
		),
		array(
			'no' => 'MŁ-006', 'title' => 'Nine Orders', 'layout' => 'duo',
			'grid' => $img . 'work-06-colonnade-grid', 'full' => $img . 'work-06-colonnade-full.webp',
			'w' => 1280, 'h' => 906,
			'alt' => 'Stacked horizontal registers of repeating arches and capitals, an impossible colonnade in white line on a dark grid.',
			'meta' => array( 'Medium' => 'Ink · mm paper', 'Dimensions' => '70 × 50 cm', 'Structure' => 'Registered rows' ),
			'lightbox_meta' => 'Ink on millimetre paper · 70 × 50 cm',
		),
	);
}

/* -------------------------------------------------------------------------
 * Normalise a real WP_Post (artwork) into the same array shape as the seed.
 * ---------------------------------------------------------------------- */
function mm_plate_from_post( $post_id ) {
	$full_id = get_post_thumbnail_id( $post_id );
	$grid    = $full_id ? wp_get_attachment_image_url( $full_id, 'mm-grid' ) : '';
	$full    = $full_id ? wp_get_attachment_image_url( $full_id, 'mm-full' ) : '';
	$meta_full = $full_id ? wp_get_attachment_metadata( $full_id ) : array();
	$gw = isset( $meta_full['sizes']['mm-grid']['width'] ) ? $meta_full['sizes']['mm-grid']['width'] : 1280;
	$gh = isset( $meta_full['sizes']['mm-grid']['height'] ) ? $meta_full['sizes']['mm-grid']['height'] : 905;

	$attr_label = get_post_meta( $post_id, 'mm_attribute', true );
	$attr_value = get_post_meta( $post_id, 'mm_attr_value', true );

	$meta = array();
	if ( $m = get_post_meta( $post_id, 'mm_medium', true ) )     { $meta['Medium'] = $m; }
	if ( $d = get_post_meta( $post_id, 'mm_dimensions', true ) ) { $meta['Dimensions'] = $d; }
	if ( $den = get_post_meta( $post_id, 'mm_density', true ) )  { $meta['Density index'] = $den; }
	if ( $attr_label && $attr_value )                            { $meta[ $attr_label ] = $attr_value; }
	if ( $s = get_post_meta( $post_id, 'mm_status', true ) )     { $meta['Status'] = $s; }

	$dims   = get_post_meta( $post_id, 'mm_dimensions', true );
	$medium = get_post_meta( $post_id, 'mm_medium', true );

	return array(
		'no'            => get_post_meta( $post_id, 'mm_catalog_no', true ),
		'title'         => get_the_title( $post_id ),
		'layout'        => get_post_meta( $post_id, 'mm_layout', true ) ?: 'duo',
		'grid'          => $grid ? preg_replace( '/\.(jpe?g|png|webp)$/i', '', $grid ) : '',
		'grid_url'      => $grid,
		'full'          => $full,
		'w'             => $gw,
		'h'             => $gh,
		'alt'           => get_the_title( $post_id ),
		'desc'          => has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : '',
		'meta'          => $meta,
		'lightbox_meta' => trim( $medium . ( $dims ? ' · ' . $dims : '' ), ' ·' ),
	);
}

/**
 * Return plates to render: real artworks if any exist, else the seed.
 */
function mm_get_plates() {
	$q = new WP_Query(
		array(
			'post_type'      => 'artwork',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order date',
			'order'          => 'ASC',
			'no_found_rows'  => true,
		)
	);

	if ( ! $q->have_posts() ) {
		return mm_seed_plates();
	}

	$plates = array();
	foreach ( $q->posts as $p ) {
		$plates[] = mm_plate_from_post( $p->ID );
	}
	wp_reset_postdata();
	return $plates;
}

/* -------------------------------------------------------------------------
 * Render one plate's inner figure + caption. Used by the front page,
 * the artwork archive and single-artwork templates, so it lives here
 * (always loaded) rather than in a template-part.
 *   $with_desc   show the descriptive paragraph (split plates)
 *   $small_title shrink the heading (duo / archive tiles)
 * ---------------------------------------------------------------------- */
function mm_render_plate_inner( $p, $with_desc = false, $small_title = false ) {
	if ( ! empty( $p['grid_url'] ) ) {
		$webp = $p['grid_url'];
		$jpg  = $p['grid_url'];
	} else {
		$webp = $p['grid'] . '.webp';
		$jpg  = $p['grid'] . '.jpg';
	}
	$title_style = $small_title ? ' style="font-size:clamp(1.2rem,2.4vw,1.8rem)"' : '';
	?>
	<figure class="figure brackets" data-reveal-img>
		<button class="figure__btn" data-plate
			data-full="<?php echo esc_url( $p['full'] ); ?>"
			data-no="<?php echo esc_attr( $p['no'] ); ?>"
			data-title="<?php echo esc_attr( $p['title'] ); ?>"
			data-meta="<?php echo esc_attr( $p['lightbox_meta'] ); ?>"
			aria-label="<?php printf( esc_attr__( 'Enlarge plate %1$s — %2$s', 'maciej-malecki' ), esc_attr( $p['no'] ), esc_attr( $p['title'] ) ); ?>"></button>
		<picture>
			<source type="image/webp" srcset="<?php echo esc_url( $webp ); ?>" />
			<img loading="lazy" src="<?php echo esc_url( $jpg ); ?>"
				width="<?php echo (int) $p['w']; ?>" height="<?php echo (int) $p['h']; ?>"
				alt="<?php echo esc_attr( $p['alt'] ); ?>" />
		</picture>
		<div class="figure__hud">
			<span class="ix"><?php echo esc_html( $p['no'] . ' / ' . mb_strtoupper( $p['title'] ) ); ?></span>
			<span class="vw"><?php esc_html_e( 'View plate', 'maciej-malecki' ); ?> <span class="arw">↗</span></span>
		</div>
	</figure>
	<figcaption class="cap" data-reveal>
		<div class="cap__top">
			<h3 class="display cap__title"<?php echo $title_style; ?>><?php echo esc_html( $p['title'] ); ?></h3>
			<span class="mono cap__no"><?php echo esc_html( $p['no'] ); ?></span>
		</div>
		<?php if ( $with_desc && ! empty( $p['desc'] ) ) : ?>
			<p class="body" style="font-size:.82rem"><?php echo esc_html( $p['desc'] ); ?></p>
		<?php endif; ?>
		<?php if ( ! empty( $p['meta'] ) ) : ?>
			<dl class="cap__meta">
				<?php foreach ( $p['meta'] as $k => $v ) : ?>
					<div><dt><?php echo esc_html( $k ); ?></dt><dd><?php echo esc_html( $v ); ?></dd></div>
				<?php endforeach; ?>
			</dl>
		<?php endif; ?>
	</figcaption>
	<?php
}

/* -------------------------------------------------------------------------
 * Exhibitions — editable via a simple repeater stored as theme mod JSON,
 * with a placeholder list matching the static page.
 * ---------------------------------------------------------------------- */
function mm_get_exhibitions() {
	$json = get_theme_mod( 'mm_exhibitions_json', '' );
	if ( $json ) {
		$rows = json_decode( $json, true );
		if ( is_array( $rows ) ) { return $rows; }
	}
	return array(
		array( 'year' => '20—', 'venue' => 'Solo — Drawing Archive', 'city' => 'City, PL' ),
		array( 'year' => '20—', 'venue' => 'Group — Works on Paper', 'city' => 'City, PL' ),
		array( 'year' => '20—', 'venue' => 'Solo — Impossible Cities', 'city' => 'City, EU' ),
		array( 'year' => '20—', 'venue' => 'Group — Line / Density', 'city' => 'City, EU' ),
		array( 'year' => '20—', 'venue' => 'Open studio', 'city' => 'Studio, PL' ),
	);
}
