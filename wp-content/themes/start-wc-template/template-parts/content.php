<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package start-wc-template
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    if ( is_singular() ) :
        the_title( '<h1 class="entry-title">', '</h1>' );
    else :
        the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
    endif;
    ?>
    <div class="post-meta">
        <?php echo the_category(', '); ?>
        <div class="date"><?php echo the_time('d F Y');?></div>
    </div>

	<div class="entry-content">
		<?php
		the_content();
		?>
	</div><!-- .entry-content -->
    <div class="post-share">
        <span class="title">Поделиться в социальных сетях:</span>
        <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
        <script src="//yastatic.net/share2/share.js"></script>
        <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus,twitter"></div>
    </div>

    <div class="action_product catalog_list">
        <h2>Товары участвующие в акции:</h2>
    </div>

    <div class="block__home_slider ">
        <h2>Другие акции </h2>
        <a href="<?php echo home_url('/category/stock'); ?>" class="h2_link">Перейти в раздел акции</a>
        <div class="next_post">
            <div class="row">
                <?php
                $args = array(
                    'post_type' => 'post', // Выводим посты пренадлежащие текущей рубрике
                    'posts_per_page' => '3',
                );
                $query = new WP_Query( $args );
                if ($query->have_posts()) {
                    while ( $query->have_posts() ) : $query->the_post(); ?>
                        <div class="col-md-4">
                            <div class="next_post__item">
                                <?php if( current_user_can( 'edit_posts' ) ) {
                                    echo '<a href="' . get_edit_post_link() . '" class="btn_edit"><span></span></a>';
                                }; ?>
                                <a href="<?= the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <?php
                                    if ( has_post_thumbnail() ) :
                                        echo the_post_thumbnail('portfolio_archive', array('class' => 'img-responsive center-block'));
                                    else :
                                        echo '<img src="' . get_template_directory_uri() . '/assets/img/portfolio-archive-no-photo.png' . '" class="img-responsive" atl="Фото не загружено">' ;
                                    endif; ?>
                                    <div class="title"><?php the_title(); ?></div>
                                </a>
                            </div>
                        </div>
                    <?php endwhile;
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
</article><!-- #post-<?php the_ID(); ?> -->
