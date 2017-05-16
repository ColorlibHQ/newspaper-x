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
			<div class="col-md-12">
				<nav id="top-header-navigation" class="pull-left">
					<?php wp_nav_menu( array( 'theme_location' => 'top-header', 'depth' => 1 ) ); ?>
				</nav>
				<div class="top-header-icons">
					<?php
					$enable_search = get_theme_mod( 'newspaper_x_enable_top_bar_search', true );
					$class         = 'menu pull-right';

					if ( $enable_search ) {
						$class = 'menu pull-right search-enabled';
					}

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
					}

					if ( $enable_search ): ?>
						<button href="#" class="search-form-opener" type="button"><span class="fa fa-search"></span>
						</button>
					<?php endif; ?>
				</div>
				<?php if ( $enable_search ): ?>
					<div class="header-search-form">
						<div class="container">
							<?php 
								$search = get_search_form(false); 
								echo str_replace('type="submit"','type="button"',$search);
							?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>