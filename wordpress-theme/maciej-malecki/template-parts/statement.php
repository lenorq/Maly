<?php
/**
 * Statement — manifesto + datasheet.
 *
 * @package maciej-malecki
 */
?>
<section class="section statement wrap" aria-label="<?php esc_attr_e( 'Statement', 'maciej-malecki' ); ?>">
	<span class="statement__ghost" aria-hidden="true">ARCHIVE</span>
	<div class="sec-head" data-reveal>
		<p class="eyebrow"><span class="tick">+</span> <?php esc_html_e( '00 — Statement', 'maciej-malecki' ); ?></p>
		<p class="mono sec-head__id">RYSUNEK · TUSZ NA PAPIERZE</p>
	</div>

	<div class="statement__grid">
		<div class="statement__body" data-reveal>
			<p class="lede" style="max-width:30ch;margin-bottom:2rem"><?php echo esc_html( mm_opt( 'mm_statement_lede', 'Each plate is a single continuous act of attention — a city that exists only on paper.' ) ); ?></p>
			<div class="body">
				<?php echo wp_kses_post( mm_opt( 'mm_statement_body', "<p>Maciej Małecki draws by hand, in ink, on paper — frequently on millimetre graph paper, the surveyor's grid still visible beneath the structures it can no longer contain. There is no digital stage, no render, no undo.</p><p>The work sits between <strong>blueprint and reliquary</strong> — the cold precision of the technical drawing crossed with the obsessive ornament of cathedral and circuit.</p>" ) ); ?>
			</div>
		</div>

		<aside class="statement__side" data-reveal style="transition-delay:.1s">
			<dl class="sheet">
				<div class="sheet__row"><dt><?php esc_html_e( 'Discipline', 'maciej-malecki' ); ?></dt><dd><?php esc_html_e( 'Drawing — works on paper', 'maciej-malecki' ); ?></dd></div>
				<div class="sheet__row"><dt><?php esc_html_e( 'Medium', 'maciej-malecki' ); ?></dt><dd><?php esc_html_e( 'Technical ink, 0.1–0.5 mm', 'maciej-malecki' ); ?></dd></div>
				<div class="sheet__row"><dt><?php esc_html_e( 'Support', 'maciej-malecki' ); ?></dt><dd><?php esc_html_e( 'Paper / millimetre paper', 'maciej-malecki' ); ?></dd></div>
				<div class="sheet__row"><dt><?php esc_html_e( 'Process', 'maciej-malecki' ); ?></dt><dd><?php esc_html_e( 'Freehand · no digital', 'maciej-malecki' ); ?></dd></div>
				<div class="sheet__row"><dt><?php esc_html_e( 'Palette', 'maciej-malecki' ); ?></dt><dd><?php esc_html_e( 'Achromatic — black / white', 'maciej-malecki' ); ?></dd></div>
				<div class="sheet__row"><dt><?php esc_html_e( 'Archive', 'maciej-malecki' ); ?></dt><dd><?php esc_html_e( '007 plates indexed', 'maciej-malecki' ); ?></dd></div>
			</dl>
		</aside>
	</div>
</section>
