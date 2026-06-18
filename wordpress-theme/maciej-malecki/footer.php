<?php
/**
 * Footer — footer index, lightbox dialog, wp_footer.
 *
 * @package maciej-malecki
 */
$home = home_url( '/' );
$ig   = mm_opt( 'mm_instagram' );
$be   = mm_opt( 'mm_behance' );
$shop = mm_opt( 'mm_shop' );
$mail = mm_opt( 'mm_email', 'studio@maciejmalecki.art' );
?>
<footer class="foot wrap">
	<div class="foot__cols">
		<div class="foot__col">
			<h4><?php esc_html_e( 'Index', 'maciej-malecki' ); ?></h4>
			<a href="<?php echo esc_url( $home . '#works' ); ?>"><?php esc_html_e( 'Plates', 'maciej-malecki' ); ?></a>
			<a href="<?php echo esc_url( $home . '#density' ); ?>"><?php esc_html_e( 'Process', 'maciej-malecki' ); ?></a>
			<a href="<?php echo esc_url( $home . '#exhibitions' ); ?>"><?php esc_html_e( 'Exhibitions', 'maciej-malecki' ); ?></a>
			<a href="<?php echo esc_url( $home . '#contact' ); ?>"><?php esc_html_e( 'Inquire', 'maciej-malecki' ); ?></a>
		</div>
		<div class="foot__col">
			<h4><?php esc_html_e( 'Elsewhere', 'maciej-malecki' ); ?></h4>
			<a href="<?php echo $ig ? esc_url( $ig ) : '#'; ?>" rel="noopener">Instagram</a>
			<a href="<?php echo $be ? esc_url( $be ) : '#'; ?>" rel="noopener">Behance</a>
			<a href="<?php echo $shop ? esc_url( $shop ) : '#'; ?>" rel="noopener"><?php esc_html_e( 'Print shop', 'maciej-malecki' ); ?></a>
		</div>
		<div class="foot__col">
			<h4><?php esc_html_e( 'Studio', 'maciej-malecki' ); ?></h4>
			<p><?php esc_html_e( 'Ink on paper', 'maciej-malecki' ); ?></p>
			<p><?php echo esc_html( mm_opt( 'mm_studio_loc', 'Poland' ) ); ?></p>
			<a href="mailto:<?php echo esc_attr( $mail ); ?>"><?php echo esc_html( $mail ); ?></a>
		</div>
		<div class="foot__col">
			<h4><?php esc_html_e( 'Language', 'maciej-malecki' ); ?></h4>
			<?php
			// If Polylang/WPML is active, show its switcher; else static EN/PL.
			if ( function_exists( 'pll_the_languages' ) ) {
				pll_the_languages( array( 'show_flags' => 0, 'show_names' => 1 ) );
			} else {
				echo '<a href="#" aria-current="true">EN</a><a href="#">PL</a>';
			}
			?>
		</div>
	</div>

	<div class="foot__mark" aria-hidden="true">MAŁECKI</div>

	<div class="foot__legal">
		<span>© <span data-year><?php echo esc_html( gmdate( 'Y' ) ); ?></span> <?php echo esc_html( get_bloginfo( 'name' ) ); ?> — <?php esc_html_e( 'All works reproduced by permission', 'maciej-malecki' ); ?></span>
		<a class="totop" href="#top"><?php esc_html_e( 'Back to top', 'maciej-malecki' ); ?> <span class="arw">↑</span></a>
	</div>
</footer>

<!-- =========================== LIGHTBOX =========================== -->
<div class="lb" id="lightbox" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Plate viewer', 'maciej-malecki' ); ?>" aria-hidden="true">
	<div class="lb__bar">
		<span data-lb-index>MŁ-000 · 00 / 07</span>
		<button class="lb__close" aria-label="<?php esc_attr_e( 'Close viewer', 'maciej-malecki' ); ?>"><?php esc_html_e( 'Close', 'maciej-malecki' ); ?> <span class="x" aria-hidden="true">✕</span></button>
	</div>
	<div class="lb__stage">
		<img src="" alt="" />
	</div>
	<div class="lb__cap">
		<span><b data-lb-title>—</b> &nbsp;·&nbsp; <span data-lb-meta>—</span></span>
		<span class="lb__nav">
			<button data-lb-prev aria-label="<?php esc_attr_e( 'Previous plate', 'maciej-malecki' ); ?>">← <?php esc_html_e( 'Prev', 'maciej-malecki' ); ?></button>
			<button data-lb-next aria-label="<?php esc_attr_e( 'Next plate', 'maciej-malecki' ); ?>"><?php esc_html_e( 'Next', 'maciej-malecki' ); ?> →</button>
		</span>
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>
