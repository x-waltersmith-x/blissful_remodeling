<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

define("DIST_FOLDER_PATH", get_template_directory_uri() . "/dist/");
define("DIST_FOLDER", get_template_directory() . "/dist/");

require_once get_template_directory() . '/vendor/autoload.php';

function get_mobile_detect() {
    static $detect = null;
    if ($detect === null) {
        $detect = new \Detection\MobileDetect();
    }
    return $detect;
}

// INCLUDES FILES
add_action( 'after_setup_theme', function() {
    $inc_dir = get_template_directory() . '/inc'; 

    if ( is_dir( $inc_dir ) ) {
        foreach ( scandir( $inc_dir ) as $file ) {
            if ( pathinfo( $file, PATHINFO_EXTENSION ) === 'php' ) {
                include_once $inc_dir . '/' . $file;
            }
        }
    }
});

// STYLES AND SCRIPTS
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'style', get_stylesheet_uri(), array(), fileatime( get_stylesheet_directory() . '/style.css' )  );
});