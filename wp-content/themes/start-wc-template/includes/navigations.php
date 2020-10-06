<?php

if ( ! defined( 'ABSPATH')) {
    exit;
}


register_nav_menus( array(
    'primary' => 'Основное',
    'primary' => 'Основное'
));


function start_wc_template_header_menu() {
    wp_nav_menu( array(
        'theme_location' => 'primary',
        'menu_id' => 'primary_menu',
    ));
}
register_nav_menus( array(
    'mob' => 'Моб',
    'mob' => 'Моб'
));


function start_wc_template_header_menu_mob() {
    wp_nav_menu( array(
        'theme_location' => 'mob',
        'menu_id' => 'mob_menu',
    ));
}