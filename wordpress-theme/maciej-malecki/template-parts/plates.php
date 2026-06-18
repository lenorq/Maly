<?php
/**
 * Plates — the gallery. Renders real Artworks if present, else the seed.
 *
 * Layout rules (per plate "layout" field):
 *   full  → full-bleed article
 *   split → tall split article (image + descriptive caption beside)
 *   duo   → packed two-up; consecutive duos are paired into a .plate--duo row
 *
 * @package maciej-malecki
 */
$plates = mm_get_plates();
?>
<section class="section plates wrap" id="works" aria-label="<?php esc_attr_e( 'Selected plates', 'maciej-malecki' ); ?>">
	<div class="sec-head" data-reveal>
		<p class="eyebrow"><span class="tick">+</span> <?php esc_html_e( '01 — Selected plates', 'maciej-malecki' ); ?></p>
		<p class="mono sec-head__id"><?php echo esc_html( sprintf( '%02d / %02d · ', count( $plates ), count( $plates ) ) ); ?><?php esc_html_e( 'CLICK TO ENLARGE', 'maciej-malecki' ); ?></p>
	</div>

	<?php
	$count = count( $plates );
	for ( $i = 0; $i < $count; $i++ ) :
		$p      = $plates[ $i ];
		$layout = isset( $p['layout'] ) ? $p['layout'] : 'duo';

		// First full plate gets a top margin to clear the section head.
		$first_margin = ( 0 === $i ) ? ' style="margin-top:clamp(2.5rem,6vw,4rem)"' : '';

		if ( 'full' === $layout ) :
			?>
			<article class="plate plate--full"<?php echo $first_margin; ?>>
				<?php mm_render_plate_inner( $p, false ); ?>
			</article>
			<?php
		elseif ( 'split' === $layout ) :
			?>
			<article class="plate plate--split">
				<?php mm_render_plate_inner( $p, true ); ?>
			</article>
			<?php
		else : // duo — pair with the next duo if available.
			$pair = array( $p );
			if ( isset( $plates[ $i + 1 ] ) && 'duo' === ( $plates[ $i + 1 ]['layout'] ?? 'duo' ) ) {
				$pair[] = $plates[ $i + 1 ];
				$i++; // consume the partner.
			}
			?>
			<div class="plate plate--duo">
				<?php foreach ( $pair as $dp ) : ?>
					<article class="plate">
						<?php mm_render_plate_inner( $dp, false, true ); ?>
					</article>
				<?php endforeach; ?>
			</div>
			<?php
		endif;
	endfor;
	?>
</section>
