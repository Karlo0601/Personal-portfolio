<?php get_header(); ?>

<!-- start:content -->
<div id="content">

	<!-- start:main -->
	<main id="main" class="main clearfix">

		<div class="layout-narrow">
			<div class="wrapper">
				<div class="container">

					<h2 class="content-search--title">You searched for: <?php echo get_search_query(); ?></h2>

					<?php
					if ( have_posts() ) {  // results found
						$context = array();
						while ( have_posts() ) : the_post();

							$data['title']        = $post->post_title;
							$data['excerpt']      = $post->post_excerpt;
							$data['url']          = get_permalink();
							$context['results'][] = $data;
						endwhile;

						Timber::render( 'content-inside-search-results.twig', $context );

					} else {  // no results

					?>
						<h2>There are no results.</h2>
					<?php

					}

					?>

				</div>
			</div>

		</div>

	</main>
	<!-- end:main -->

</div>
<!-- end:content -->

<?php get_footer(); ?> 