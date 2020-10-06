<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package start-wc-template
 */

get_header();
?>
    <div class="archive">
        <div class="container">

            <?php

            if ( function_exists('yoast_breadcrumb') ) {
                yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
            };

            the_archive_title( '<h1 class="page-title">', '</h1>' );
            the_archive_description( '<div class="archive-description">', '</div>' );
            ?>

            <div class="row">

                <?php if ( have_posts() ) : ?>

                    <?php
                    /* Start the Loop */
                    while ( have_posts() ) :
                        the_post();

                        /*
                         * Include the Post-Type-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                         */
                        get_template_part( 'template-parts/content-archive', get_post_type() );

                    endwhile;

                    ?>
                        <div class="col-md-12">
                            <?php if(function_exists('wp_corenavi')) wp_corenavi(); ?>
                        </div>
                    <?php

                else :

                    get_template_part( 'template-parts/content', 'none' );

                endif;
                ?>

            </div><!-- #row -->
        </div><!-- #container -->
    </div>

<?php
get_footer();
