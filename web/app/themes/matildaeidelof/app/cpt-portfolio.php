<?php

//skapar portfolio i admin
function create_portfolio() {
 
    register_post_type( 'portfolio',
    // CPT Options
        array(
            'labels' => array(
                'name' => __('PORTFOLIO' ),
                'singular_name' => __( 'gallery' ),
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'portfolio'),
			'menu_icon' => 'dashicons-format-gallery',
            'show_in_rest' => true,
 
        )
    );
}

add_action( 'init', 'create_portfolio' );