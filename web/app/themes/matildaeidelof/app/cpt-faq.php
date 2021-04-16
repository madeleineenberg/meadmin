<?php

function create_posttype() {
 
 register_post_type( 'faq',
     array(
         'labels' => array(
             'name' => __( 'FAQ' ),
             'singular_name' => __( 'faq' )
         ),
         'public' => true,
         'has_archive' => true,
         'rewrite' => array('slug' => 'faq'),
         'show_in_rest' => true,

     )
 );
}

add_action( 'init', 'create_posttype' );