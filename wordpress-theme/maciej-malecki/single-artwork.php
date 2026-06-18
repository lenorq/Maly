<?php
/**
 * Single plate — full scan + catalogue record.
 *
 * @package maciej-malecki
 */
get_header();

while ( have_posts() ) :
	the_post();
	$id   = get_the_ID();
	$p    = mm_plate_from_post( $id );
	$full = $p['full'] ? $p['full'] : ( has_post_thumbnail() ? get_the_post_thumbnail_url( $id, 'mm-full' ) : '' );
	?>
	<main id="main" class="section wrap" style="padding-top:clamp(7rem,14vw,10rem)">
		<div class="sec-head" data-reveal>
			<p class="eyebrow"><span class="tick">+</span> <?php echo esc_html( $p['no'] ); ?></p>
			<p class="mono sec-head__id"><a href="<?php echo esc_url( get_post_type_archive_link( 'artwork' ) ); ?>" style="color:var(--fg-dim)"><?php esc_html_e( '← ALL PLATES', 'maciej-malecki' ); ?></a></p>
		</div>

		<article class="plate plate--full" style="margin-top:clamp(2rem,5vw,3rem)">
			<figure class="figure brackets" data-reveal-img>
				<?php if ( $full ) : ?>
					<button class="figure__btn" data-plate
						data-full="<?php echo esc_url( $full ); ?>"
						data-no="<?php echo esc_attr( $p['no'] ); ?>"
						data-title="<?php echo esc_attr( $p['title'] ); ?>"
						data-meta="<?php echo esc_attr( $p['lightbox_meta'] ); ?>"
						aria-label="<?php esc_attr_e( 'Enlarge plate', 'maciej-malecki' ); ?>"></button>
				<?php endif; ?>
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'mm-grid', array( 'loading' => 'eager' ) );
				}
				?>
				<div class="figure__hud">
					<span class="ix"><?php echo esc_html( $p['no'] . ' / ' . mb_strtoupper( $p['title'] ) ); ?></span>
					<span class="vw"><?php esc_html_e( 'View plate', 'maciej-malecki' ); ?> <span class="arw">↗</span></span>
				</div>
			</figure>

			<figcaption class="cap" data-reveal>
				<div class="cap__top">
					<h1 class="display cap__title"><?php the_title(); ?></h1>
					<span class="mono cap__no"><?php echo esc_html( $p['no'] ); ?></span>
				</div>
				<?php if ( get_the_content() ) : ?>
					<div class="body" style="margin:1.2rem 0"><?php the_content(); ?></div>
				<?php endif; ?>
				<?php if ( ! empty( $p['meta'] ) ) : ?>
					<dl class="cap__meta">
						<?php foreach ( $p['meta'] as $k => $v ) : ?>
							<div><dt><?php echo esc_html( $k ); ?></dt><dd><?php echo esc_html( $v ); ?></dd></div>
						<?php endforeach; ?>
					</dl>
				<?php endif; ?>
				<p style="margin-top:2rem"><a class="maillink" href="mailto:<?php echo esc_attr( mm_opt( 'mm_email', 'studio@maciejmalecki.art' ) ); ?>?subject=<?php echo esc_attr( rawurlencode( $p['no'] . ' — ' . $p['title'] ) ); ?>"><?php esc_html_e( 'Inquire about this plate', 'maciej-malecki' ); ?> <span class="arw">↗</span></a></p>
			</figcaption>
		</article>
	</main>
	<?php
endwhile;

get_footer();
