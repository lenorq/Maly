<?php
/**
 * Front page — the one-page Drawing Archive.
 *
 * @package maciej-malecki
 */
get_header();
?>
<main id="main">
	<span id="top"></span>

	<?php
	get_template_part( 'template-parts/hero' );
	get_template_part( 'template-parts/ticker' );
	get_template_part( 'template-parts/statement' );
	?>
	<hr class="rule rule--bleed" />
	<?php
	get_template_part( 'template-parts/plates' );
	get_template_part( 'template-parts/density' );
	get_template_part( 'template-parts/exhibitions' );
	?>
	<hr class="rule rule--bleed" />
	<?php
	get_template_part( 'template-parts/contact' );
	?>
</main>
<?php
get_footer();
