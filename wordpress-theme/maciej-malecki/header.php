<?php
/**
 * Header — opens the document, prints the HUD frame and primary nav.
 *
 * @package maciej-malecki
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip" href="#main"><?php esc_html_e( 'Skip to content', 'maciej-malecki' ); ?></a>

<!-- ============================ HUD FRAME ============================ -->
<div class="hud hud--draw" aria-hidden="true">
	<span class="hud__corner tl"></span><span class="hud__corner tr"></span>
	<span class="hud__corner bl"></span><span class="hud__corner br"></span>
	<div class="hud__bar hud__bar--top">
		<span class="hud__brand"><b>MŁ</b> // <?php esc_html_e( 'DRAWING ARCHIVE', 'maciej-malecki' ); ?></span>
		<span class="mid hide-sm"><?php echo esc_html( mm_opt( 'mm_hud_coords', 'N 52.41° E 16.93° · PL' ) ); ?></span>
		<span data-clock>00:00:00 UTC</span>
	</div>
	<div class="hud__bar hud__bar--bot">
		<span><?php esc_html_e( '007 PLATES INDEXED', 'maciej-malecki' ); ?></span>
		<span class="mid hide-sm"><?php esc_html_e( 'INK · PAPER · HAND', 'maciej-malecki' ); ?></span>
		<span>© <?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
	</div>
</div>

<!-- ============================== NAV =============================== -->
<header class="nav">
	<nav class="nav__inner" aria-label="<?php esc_attr_e( 'Primary', 'maciej-malecki' ); ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hud__brand" style="font-family:var(--mono);text-transform:uppercase;letter-spacing:.18em;font-size:.72rem;color:var(--fg)">
			<?php echo esc_html( get_bloginfo( 'name' ) ); ?><span style="color:var(--red)">.</span>
		</a>
		<div class="nav__links">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'items_wrap'     => '%3$s',
						'depth'          => 1,
						'fallback_cb'    => 'mm_default_nav',
					)
				);
			} else {
				mm_default_nav();
			}
			?>
		</div>
		<button class="nav__burger mono" aria-label="<?php esc_attr_e( 'Toggle menu', 'maciej-malecki' ); ?>" aria-expanded="false">MENU</button>
	</nav>
</header>
<?php
/**
 * Default nav used on the one-page layout when no menu is assigned.
 */
function mm_default_nav() {
	$home = home_url( '/' );
	?>
	<a href="<?php echo esc_url( $home . '#works' ); ?>"><?php esc_html_e( 'Plates', 'maciej-malecki' ); ?></a>
	<a href="<?php echo esc_url( $home . '#density' ); ?>"><?php esc_html_e( 'Process', 'maciej-malecki' ); ?></a>
	<a href="<?php echo esc_url( $home . '#exhibitions' ); ?>"><?php esc_html_e( 'Exhibitions', 'maciej-malecki' ); ?></a>
	<a href="<?php echo esc_url( $home . '#contact' ); ?>" class="nav__cta"><?php esc_html_e( 'Inquire', 'maciej-malecki' ); ?> <span class="arw">↗</span></a>
	<?php
}
