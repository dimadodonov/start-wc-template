<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package start-wc-template
 */

get_header();

/**
* Functions hooked in to Home Page action
*
* @hooked hook_page_home_before                       - 10
* @hooked hook_page_home_after                        - 10
*/
do_action( 'hook_page_home' );

get_footer();