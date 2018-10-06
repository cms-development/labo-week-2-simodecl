<?php
add_action('wp_enqueue_scripts', 'content_theme_css', 999);
function content_theme_css() {
    wp_enqueue_style('content-parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
	wp_enqueue_style('media-responsive-css', get_stylesheet_directory_uri()."/css/media-responsive.css" );
    wp_enqueue_script('content-mp-masonry-js', get_stylesheet_directory_uri() . '/js/masonry/mp.mansory.js');
}

if ( ! function_exists( 'content_theme_setup' ) ) :

function content_theme_setup() {

//Load text domain for translation-ready
load_theme_textdomain('content', get_stylesheet_directory() . '/languages');

require( get_stylesheet_directory() . '/functions/content-info/welcome-screen.php' );

require( get_stylesheet_directory() . '/functions/customizer/customizer_general_settings.php' );

}
endif; 
add_action( 'after_setup_theme', 'content_theme_setup' );

/**
 * Import options from SpicePress
 *
 */
function content_get_lite_options() {
	$spicepress_mods = get_option( 'theme_mods_spicepress' );
	if ( ! empty( $spicepress_mods ) ) {
		foreach ( $spicepress_mods as $spicepress_mod_k => $spicepress_mod_v ) {
			set_theme_mod( $spicepress_mod_k, $spicepress_mod_v );
		}
	}
}
add_action( 'after_switch_theme', 'content_get_lite_options' );

add_action( 'admin_init', 'content_detect_button' );
	function content_detect_button() {
	wp_enqueue_style('content-info-button', get_stylesheet_directory_uri().'/css/import-button.css');
}

// footer custom script
function content_footer_custom_script() {
	
if ( is_active_sidebar('sidebar_primary') ) {
$col =6;
}
else
{
$col =4;
}
?>
    <script>
        jQuery(document).ready(function (jQuery) {
            jQuery("#blog-masonry").mpmansory(
                    {
                        childrenClass: 'item', // default is a div
                        columnClasses: 'padding', //add classes to items
                        breakpoints: {
                            lg: <?php echo $col;?>, //Change masonry column here like 2, 3, 4 column
                            md: 6,
                            sm: 6,
                            xs: 12
                        },
                        distributeBy: {order: false, height: false, attr: 'data-order', attrOrder: 'asc'}, //default distribute by order, options => order: true/false, height: true/false, attr => 'data-order', attrOrder=> 'asc'/'desc'
                        onload: function (items) {
                            //make somthing with items
                        }
                    }
            );
        });
    </script>
    <?php

}
add_action('wp_footer', 'content_footer_custom_script');
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
?>