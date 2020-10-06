<?php

if ( ! defined( 'ABSPATH')) {
    exit;
}

/**
 * Enqueue scripts and styles.
 */

add_action( 'wp_enqueue_scripts', 'start_wc_template_style' );
function start_wc_template_style() {
    wp_enqueue_style( 'main-style', get_template_directory_uri() . '/assets/css/app.min.css', array(),null, 'all' );
}

add_action( 'wp_enqueue_scripts', 'start_wc_template_scripts' );
function start_wc_template_scripts() {
    wp_enqueue_script( 'app-libs-js', get_template_directory_uri() . '/assets/js/app.libs.min.js', array(), null, true );
    wp_enqueue_script( 'app-js', get_template_directory_uri() . '/assets/js/app.min.js', array(), null, true );
}
