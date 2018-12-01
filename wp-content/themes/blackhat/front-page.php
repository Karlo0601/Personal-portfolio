<?php
/* Template Name: Frontpage */

get_header(''); 

?>

<!-- start:content -->
<div id="content">

    <!-- start:main -->
    <main id="main" class="main clearfix">
        <?php the_content(); 
            //echo global_labels();
        ?>
    </main>
    
    <!-- end:main -->
</div>

<?php get_footer(); ?>