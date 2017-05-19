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
				<?php if ( $news_ticker ) {
					get_template_part( 'template-parts/news-ticker' );
				} ?>
            </div>
			<?php $has_menu = has_nav_menu( 'social' ); ?>
            <div class="col-lg-4">
				<?php
				$enable_search = get_theme_mod( 'newspaper_x_enable_top_bar_search', true );
				if ( $enable_search ): ?>
					<?php $search_query = get_search_query(); ?>
					<?php get_search_form();?>
				<?php endif; ?>
				<?php
				$class = 'menu pull-right';

				if ( has_nav_menu( 'social' ) ) { ?>
                    <div class="top-header-icons">
						<?php
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
						?>
                    </div>
					<?php
				}
				?>

            </div>
        </div>
    </div>
</div>