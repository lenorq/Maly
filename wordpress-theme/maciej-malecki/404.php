<?php
/**
 * 404 — off the index.
 *
 * @package maciej-malecki
 */
get_header();
?>
<main id="main" class="section wrap" style="padding-top:clamp(8rem,16vw,12rem);min-height:60vh">
	<div class="sec-head" data-reveal>
		<p class="eyebrow"><span class="tick">+</span> <?php esc_html_e( 'ERR — off the index', 'maciej-malecki' ); ?></p>
		<p class="mono sec-head__id">404</p>
	</div>
	<h1 class="display h-xl" data-reveal style="margin-top:clamp(1.5rem,4vw,2.5rem);max-width:16ch"><?php esc_html_e( 'This plate is not in the archive.', 'maciej-malecki' ); ?></h1>
	<p class="body" data-reveal style="margin-top:1.5rem"><a class="maillink" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Return to the archive', 'maciej-malecki' ); ?> <span class="arw">↗</span></a></p>
</main>
<?php
get_footer();
