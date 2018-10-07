<?php
function scratch_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'bootstrap.min', '//stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' );
    
}
add_action('wp_enqueue_scripts', 'scratch_scripts');

add_theme_support( 'post-thumbnails' ); 

function register_sidebar_locations() {
    /* Register the 'primary' sidebar. */
    register_sidebar(
        array(
            'id'            => 'sidebar-primary',
            'name'          => __( 'Primary Sidebar' ),
            'description'   => __( 'Main sidebar displaying the usual post info' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
    /* Repeat register_sidebar() code for additional sidebars. */

}
add_action( 'widgets_init', 'register_sidebar_locations' );

function cpt_recipes()
{
    register_post_type('recipe',
                       array(
                           'labels'      => array(
                               'name'          => __('Recipes'),
                               'singular_name' => __('Recipe'),
                           ),
                           'public'      => true,
                           'has_archive' => true,
                           'publicly_queryable' => true,
                           'taxonomies' => array(
                                'Allergens',
                                'Difficulties',
                                'Categories'
                           ),
                           'supports' => array( 'title', 'excerpt', 'editor', 'thumbnail', 'revisions', 'custom-fields' )
                       )
    );
}
add_action('init', 'cpt_recipes');

function cpt_events()
{
    register_post_type('event',
                       array(
                           'labels'      => array(
                               'name'          => __('Events'),
                               'singular_name' => __('Event'),
            
                           ),
                           'public'      => true,
                           'has_archive' => true,
                           'publicly_queryable' => true,
                           'taxonomies' => array(
                               'Provinces',
                               'Tags',
                               'Settings'
                           ),
                           'supports' => array( 'title', 'excerpt', 'editor', 'thumbnail', 'revisions', 'custom-fields' )
                       )
    );
}
add_action('init', 'cpt_events');

// Register Custom Taxonomies
function tx_allergen() {

	$labels = array(
		'name'                       => _x( 'Allergens', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Allergen', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Allergen', 'text_domain' )
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true
	);
	register_taxonomy( 'tx_allergen', array( 'recipe' ), $args );

}
add_action( 'init', 'tx_allergen', 0 );

function tx_difficulty() {

	$labels = array(
		'name'                       => _x( 'Difficulties', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Difficulty', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'Difficulty', 'text_domain' ),
        'meta_box_cb'                => 'difficulty_meta_box',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true
	);
	register_taxonomy( 'difficulty', array( 'recipe' ), $args );

}
add_action( 'init', 'tx_difficulty', 0 );
/**
 * Display Difficulty meta box
 */
function difficulty_meta_box( $post ) {
	$terms = get_terms( 'difficulty', array( 'hide_empty' => false ) );
	$post  = get_post();
	$difficulty = wp_get_object_terms( $post->ID, 'difficulty', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
	$name  = '';
    if ( ! is_wp_error( $difficulty ) ) {
    	if ( isset( $difficulty[0] ) && isset( $difficulty[0]->name ) ) {
			$name = $difficulty[0]->name;
	    }
    }
	foreach ( $terms as $term ) {
		echo '<label title="' . esc_attr_e( $term->name ) . '>';
		    echo '<input type="radio" name="difficulty" value="' . esc_attr_e( $term->name ) . '"' . checked( $term->name, $name ) . '';
			echo '<span>' . esc_html_e( $term->name ) . '></span>';
		echo '</label><br>';
    }
}

/**
 * Save the recipe meta box results.
 *
 * @param int $post_id The ID of the post that's being saved.
 */
function save_difficulty_meta_box( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! isset( $_POST['difficulty'] ) ) {
		return;
	}
	$difficulty = sanitize_text_field( $_POST['difficulty'] );
	
	// A valid difficulty is required, so don't let this get published without one
	if ( empty( $difficulty ) ) {
		// unhook this function so it doesn't loop infinitely
		remove_action( 'save_post_recipe', 'save_difficulty_meta_box' );
		$postdata = array(
			'ID'          => $post_id,
			'post_status' => 'draft',
		);
		wp_update_post( $postdata );
	} else {
		$term = get_term_by( 'name', $difficulty, 'difficulty' );
		if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
			wp_set_object_terms( $post_id, $term->term_id, 'difficulty', false );
		}
	}
}
add_action( 'save_post_recipe', 'save_difficulty_meta_box' );

/**
 * Display an error message at the top of the post edit screen explaining that difficultys is required.
 *
 * Doing this prevents users from getting confused when their new posts aren't published, as we
 * require a valid difficulty custom taxonomy.
 *
 * @param WP_Post The current post object.
 */
function show_required_field_error_msg( $post ) {
	if ( 'recipe' === get_post_type( $post ) && 'auto-draft' !== get_post_status( $post ) ) {
	    $difficulty = wp_get_object_terms( $post->ID, 'difficulty', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
        if ( is_wp_error( $difficulty ) || empty( $difficulty ) ) {
			printf(
				'<div class="error below-h2"><p>%s</p></div>',
				esc_html__( 'Difficulty is mandatory for creating a new recipe post' )
			);
		}
	}
}
// Unfortunately, 'admin_notices' puts this too high on the edit screen
add_action( 'edit_form_top', 'show_required_field_error_msg' );


function tx_category() {

	$labels = array(
		'name'                       => _x( 'Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Category', 'text_domain' )
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true
	);
	register_taxonomy( 'tx_category', array( 'recipe' ), $args );

}
add_action( 'init', 'tx_category', 0 );

function tx_province() {

	$labels = array(
		'name'                       => _x( 'Provinces', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Province', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Province', 'text_domain' )
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true
	);
	register_taxonomy( 'tx_province', array( 'event' ), $args );

}
add_action( 'init', 'tx_province', 0 );

function tx_tag() {

	$labels = array(
		'name'                       => _x( 'Tags', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Tag', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Tag', 'text_domain' )
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true
	);
	register_taxonomy( 'tx_tag', array( 'event' ), $args );

}
add_action( 'init', 'tx_tag', 0 );

function tx_setting() {

	$labels = array(
		'name'                       => _x( 'Settings', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Setting', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Setting', 'text_domain' )
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true
	);
	register_taxonomy( 'tx_setting', array( 'event' ), $args );

}
add_action( 'init', 'tx_setting', 0 );



function add_recipe_box() {

    $screens = array('recipe');

    foreach($screens as $screen) {
        add_meta_box(
            'recipe_box',
            __('Recipe custom fields', 'scratch'),
            'scratch_recipe_box_callback',
            $screen
        );
    }

}

function scratch_recipe_box_callback($post) {
    //Add a nonce field
    wp_nonce_field('recipe_save_meta_box_data', 'recipe_meta_box_nonce');

    //Subtitle uit de post meta data halen
    $subtitle = get_post_meta($post->ID, '_recipe_subtitle', true);

    //Label en input printen
    echo '<label for="recipe_subtitle">' . __('Subtitle', 'scratch') . '</label>';
    echo '<input style="width:100%; margin: 0;" type="text" id="recipe_subtitle" name="recipe_subtitle" size="255" value="' . $subtitle . '">';

    //Subtitle uit de post meta data halen
    $ingredients = get_post_meta($post->ID, '_recipe_ingredients', true);

    //Label en input printen
    echo '<label for="recipe_ingredients">' . __('Ingredients', 'scratch') . '</label>';
    echo '<input style="width:100%; margin: 0;" type="text" id="recipe_ingredients" name="recipe_ingredients" size="255" value="' . $ingredients . '">';

}

add_action('add_meta_boxes', 'add_recipe_box');


function save_recipe_data($postid) {

    if(!isset($_POST['recipe_meta_box_nonce'])){return;}
    if(!wp_verify_nonce($_POST['recipe_meta_box_nonce'],'recipe_save_meta_box_data')){return;}
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){return;}
    if(!current_user_can('edit_post', $postid)){return;}
    if(isset($_POST['recipe_subtitle'])){
        $subtitle = sanitize_text_field($_POST['recipe_subtitle']);
        update_post_meta($postid, '_recipe_subtitle', $subtitle);
        
    }
    if(isset($_POST['recipe_ingredients'])){
        $ingredients = sanitize_text_field($_POST['recipe_ingredients']);
        update_post_meta($postid, '_recipe_ingredients', $ingredients);
        
    }
    

}

add_action('save_post', 'save_recipe_data');

remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
?>