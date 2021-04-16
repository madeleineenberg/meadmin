<?php
//skapar products i admin
function create_products() {
 
    register_post_type( 'products',
    // CPT Options
        array(
            'labels' => array(
                'name' => __('PRODUCTS' ),
                'singular_name' => __( 'product' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'products'),
			'menu_icon'   => 'dashicons-products',
            'show_in_rest' => true,
 
        )
    );
}

add_action( 'init', 'create_products' );