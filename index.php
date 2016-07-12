<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newspaper X
 */

get_header();

/**
 * Banner Settings;
 */
$banner_count = get_theme_mod( 'newspaperx_show_banner_after', 6 );

if ( is_home() && ! is_front_page() ) : ?>
	<header class="col-xs-12">
		<h3 class="page-title"><span><?php single_post_title(); ?></span></h3>
	</header><!-- .page-header -->
<?php endif; ?>
	<div class="row">
		<div id="primary" class="newspaperx-content newspaperx-archive-page col-lg-8 col-md-8 col-sm-12 col-xs-12">
			<main id="main" class="site-main" role="main">
				<?php
				$banner_count_index = 0;
				if ( have_posts() ) :
					?>
					<div class="row">
						<?php
						while ( have_posts() ) : the_post();

							if ( fmod( $banner_count_index, $banner_count ) == 0 && $banner_count_index != 0 ) {
								echo newspaperx_render_banner();
							}

							$banner_count_index ++;
							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							?>
							<div class="col-md-6">
								<?php
								get_template_part( 'template-parts/content', get_post_format() );
								?>
							</div>
							<?php
							if ( fmod( $banner_count_index, 2 ) == 0 && $banner_count_index != (int) $wp_query->post_count ) {
								echo '</div><div class="row">';
							} elseif ( $banner_count_index == (int) $wp_query->post_count ) {
								continue;
							}
						endwhile;
						?>
					</div>
					<?php
					newspaperx_numeric_posts_nav();
				else :
					echo '<div class="row">';
					get_template_part( 'template-parts/content', 'none' );
					echo '</div>';
				endif;
				?>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php get_sidebar( 'default-widget-area' ); ?>
	</div>

<?php
get_footer();

