<?php
/**
 * Generic fallback (blog / search / fallback archive).
 *
 * @package maciej-malecki
 */
get_header();
?>
<main id="main" class="section wrap" style="padding-top:clamp(7rem,14vw,10rem)">
	<div class="sec-head" data-reveal>
		<p class="eyebrow"><span class="tick">+</span> <?php echo esc_html( get_the_archive_title() ? wp_strip_all_tags( get_the_archive_title() ) : __( 'Archive', 'maciej-malecki' ) ); ?></p>
		<p class="mono sec-head__id"><?php esc_html_e( 'RECORD', 'maciej-malecki' ); ?></p>
	</div>

	<?php if ( have_posts() ) : ?>
		<div class="post-list body" style="margin-top:3rem;max-width:70ch">
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="post-row" data-reveal style="padding:1.4rem 0;border-bottom:1px solid var(--hair)">
					<h2 class="display" style="font-size:clamp(1.2rem,3vw,1.8rem)"><a href="<?php the_permalink(); ?>" style="color:var(--fg)"><?php the_title(); ?></a></h2>
					<div style="margin-top:.6rem"><?php the_excerpt(); ?></div>
				</article>
			<?php endwhile; ?>
		</div>
		<div style="margin-top:2.5rem"><?php the_posts_pagination(); ?></div>
	<?php else : ?>
		<p class="body" style="margin-top:2rem"><?php esc_html_e( 'Nothing indexed here yet.', 'maciej-malecki' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();
