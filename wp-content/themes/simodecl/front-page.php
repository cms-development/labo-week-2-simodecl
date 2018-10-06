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
<?php get_sidebar('sidebar-primary'); ?>


<h2>2 recentste posts</h2>
<?php
$args = array(
        'posts_per_page' => 2,
        'order' => 'desc',
        'orderby' => 'date',

    );
$posts = new WP_Query($args);
if( $posts->have_posts() ): ?> 
    

    <?php while( $posts->have_posts() ) : $posts->the_post(); 
    echo '<h3 class="title">';
    the_title();
    echo '</h3>';

    echo '<div class="content">';
    the_content();
    echo '</div>';

endwhile; endif; ?>
</div>       

<h2>Weetjes</h2>
<?php
$args2 = array(
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby' => 'date',
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => 'weetjes',
                'include_children' => false
            ) ,
            )
);
$posts2 = new WP_Query($args2);
if( $posts2->have_posts() ): ?> 
    

    <?php while( $posts2->have_posts() ) : $posts2->the_post(); 
    echo '<h3 class="title">';
    the_title();
    echo '</h3>';

    echo '<div class="content">';
    the_content();
    echo '</div>';

endwhile; endif; ?>
</div>                    

<!-- Footer -->
<?php get_footer(); ?>