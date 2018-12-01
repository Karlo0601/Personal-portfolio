<?php get_header(); ?>

<!-- start:content -->
<div id="content" class="clearfix">

	<!-- start:main -->
	<main id="main" class="main col-23 clearfix">

		<div class="wrapper">
            <div class="content">
				<?php the_title(); ?>
                <?php the_content(); ?>

            </div>
        </div>

	</main>
	<!-- end:main -->
	<!-- <div class="col-md-3 col-13 hidden-sm hidden-xs">
        <aside class="sidebar">
            <?php echo get_secondary_nav(); ?>
        </aside><!-- sidebar -->
    </div> -->
</div>
<!-- end:content -->

<?php get_footer(); ?> 