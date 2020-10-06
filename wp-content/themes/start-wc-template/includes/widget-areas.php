<?php

if ( ! defined( 'ABSPATH')) {
    exit;
}


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function start_wc_template_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Сайтбар', 'start-wc-template' ),
        'id'            => 'sidebar_filters',
        'description'   => esc_html__( 'Add widgets here.', 'start-wc-template' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Сайтбар 2', 'start-wc-template' ),
        'id'            => 'sidebar_filters_2',
        'description'   => esc_html__( 'Add widgets here.', 'start-wc-template' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'start_wc_template_widgets_init' );