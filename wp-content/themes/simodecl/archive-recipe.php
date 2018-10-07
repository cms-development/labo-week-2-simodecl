<?php
get_header(); ?>

<main>
    <h2>Recepten</h2>

    <?php
        $args = array(
            'post_type'      => 'recipe',
            'posts_per_page' => - 1,
        );
        $q    = new WP_Query( $args );
    ?>

    <div class="row">
        <?php while ( $q->have_posts() ) : $q->the_post(); ?>
            <div class="col-4">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('thumbnail'); ?>
                </a>
                <h3>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h3>
                <?php the_excerpt(); ?>
            </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    </div>

</main>
<?php get_sidebar(); ?>

<?php get_footer();