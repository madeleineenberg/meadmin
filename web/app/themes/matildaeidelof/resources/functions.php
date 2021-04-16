<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__.'/../vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "../app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin', 'cpt-faq', 'cpt-portfolio', 'cpt-products', 'remove-gb', 'remove-comments']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require dirname(__DIR__).'/config/assets.php',
            'theme' => require dirname(__DIR__).'/config/theme.php',
            'view' => require dirname(__DIR__).'/config/view.php',
        ]);
    }, true);

//SKAPAR FOOTER-SETTINGS PAGE ------------------------------------>

add_filter('use_block_editor_for_post', 'disable_gutenberg_on_settings_page', 5, 2);

function disable_gutenberg_on_settings_page($can, $post){
    if($post){
        // Replace "site-settings" with the slug of your site settings page.
        if($post->post_name === "footer-settings"){
            return false;
        }
    }
    return $can;
}

function hide_settings_page($query) {
    if ( !is_admin() && !$query->is_main_query() ) {
        return;
    }    
    global $typenow;
    if ($typenow === "page") {
        // Replace "site-settings" with the slug of your site settings page.
        $settings_page = get_page_by_path("footer-settings",NULL,"page")->ID;
        $query->set( 'post__not_in', array($settings_page) );    
    }
    return;

}

add_action('pre_get_posts', 'hide_settings_page');

// Add the page to admin menu
function add_site_settings_to_menu(){
    add_menu_page( 'Footer Settings', 'Footer Settings', 'manage_options', 'post.php?post='.get_page_by_path("footer-settings",NULL,"page")->ID.'&action=edit', '', 'dashicons-admin-tools', 20);
}
add_action( 'admin_menu', 'add_site_settings_to_menu' );

// Change the active menu item

add_filter('parent_file', 'higlight_custom_settings_page');

function higlight_custom_settings_page($file) {
    global $parent_file;
    global $pagenow;
    global $typenow, $self;

    $settings_page = get_page_by_path("footer-settings",NULL,"page")->ID;

    $post = (isset($_GET['post'])) ? (int)$_GET['post'] : 0;
    if ($pagenow === "post.php" && $post === $settings_page) {
        $file = "post.php?post=$settings_page&action=edit";
    }
    return $file;
}

function edit_site_settings_title() {
    global $post, $title, $action, $current_screen;
    if( isset( $current_screen->post_type ) && $current_screen->post_type === 'page' && $action == 'edit' && $post->post_name === "footer-settings") {
        $title = $post->post_title.' - '.get_bloginfo('name');           
    }
    return $title;  
}

add_action( 'admin_title', 'edit_site_settings_title' );

function op($slug) { $page_url_id = get_page_by_path( $slug ); return $page_url_id->ID; } 
the_field('my_title', op('footer-settings')); 

// SLUT FOOTER SETTINGS PAGE ---------------->

