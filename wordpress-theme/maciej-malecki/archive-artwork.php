<?php
/**
 * Archive — all plates as a grid.
 *
 * @package maciej-malecki
 */
get_header();
?>
<main id="main" class="section plates wrap" style="padding-top:clamp(7rem,14vw,10rem)">
	<div class="sec-head" data-reveal>
		<p class="eyebrow"><span class="tick">+</span> <?php esc_html_e( 'Plate archive', 'maciej-malecki' ); ?></p>
		<p class="mono sec-head__id"><?php esc_html_e( 'COMPLETE INDEX · CLICK TO ENLARGE', 'maciej-malecki' ); ?></p>
	</div>

	<?php if ( have_posts() ) : ?>
		<div class="archive-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(360px,100%),1fr));gap:clamp(1.5rem,3vw,2.5rem);margin-top:clamp(2.5rem,5vw,3.5rem)">
			<?php
			while ( have_posts() ) :
				the_post();
				$p = mm_plate_from_post( get_the_ID() );
				?>
				<article class="plate">
					<?php mm_render_plate_inner( $p, false, true ); ?>
				</article>
				<?php
			endwhile;
			?>
		</div>
		<div style="margin-top:3rem"><?php the_posts_pagination(); ?></div>
	<?php else : ?>
		<p class="body" style="margin-top:2rem"><?php esc_html_e( 'No plates indexed yet. Add one under Plates → Add plate.', 'maciej-malecki' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();
