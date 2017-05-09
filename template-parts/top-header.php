<?php
/**
 * Template part for displaying top header part
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newspaper X
 */

?>
<div class="top-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php $news_ticker = get_theme_mod( 'newspaper_x_enable_news_ticker', true ); ?>
                <?php if ( $news_ticker ) { ?>
                    <section class="newspaper-x-news-ticker">
                        <?php
                        get_template_part( 'template-parts/news-ticker' );
                        ?>
                    </section>
                <?php } ?>
            </div>
            <div class="col-lg-4">
                <?php
                $enable_search = get_theme_mod( 'newspaper_x_enable_top_bar_search', true );
                if ( $enable_search ): ?>
                    <?php $search_query = get_search_query(); ?>
                    <form role="search" method="get" id="searchform_topbar" action="<?php echo esc_url_raw( home_url( '/' ) ); ?>">
                        <label>
                            <input class=""	id=""
                                   placeholder="<?php echo esc_html__( 'Search...', 'newspaper-x' ) ?>"
                                   value="<?php echo esc_attr( $search_query ); ?>" name="s"
                                   type="search">
                        </label>
                        <button id="search-top-bar-submit" type="submit" class="search-top-bar-submit">
                            <span class="fa fa-search"></span>
                        </button>
                    </form>
                <?php endif; ?>
                <div class="top-header-icons">

                    <?php
                    $class         = 'menu pull-right';

                    if ( has_nav_menu( 'social' ) ) {

                        wp_nav_menu(
                            array(
                                'theme_location'  => 'social',
                                'container'       => 'div',
                                'container_id'    => 'menu-social',
                                'container_class' => $class,
                                'menu_id'         => 'menu-social-items',
                                'menu_class'      => 'menu-items',
                                'depth'           => 1,
                                'link_before'     => '<span class="screen-reader-text">',
                                'link_after'      => '</span>',
                                'fallback_cb'     => '',
                            )
                        );
                    } ?>

                </div>
            </div>
        </div>
    </div>
</div>