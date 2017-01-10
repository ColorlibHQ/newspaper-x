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
					<?php $search_query = get_search_query(); ?>
					<div class="header-search-form">
						<div class="container">
							<!-- Search Form -->
							<form role="search" method="get" id="searchform_topbar"
							      action="<?php echo esc_url_raw( home_url( '/' ) ); ?>">
								<label><span
										class="screen-reader-text"><?php echo esc_html__( 'Search for:', 'newspaper-x' ) ?></span>
									<input
										class="search-field-top-bar <?php echo $search_query === '' ? '' : 'opened'; ?>"
										id="search-field-top-bar"
										placeholder="<?php echo esc_html__( 'Type the search term', 'newspaper-x' ) ?>"
										value="<?php echo esc_attr( $search_query ); ?>" name="s"
										type="search">
								</label>
								<button id="search-top-bar-submit" type="button"
								        class="search-top-bar-submit <?php echo $search_query === '' ? '' : 'submit-button'; ?>"><span
										class="first-bar"></span><span
										class="second-bar"></span></button>
							</form>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>