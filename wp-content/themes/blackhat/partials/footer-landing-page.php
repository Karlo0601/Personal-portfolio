<?php 
	// Exit if accessed directly - small security
	if ( ! defined( 'ABSPATH' ) ) exit; 
?>
			<!-- start:footer -->
			<footer id="footer">
				<div class="wrapper">
					<div class="container clearfix">

						<?php //echo am2_social_links(); ?>

						<div class="copyright">
							<?php echo get_field( 'copyright', 'options' ); ?>
						</div>

					</div>
				</div>
			</footer>
			<!-- end:footer -->
		</div>
		<!-- end:wrapper -->

		<?php wp_footer(); ?>

		<?php
			$tracking_codes_footer = get_field( 'tracking_codes_footer', 'options' );
			if ( ! empty( $tracking_codes_footer ) ) {
				echo $tracking_codes_footer;
			}
		?>

	</body>
</html>