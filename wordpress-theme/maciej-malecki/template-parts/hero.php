<?php
/**
 * Hero — panorama background + name lockup.
 *
 * Uses the front page's "featured image" as the hero plate if set, otherwise
 * the bundled panorama scan.
 *
 * @package maciej-malecki
 */
$hero_webp = MM_URI . '/assets/img/work-07-panorama-full.webp';
$hero_jpg  = MM_URI . '/assets/img/work-07-panorama-full.jpg';

if ( has_post_thumbnail() ) {
	$tid = get_post_thumbnail_id();
	$u   = wp_get_attachment_image_url( $tid, 'mm-full' );
	if ( $u ) { $hero_webp = $u; $hero_jpg = $u; }
}
?>
<section class="hero" aria-label="<?php esc_attr_e( 'Introduction', 'maciej-malecki' ); ?>">
	<div class="hero__bg" data-reveal-img>
		<picture>
			<source type="image/webp" srcset="<?php echo esc_url( $hero_webp ); ?>" />
			<img src="<?php echo esc_url( $hero_jpg ); ?>" alt="<?php esc_attr_e( 'A vast, dense pen-and-ink drawing of an impossible cathedral-machine city seen in steep perspective.', 'maciej-malecki' ); ?>" fetchpriority="high" width="2000" height="1414" />
		</picture>
	</div>
	<div class="hero__scan" aria-hidden="true"></div>

	<div class="wrap hero__inner">
		<p class="eyebrow hero__eyebrow"><span class="tick">+</span> <?php echo esc_html( mm_opt( 'mm_hero_eyebrow', 'Draughtsman — works on paper · est. archive' ) ); ?></p>
		<?php
		$name  = get_bloginfo( 'name' );
		$parts = explode( ' ', $name, 2 );
		?>
		<h1 class="display h-mega hero__title">
			<span class="line"><span data-reveal><?php echo esc_html( $parts[0] ); ?></span></span>
			<?php if ( ! empty( $parts[1] ) ) : ?>
				<span class="line"><span data-reveal style="transition-delay:.08s"><?php echo esc_html( $parts[1] ); ?></span></span>
			<?php endif; ?>
		</h1>
		<div class="hero__sub">
			<p class="lede hero__lede" data-reveal style="transition-delay:.16s"><?php echo esc_html( mm_opt( 'mm_hero_lede', 'Impossible architectures, built one ink line at a time.' ) ); ?></p>
			<dl class="hero__meta mono" data-reveal style="transition-delay:.22s">
				<div><?php esc_html_e( 'Medium — ink on paper', 'maciej-malecki' ); ?></div>
				<div><?php esc_html_e( 'Method — 100% hand-drawn', 'maciej-malecki' ); ?></div>
				<div><?php esc_html_e( 'Index — 007 plates', 'maciej-malecki' ); ?></div>
			</dl>
		</div>
	</div>

	<div class="hero__cue" aria-hidden="true"><span class="line"></span><span><?php esc_html_e( 'Scroll', 'maciej-malecki' ); ?></span></div>
</section>
