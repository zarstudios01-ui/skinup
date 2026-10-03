<?php
add_action( 'after_setup_theme', function () {
style.css add_theme_support( 'title-tag' );
style.css add_theme_support( 'post-thumbnails' );
style.css add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
style.css add_theme_support( 'woocommerce' );
style.css register_nav_menus( array( 'primary' => 'Primary menu' ) );
} );

add_action( 'wp_enqueue_scripts', function () {
style.css wp_enqueue_style( 'skinup', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
} );
