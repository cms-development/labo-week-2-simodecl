<?php get_header(); ?>

<?php 
if ( have_posts() ) :
    // Start the Loop.
    while ( have_posts() ) : the_post();
        // Include the post format-specific template for the content. get_post_format
        echo '<div class="title">';
        the_title();
        echo '</div>';

        echo '<div class="content">';
        the_content();
        echo '</div>';
    endwhile;
endif;
?>

<!-- Sidebar -->
<?php get_sidebar(); ?>

<!-- Footer -->
<?php get_footer(); ?>