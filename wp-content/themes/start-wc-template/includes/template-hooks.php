<?php

if ( ! defined( 'ABSPATH')) {
    exit;
}


/**
 * Header hooks
 *
 * @see  hook_header                                        10
 * @see  hook_nav                                           20
 */

add_action( 'hook_header', 'hook_header',                   10 );
add_action( 'hook_header', 'hook_nav',                      20 );


/**
 * Page Home hooks
 *
 * @see  hook_page_before                                   10
 * @see  hook_page_home_intro                               20
 * @see  hook_page_after                                    90
 */

// add_action( 'hook_page_home', 'hook_page_before',                  10 );
// add_action( 'hook_page_home', 'hook_page_after',                   90 );


/**
 * Footer hooks
 *
 * @see  hook_footer                                        10
 */

add_action( 'hook_footer', 'hook_footer',                10 );