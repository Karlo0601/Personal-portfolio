			<!-- start:footer -->
			<a href="javascrip:void(0)" class="scroll-to-top"><svg class="svg-arrow--up-dims"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#arrow--up"></use></svg></a>
			<footer id="footer" class="footer footer--site">
				<div class="wrapper">
					<div class="container clearfix">
						<?php 
							$site_logo = get_field( 'footer_logo', 'options' ); 
						?>
						<div class="footer__logo-container col-13">
							<img src="<?php echo $site_logo['url']; ?>" alt="" class="footer__logo">
						</div>
						
						<div class="copyright col-23 col-last">
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
			$map_key = get_field( 'google_maps_api_key', 'options' );
		?>
		<script>
			$( document ).ready( function() {
				//if($(window).width() > '769'){
					blackhat.main.loadScript( 'waypoints', blackhat.templateDirectory + '/resources/js/waypoints.min.js', function() {
						return blackhat.main.appearAnimations();
					});
				//}
			});
		</script>

	</body>
</html>