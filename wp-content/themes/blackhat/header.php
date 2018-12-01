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
			<header id="header" class="header header--site">

				<div class="wrapper">
					<div class="container">

						<?php 
							$site_logo = get_field( 'site_logo', 'options' );
							$logo_pos  = get_field('logo_position', 'options');
						?>
						<h1 class="logo <?php if($logo_pos == 'center'){ ?>logo--center <?php } ?>">
							<a href="<?php echo site_url(); ?>" class="logo__link">
								<?php if( !empty( $site_logo ) ) { ?>
									<img src="<?php echo $site_logo['url']; ?>" width="" height="" alt="<?php bloginfo(); ?>" />
								<?php } else { 
									bloginfo();
								} ?>
							</a>
						</h1>

						<!-- start:responsive buttons -->

						
						<div class="resp-buttons right">
							<div id="js-resp-menu-toggle" class="hamburger-menu">
								<div class="hamburger-menu__bar"></div>	
							</div>
						</div>
						<!-- start:responsive buttons -->

						<!-- start:main nav -->
						<div class="main-nav__container">
							<?php 
								wp_nav_menu( array(
									'container'       => 'nav',
									'container_id'    => 'main-nav',
									'container_class' => 'main-navigation',
									'menu_class'      => 'menu menu--main-menu clearfix',
									'theme_location'  => 'main_menu',
									'fallback_cb'	  => 'blackhat_fallback_menu' 
									) 
								);
							?>
							<div class="header__socials">
								<?php echo blackhat_social_links(); ?>
							</div>

						</div>
						
						<!-- end:main nav -->

					</div>
				</div>
			</header>
			<!-- end:header -->
		