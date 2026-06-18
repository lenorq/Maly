<?php
/**
 * Theme Customizer — editable site copy so the client can change wording
 * without touching templates. All defaults match the static landing page.
 *
 * @package maciej-malecki
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Helper to fetch a theme-mod with a default.
 */
function mm_opt( $key, $default = '' ) {
	return get_theme_mod( $key, $default );
}

function mm_customize_register( $wp_customize ) {

	/* ----- Panel ----- */
	$wp_customize->add_section(
		'mm_studio',
		array(
			'title'    => __( 'Archive — Studio & copy', 'maciej-malecki' ),
			'priority' => 30,
		)
	);

	$fields = array(
		// key => array(label, default, type)
		'mm_hud_coords'   => array( __( 'HUD coordinates', 'maciej-malecki' ), 'N 52.41° E 16.93° · PL', 'text' ),
		'mm_hero_eyebrow' => array( __( 'Hero eyebrow', 'maciej-malecki' ), 'Draughtsman — works on paper · est. archive', 'text' ),
		'mm_hero_lede'    => array( __( 'Hero lede', 'maciej-malecki' ), 'Impossible architectures, built one ink line at a time.', 'text' ),

		'mm_statement_lede' => array( __( 'Statement — lede', 'maciej-malecki' ), 'Each plate is a single continuous act of attention — a city that exists only on paper.', 'textarea' ),
		'mm_statement_body' => array( __( 'Statement — body (HTML allowed)', 'maciej-malecki' ), "<p>Maciej Małecki draws by hand, in ink, on paper — frequently on millimetre graph paper, the surveyor's grid still visible beneath the structures it can no longer contain. There is no digital stage, no render, no undo.</p><p>The work sits between <strong>blueprint and reliquary</strong> — the cold precision of the technical drawing crossed with the obsessive ornament of cathedral and circuit.</p>", 'textarea' ),

		'mm_bio_lede' => array( __( 'Biography — lede', 'maciej-malecki' ), 'A practice given entirely to the line.', 'text' ),
		'mm_bio_body' => array( __( 'Biography — body (HTML allowed)', 'maciej-malecki' ), '<p>Małecki works alone and slowly, in ink, refusing the shortcuts of the screen. The drawings are built the way buildings used to be — by hand, to the limit of the hand.</p>', 'textarea' ),

		'mm_density_head' => array( __( 'Process — headline', 'maciej-malecki' ), 'Drawn at the threshold where line becomes texture.', 'text' ),

		'mm_contact_intro' => array( __( 'Contact — intro', 'maciej-malecki' ), 'For original drawings, archival prints, exhibition loans or commissions, write to the studio. Each plate is one of a kind.', 'textarea' ),
		'mm_email'         => array( __( 'Studio email', 'maciej-malecki' ), 'studio@maciejmalecki.art', 'text' ),
		'mm_studio_loc'    => array( __( 'Studio location', 'maciej-malecki' ), 'Poland', 'text' ),
		'mm_response'      => array( __( 'Response time', 'maciej-malecki' ), 'Within 3 working days', 'text' ),

		'mm_instagram' => array( __( 'Instagram URL', 'maciej-malecki' ), '', 'url' ),
		'mm_behance'   => array( __( 'Behance URL', 'maciej-malecki' ), '', 'url' ),
		'mm_shop'      => array( __( 'Print shop URL', 'maciej-malecki' ), '', 'url' ),

		'mm_contact_form' => array( __( 'Contact form shortcode (CF7 / WPForms). Leave blank to use the built-in mailto form.', 'maciej-malecki' ), '', 'textarea' ),
	);

	foreach ( $fields as $key => $cfg ) {
		list( $label, $default, $type ) = $cfg;
		$sanitize = ( 'url' === $type ) ? 'esc_url_raw' : ( 'textarea' === $type ? 'wp_kses_post' : 'sanitize_text_field' );

		$wp_customize->add_setting(
			$key,
			array(
				'default'           => $default,
				'sanitize_callback' => $sanitize,
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'label'   => $label,
				'section' => 'mm_studio',
				'type'    => ( 'textarea' === $type ) ? 'textarea' : ( 'url' === $type ? 'url' : 'text' ),
			)
		);
	}
}
add_action( 'customize_register', 'mm_customize_register' );
