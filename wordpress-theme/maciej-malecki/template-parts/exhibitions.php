<?php
/**
 * Exhibitions / biography — portrait, bio, exhibition list.
 *
 * @package maciej-malecki
 */
$portrait = MM_URI . '/assets/img/portrait-artist.jpg';
$exhibitions = mm_get_exhibitions();
?>
<section class="section wrap" id="exhibitions" aria-label="<?php esc_attr_e( 'Exhibitions and biography', 'maciej-malecki' ); ?>">
	<div class="sec-head" data-reveal>
		<p class="eyebrow"><span class="tick">+</span> <?php esc_html_e( '03 — The draughtsman', 'maciej-malecki' ); ?></p>
		<p class="mono sec-head__id"><?php esc_html_e( 'FIG. 08 — RECORD', 'maciej-malecki' ); ?></p>
	</div>

	<div class="bio__grid">
		<figure class="portrait brackets" data-reveal-img>
			<img loading="lazy" src="<?php echo esc_url( $portrait ); ?>" width="1400" height="933"
				alt="<?php esc_attr_e( 'Maciej Małecki, the artist, standing at a gallery opening holding a single red rose, framed works on the wall behind him.', 'maciej-malecki' ); ?>" />
			<figcaption><span><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span><span><?php esc_html_e( 'OPENING NIGHT', 'maciej-malecki' ); ?></span></figcaption>
		</figure>

		<div data-reveal style="transition-delay:.08s">
			<p class="lede" style="max-width:26ch;margin-bottom:1.6rem"><?php echo esc_html( mm_opt( 'mm_bio_lede', 'A practice given entirely to the line.' ) ); ?></p>
			<div class="body">
				<?php echo wp_kses_post( mm_opt( 'mm_bio_body', '<p>Małecki works alone and slowly, in ink, refusing the shortcuts of the screen. The drawings are built the way buildings used to be — by hand, to the limit of the hand.</p>' ) ); ?>
			</div>

			<div class="cv">
				<h3><?php esc_html_e( 'Selected exhibitions', 'maciej-malecki' ); ?></h3>
				<ul class="cv__list">
					<?php foreach ( $exhibitions as $row ) : ?>
						<li>
							<span class="yr"><?php echo esc_html( $row['year'] ); ?></span>
							<span class="ven"><?php echo esc_html( $row['venue'] ); ?></span>
							<span class="city"><?php echo esc_html( $row['city'] ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
