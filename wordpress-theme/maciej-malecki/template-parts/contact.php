<?php
/**
 * Contact / inquire — email, datasheet, and form.
 *
 * If a form shortcode is set in the Customizer (Contact Form 7 / WPForms),
 * it is rendered. Otherwise the built-in mailto form is shown.
 *
 * @package maciej-malecki
 */
$mail      = mm_opt( 'mm_email', 'studio@maciejmalecki.art' );
$shortcode = trim( (string) mm_opt( 'mm_contact_form', '' ) );
?>
<section class="section contact wrap" id="contact" aria-label="<?php esc_attr_e( 'Inquire', 'maciej-malecki' ); ?>">
	<div class="sec-head" data-reveal>
		<p class="eyebrow"><span class="tick">+</span> <?php esc_html_e( '04 — Inquire', 'maciej-malecki' ); ?></p>
		<p class="mono sec-head__id"><?php esc_html_e( 'ORIGINALS · PRINTS · COMMISSIONS', 'maciej-malecki' ); ?></p>
	</div>

	<h2 class="display h-xl contact__big" data-reveal style="margin-top:clamp(1.5rem,4vw,2.5rem)">
		<?php esc_html_e( 'Enter the archive', 'maciej-malecki' ); ?> <span class="arw">↗</span>
	</h2>

	<div class="contact__grid">
		<div data-reveal>
			<p class="body" style="margin-bottom:1.8rem"><?php echo esc_html( mm_opt( 'mm_contact_intro', 'For original drawings, archival prints, exhibition loans or commissions, write to the studio. Each plate is one of a kind.' ) ); ?></p>
			<a class="maillink" href="mailto:<?php echo esc_attr( $mail ); ?>"><?php echo esc_html( $mail ); ?> <span class="arw">↗</span></a>
			<dl class="sheet" style="margin-top:2.4rem">
				<div class="sheet__row"><dt><?php esc_html_e( 'Represented', 'maciej-malecki' ); ?></dt><dd><?php esc_html_e( 'Available — by inquiry', 'maciej-malecki' ); ?></dd></div>
				<div class="sheet__row"><dt><?php esc_html_e( 'Studio', 'maciej-malecki' ); ?></dt><dd><?php echo esc_html( mm_opt( 'mm_studio_loc', 'Poland' ) ); ?></dd></div>
				<div class="sheet__row"><dt><?php esc_html_e( 'Response', 'maciej-malecki' ); ?></dt><dd><?php echo esc_html( mm_opt( 'mm_response', 'Within 3 working days' ) ); ?></dd></div>
			</dl>
		</div>

		<div data-reveal style="transition-delay:.08s">
			<?php if ( $shortcode ) : ?>
				<div class="form form--plugin"><?php echo do_shortcode( $shortcode ); ?></div>
			<?php else : ?>
				<form class="form" action="mailto:<?php echo esc_attr( $mail ); ?>" method="post" enctype="text/plain" novalidate>
					<div class="field">
						<label for="f-name"><?php esc_html_e( 'Name', 'maciej-malecki' ); ?></label>
						<input id="f-name" name="name" type="text" autocomplete="name" required />
					</div>
					<div class="field">
						<label for="f-email"><?php esc_html_e( 'Email', 'maciej-malecki' ); ?></label>
						<input id="f-email" name="email" type="email" autocomplete="email" required />
					</div>
					<div class="field">
						<label for="f-msg"><?php esc_html_e( 'Message', 'maciej-malecki' ); ?></label>
						<textarea id="f-msg" name="message" required></textarea>
					</div>
					<button class="submit" type="submit"><?php esc_html_e( 'Send inquiry', 'maciej-malecki' ); ?> <span class="arw" style="color:var(--red)">→</span></button>
				</form>
			<?php endif; ?>
		</div>
	</div>
</section>
