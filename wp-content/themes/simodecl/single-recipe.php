<?php get_header(); ?>

<?php if( have_posts() ) : while( have_posts() ): the_post();?>

    <h1><?php the_title();?></h1>

    <!-- Image group 1 -->
    <?php if( have_rows('image_group_1') ): 
        while( have_rows('image_group_1') ): the_row(); 
            // vars
            $image = get_sub_field('image');
            ?>
            <div class="image_group">
                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                <?php if( get_sub_field('description') ): ?>
                    <div class="description">Description: <?php the_sub_field('description'); ?></div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>

    <?php endif; ?>

    <!-- Image group 2 -->
    <?php if( have_rows('image_group_2') ): 
        while( have_rows('image_group_2') ): the_row(); 
            // vars
            $image2 = get_sub_field('image');
            ?>
            <div class="image_group">
                <img src="<?php echo $image2['url']; ?>" alt="<?php echo $image2['alt']; ?>" />
                <?php if( get_sub_field('description') ): ?>
                    <div class="description">Description 2: <?php the_sub_field('description'); ?></div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>

    <?php endif; ?>

    <!-- Intro text field -->
    <?php if( get_field('intro_text') ): ?>
        <h2><?php the_field('intro_text'); ?></h2>
    <?php endif; ?>

    <!-- Custom fields without plugin -->
    <h3>Size: <?php echo get_post_meta(get_the_ID(), '_recipe_subtitle', TRUE); ?></h3>
    <h3>Ingredients: <?php echo get_post_meta(get_the_ID(), '_recipe_ingredients', TRUE); ?></h3>

    <?php //List of allergens
    $terms = get_the_terms( $post->ID, 'tx_allergen' );
    if ( $terms && ! is_wp_error( $terms ) ) :

        $allergens = array();
        foreach ( $terms as $term ) {
            $allergens[] = $term->name;
        }

        $allergens = implode(", ", $allergens );
        ?>

        <p class=taxonomies">
            Allergens: <span><?php echo $allergens; ?> </span>
        </p>

    <?php endif; ?>

    <?php //List of difficulties
    $terms2 = get_the_terms( $post->ID, 'difficulty' );
    if ( $terms && ! is_wp_error( $terms2 ) ) :

        $difficulties = array();
        foreach ( $terms2 as $term2 ) {
            $difficulties[] = $term2->name;
        }

        $difficulties = implode(", ", $difficulties );
        ?>

        <p class=taxonomies">
            Difficulty: <span><?php echo $difficulties; ?> </span>
        </p>

    <?php endif; ?>

    <?php //List of categories
    $terms3 = get_the_terms( $post->ID, 'tx_category' );
    if ( $terms3 && ! is_wp_error( $terms3 ) ) :

        $categories = array();
        foreach ( $terms3 as $term3 ) {
            $categories[] = $term3->name;
        }

        $categories = implode(", ", $categories );
        ?>

        <p class=taxonomies">
            Categories: <span><?php echo $categories; ?> </span>
        </p>

    <?php endif; ?>

    <?php the_content()?>
    
<?php endwhile; ?>

<?php else: ?>

<?php endif; ?>
<?php get_sidebar();?>
<?php get_footer(); ?>
