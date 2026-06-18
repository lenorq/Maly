<?php
/**
 * Page template.
 *
 * @package maciej-malecki
 */
get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main id="main" class="section wrap" style="padding-top:clamp(7rem,14vw,10rem)">
		<div class="sec-head" data-reveal>
			<p class="eyebrow"><span class="tick">+</span> <?php the_title(); ?></p>
		</div>
		<div class="body" data-reveal style="max-width:70ch;margin-top:2.5rem">
			<?php the_content(); ?>
		</div>
	</main>
	<?php
endwhile;

get_footer();
