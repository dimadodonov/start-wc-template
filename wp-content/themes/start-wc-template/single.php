<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package start-wc-template
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<?php
				if ( function_exists('yoast_breadcrumb') ) {
				yoast_breadcrumb( '<div class="breadcrumbs">','</div>' );
				}

				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', get_post_type() );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

	
	<?php
	/**
	* Functions hooked in to Single Page action
	*
	* @hooked hook_related_post                       - 10
	*/
	do_action( 'hook_single' ); ?>

<?php
get_footer();
