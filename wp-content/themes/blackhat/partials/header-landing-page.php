<?php 

	// Exit if accessed directly - small security
	if ( ! defined( 'ABSPATH' ) ) exit; 	
	
?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>
			<?php
				$blog_title = null;
				$seo_title  = null;
				$blog_title = get_bloginfo('name') . ' - ' . get_the_title();
				$seo_title  = get_post_meta( get_the_ID(), '_yoast_wpseo_title', true );
				if ( ! empty( $seo_title ) ) {
					if ( is_home() ) {
						echo $blog_title;
					} else {
						echo $seo_title;
					}
				} else {
					if ( is_archive() ) {
						wp_title( '' );
						echo ' - ';
					} elseif ( is_category() ) {
						wp_title( '' );
						echo ' - ';
					} elseif ( is_search() ) {
						echo 'Search term &quot;' . _wp_specialchars( $s ) . '&quot; - ';
					} elseif ( ! ( is_404() ) && ( is_single() ) || ( is_page() ) ) {
						if ( ! is_front_page() ) {
							wp_title( '' );
							echo ' - ';
						}
					} elseif ( is_404() ) {
						echo 'Not found - ';
					}
					if ( is_front_page() ) {
						bloginfo( 'name' );
					} elseif ( is_home() ) {
						echo( 'Offer - ' );
						bloginfo( 'name' );
					} else {
						bloginfo( 'name' );
					}
					if ( $paged > 1 ) {
						echo ' - Page ' . $paged;
					}
				}
			?>
		</title>

		<?php $favicon = get_field( 'favicon', 'options' ); ?>
		<?php if( ! empty( $favicon ) ) { ?>
			<link rel="icon" href="<?php echo $favicon['url']; ?>">
		<?php } ?>

		<?php wp_head(); ?>

		<script>
			var am2 = window.am2 || {};
			am2.main = {};
			am2.functionsQueue = [];
			am2.templateDirectory = '<?php echo get_template_directory_uri(); ?>';
		</script>

		<meta name="google-site-verification" content="rHK5lX60BaRwUiQEPaDmrOGVDS1dpNUZ8JmTXBozGLI" />

		<?php
			$tracking_codes_head = get_field( 'tracking_codes_head', 'options' );
			if ( ! empty( $tracking_codes_head ) ) {
				echo $tracking_codes_head;
			}
		?>

	</head>

	<body <?php body_class(); ?>>

		<?php
			$tracking_codes_body = get_field( 'tracking_codes_body', 'options' );
			if ( ! empty( $tracking_codes_body ) ) {
				echo $tracking_codes_body;
			}
		?>

		<!-- start:wrapper -->
		<div id="wrapper">

			<!-- start:header -->
			<header id="header" class="header header--landing">
				<div class="wrapper">
					<div class="container">

						<?php $site_logo = get_field( 'landing_page_logo', 'options' ); ?>
						<h1 class="logo">
							<a href="<?php echo site_url(); ?>" class="logo__link">
								<?php if( !empty( $site_logo ) ) { ?>
									<img src="<?php echo $site_logo['url']; ?>" width="" height="" alt="<?php bloginfo(); ?>" />
								<?php } else { 
									bloginfo();
								} ?>
							</a>
						</h1>

					</div>
				</div>
			</header>
			<!-- end:header -->
		