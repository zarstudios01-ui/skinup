<?php
add_action( 'after_setup_theme', function () {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'woocommerce' );
    register_nav_menus( array( 'primary' => 'Primary menu' ) );
} );

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'skinup', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
} );
