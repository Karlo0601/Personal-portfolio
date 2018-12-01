<?php
/* Template Name: Landing Page */
    GLOBAL $post;
    $background_image = get_field('background-image', $post->ID);
    $logo = get_field('logo', $post->ID);
    $links = get_field('links', $post->ID);
    $title = get_field('frontpage_title', $post->ID);
?>
<?php get_template_part( 'partials/header', 'landing-page' ); ?>

<!-- start:content -->
<div id="content-landing"  style="background-image: url('<?php echo $background_image['url']; ?>');">

    <!-- start:main 	-->
    <main id="main" class="main main--landing clearfix">

        <div class="wrapper">
            <div class="container">
                <?php while ( have_posts() ) : the_post(); ?>
                <figure class="main--landing__content fadeIn fadeIn--top">
                    <img src="<?php echo $logo['url']; ?>" width="" height="" alt="">
                    <figcaption>
                        <h3 class="main--landing__title"><?php echo $title; ?></h3>
                    </figcaption>
                    <?php
                        
                        foreach ($links as $link) {
                            $button_label = $link['button_label'];
                            $button_link = $link['button_link'];?>

                            <a href="<?php echo $button_link; ?>" class="button button--transparent-large"><?php echo $button_label; ?></a>
                        <?php }
                    ?>
                </figure>
                    
                    

                <?php endwhile; ?>
            </div>
        </div>

    </main>
    <!-- end:main -->

</div>
<!-- end:content -->

<?php get_template_part( 'partials/footer', 'landing-page' ); ?>