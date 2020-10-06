<?php

require get_template_directory() . '/includes/theme-settings.php';
require get_template_directory() . '/includes/widget-areas.php';
require get_template_directory() . '/includes/enqueue_script_style.php';
require get_template_directory() . '/includes/post-type.php';

/**
 * Подключаем файл с подключением хуков
 */
require get_template_directory() . '/includes/template-hooks.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/includes/template-functions.php';

/**
 * Navigations .
 */
require get_template_directory() . '/includes/navigations.php';

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
    require get_template_directory() . '/includes/woocommerce.php';
    require get_template_directory() . '/includes/woocommerce-fields.php';
    require get_template_directory() . '/woocommerce/includes/wc-functions.php';
    require get_template_directory() . '/woocommerce/includes/wc-functions-cart.php';
    require get_template_directory() . '/woocommerce/includes/wc-functions-archive.php';
    require get_template_directory() . '/woocommerce/includes/wc-functions-product.php';
    require get_template_directory() . '/woocommerce/includes/wc-function_checkount.php';
    require get_template_directory() . '/woocommerce/includes/wc-function-product-cart.php';
    require get_template_directory() . '/woocommerce/includes/wc-functions-breadcrumb.php';
    require get_template_directory() . '/woocommerce/includes/wc-functions-my-account.php';
    require get_template_directory() . '/woocommerce/includes/wc-functions-remove.php';
    // require get_template_directory() . '/woocommerce/includes/wc-template-function.php';
}