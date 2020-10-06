<?php
/**
 * Eco-Price template functions.
 *
 * @package start-wc-template
 */

 
if ( ! function_exists( 'hook_header' ) ) {
    
    /**
     * Display Hooks Header
     */

    function hook_header() { 
        ?>
            #Header
            <!-- <svg><use xlink:href="<?php // echo get_template_directory_uri(); ?>/assets/files/sprite.svg#icon--arrow"/></svg> -->
        <?php
    }
}

if ( ! function_exists( 'hook_nav' ) ) {
    /**
     * Display Hooks Header Nav
     */
    function hook_nav() {
        ?>
        #Nav
        <nav id="nav" class="nav">
            <div class="container">
                <?php start_wc_template_header_menu(); ?>
            </div>
        </nav>
        <div class="nav__mob">
            <div class="nav__mob_menu">
                <?php start_wc_template_header_menu_mob(); ?>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'footer' ) ) {
    
    /**
     * Display Hooks Footer
     */

    function hook_footer() { 
        ?>
            #footer
        <?php
    }
}