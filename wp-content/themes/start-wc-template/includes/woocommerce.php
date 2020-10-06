<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package start-wc-template
 */

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
// function start_wc_template_woocommerce_scripts() {
//     wp_enqueue_style( 'start_wc_template_woocommerce-style', get_template_directory_uri() . '/woocommerce.css' );

//     $font_path   = WC()->plugin_url() . '/assets/fonts/';
//     $inline_font = '@font-face {
// 			font-family: "star";
// 			src: url("' . $font_path . 'star.eot");
// 			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
// 				url("' . $font_path . 'star.woff") format("woff"),
// 				url("' . $font_path . 'star.ttf") format("truetype"),
// 				url("' . $font_path . 'star.svg#star") format("svg");
// 			font-weight: normal;
// 			font-style: normal;
// 		}';

//     wp_add_inline_style( 'start_wc_template_woocommerce-style', $inline_font );
// }
// add_action( 'wp_enqueue_scripts', 'start_wc_template_woocommerce_scripts' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function start_wc_template_woocommerce_active_body_class( $classes ) {
    $classes[] = 'woocommerce-active';

    return $classes;
}
add_filter( 'body_class', 'start_wc_template_woocommerce_active_body_class' );

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function start_wc_template_woocommerce_products_per_page() {
    return 99;
}
add_filter( 'loop_shop_per_page', 'start_wc_template_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function start_wc_template_woocommerce_thumbnail_columns() {
    return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'start_wc_template_woocommerce_thumbnail_columns' );

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function start_wc_template_woocommerce_loop_columns() {
    return 4;
}
add_filter( 'loop_shop_columns', 'start_wc_template_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function start_wc_template_woocommerce_related_products_args( $args ) {
    $defaults = array(
        'posts_per_page' => 4,
        'columns'        => 4,
    );

    $args = wp_parse_args( $defaults, $args );

    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'start_wc_template_woocommerce_related_products_args' );

if ( ! function_exists( 'start_wc_template_woocommerce_product_columns_wrapper' ) ) {
    /**
     * Product columns wrapper.
     *
     * @return  void
     */
    function start_wc_template_woocommerce_product_columns_wrapper() {
        $columns = start_wc_template_woocommerce_loop_columns();
    }
}
add_action( 'woocommerce_before_shop_loop', 'start_wc_template_woocommerce_product_columns_wrapper', 40 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'start_wc_template_woocommerce_wrapper_before' ) ) {
    /**
     * Before Content.
     *
     * Wraps all WooCommerce content in wrappers which match the theme markup.
     *
     * @return void
     */
    function start_wc_template_woocommerce_wrapper_before() {
        ?>
        <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        <?php
    }
}
add_action( 'woocommerce_before_main_content', 'start_wc_template_woocommerce_wrapper_before' );

if ( ! function_exists( 'start_wc_template_woocommerce_wrapper_after' ) ) {
    /**
     * After Content.
     *
     * Closes the wrapping divs.
     *
     * @return void
     */
    function start_wc_template_woocommerce_wrapper_after() {
        ?>
        </main><!-- #main -->
        </div><!-- #primary -->
        <?php
    }
}
add_action( 'woocommerce_after_main_content', 'start_wc_template_woocommerce_wrapper_after' );


if ( ! function_exists( 'start_wc_template_woocommerce_header_cart' ) ) {
    /**
     * Display Header Cart.
     *
     * @return void
     */
    function start_wc_template_woocommerce_header_cart() {
        if ( is_cart() ) {
            $class = 'current-menu-item';
        } else {
            $class = '';
        }
        ?>
        <ul id="site-header-cart" class="site-header-cart">
            <li class="<?php echo esc_attr( $class ); ?>">
                <?php start_wc_template_woocommerce_cart_link(); ?>
            </li>
            <li>
                <?php
                $instance = array(
                    'title' => '',
                );

                the_widget( 'WC_Widget_Cart', $instance );
                ?>
            </li>
        </ul>
        <?php
    }
}
