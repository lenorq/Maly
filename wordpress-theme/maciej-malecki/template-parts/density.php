<?php
/**
 * Density / process — big statement, stat row, three detail crops.
 *
 * @package maciej-malecki
 */
$img = MM_URI . '/assets/img/';
?>
<section class="section density" id="density" aria-label="<?php esc_attr_e( 'Process and density', 'maciej-malecki' ); ?>">
	<div class="wrap">
		<div class="sec-head" data-reveal>
			<p class="eyebrow"><span class="tick">+</span> <?php esc_html_e( '02 — Process / density', 'maciej-malecki' ); ?></p>
			<p class="mono sec-head__id"><?php esc_html_e( 'NO DIGITAL · HAND ONLY', 'maciej-malecki' ); ?></p>
		</div>

		<div class="density__head" data-reveal style="margin-top:clamp(2rem,5vw,3rem)">
			<h2 class="display h-lg" style="max-width:18ch"><?php echo esc_html( mm_opt( 'mm_density_head', 'Drawn at the threshold where line becomes texture.' ) ); ?></h2>
		</div>

		<div class="density__stats" data-stagger>
			<div class="stat"><b>100<span class="u">%</span></b><span><?php esc_html_e( 'Hand-drawn', 'maciej-malecki' ); ?></span></div>
			<div class="stat"><b>0<span class="u">px</span></b><span><?php esc_html_e( 'Digital marks', 'maciej-malecki' ); ?></span></div>
			<div class="stat"><b>0.1<span class="u">mm</span></b><span><?php esc_html_e( 'Finest nib', 'maciej-malecki' ); ?></span></div>
			<div class="stat"><b>007</b><span><?php esc_html_e( 'Plates indexed', 'maciej-malecki' ); ?></span></div>
			<div class="stat"><b>∞</b><span><?php esc_html_e( 'Vanishing points', 'maciej-malecki' ); ?></span></div>
		</div>

		<div class="crops" data-reveal-img aria-hidden="true">
			<figure class="crop"><img loading="lazy" src="<?php echo esc_url( $img . 'work-05-transept-full.jpg' ); ?>" alt="" style="object-position:30% 30%"><figcaption>DET. MŁ-005</figcaption></figure>
			<figure class="crop"><img loading="lazy" src="<?php echo esc_url( $img . 'work-07-panorama-full.jpg' ); ?>" alt="" style="object-position:60% 50%"><figcaption>DET. MŁ-007</figcaption></figure>
			<figure class="crop"><img loading="lazy" src="<?php echo esc_url( $img . 'work-01-ascension-full.jpg' ); ?>" alt="" style="object-position:10% 80%"><figcaption>DET. MŁ-001</figcaption></figure>
		</div>
	</div>
</section>
