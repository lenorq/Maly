<?php
/**
 * Ticker — scrolling index of plate numbers + titles (duplicated for loop).
 *
 * @package maciej-malecki
 */
$plates = mm_get_plates();
// Sort by catalog number for the index ticker.
usort(
	$plates,
	function ( $a, $b ) {
		return strcmp( $a['no'], $b['no'] );
	}
);
?>
<div class="ticker" aria-hidden="true">
	<div class="ticker__track">
		<?php for ( $i = 0; $i < 2; $i++ ) : // duplicate for seamless loop ?>
			<?php foreach ( $plates as $p ) : ?>
				<span><i>›</i> <?php echo esc_html( $p['no'] ); ?> <b><?php echo esc_html( mb_strtoupper( $p['title'] ) ); ?></b></span>
			<?php endforeach; ?>
		<?php endfor; ?>
	</div>
</div>
