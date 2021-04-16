<?php 

//TAR BORT GUTENBERG BLOCK EDITOR FRÅN ALLA PAGES

function my_disable_gutenberg_for_post_type( $is_enabled, $post_type ) {
    if ( 'page' == $post_type ) {  
        return false;
    }

    return $is_enabled;
}
if ( version_compare($GLOBALS['wp_version'], '5.0-beta', '>') ) {
    // WP > 5 beta
    add_filter( 'use_block_editor_for_post_type', 'my_disable_gutenberg_for_post_type', 10, 2 );
} else {
    // WP < 5 beta
    add_filter( 'gutenberg_can_edit_post_type', 'my_disable_gutenberg_for_post_type', 10, 2 );

}

//TAR BORT GUTENBERG BLOCK EDITOR FRÅN ALLA FAQ

function my_disable_gutenberg_for_faq( $is_enabled, $post_type ) {
    if ( 'faq' == $post_type ) {  
        return false;
    }

    return $is_enabled;
}
if ( version_compare($GLOBALS['wp_version'], '5.0-beta', '>') ) {
    // WP > 5 beta
    add_filter( 'use_block_editor_for_post_type', 'my_disable_gutenberg_for_faq', 10, 2 );
} else {
    // WP < 5 beta
    add_filter( 'gutenberg_can_edit_post_type', 'my_disable_gutenberg_for_faq', 10, 2 );
}

//TAR BORT GUTENBERG BLOCK EDITOR FRÅN ALLA PORTFOLIO

function my_disable_gutenberg_for_portfolio( $is_enabled, $post_type ) {
    if ( 'portfolio' == $post_type ) {  
        return false;
    }

    return $is_enabled;
}
if ( version_compare($GLOBALS['wp_version'], '5.0-beta', '>') ) {
    // WP > 5 beta
    add_filter( 'use_block_editor_for_post_type', 'my_disable_gutenberg_for_portfolio', 10, 2 );
} else {
    // WP < 5 beta
    add_filter( 'gutenberg_can_edit_post_type', 'my_disable_gutenberg_for_portfolio', 10, 2 );
}

//TAR BORT GUTENBERG BLOCK EDITOR FRÅN ALLA PRODUCTS

function my_disable_gutenberg_for_products( $is_enabled, $post_type ) {
    if ( 'products' == $post_type ) {  
        return false;
    }

    return $is_enabled;
}
if ( version_compare($GLOBALS['wp_version'], '5.0-beta', '>') ) {
    // WP > 5 beta
    add_filter( 'use_block_editor_for_post_type', 'my_disable_gutenberg_for_products', 10, 2 );
} else {
    // WP < 5 beta
    add_filter( 'gutenberg_can_edit_post_type', 'my_disable_gutenberg_for_products', 10, 2 );
}