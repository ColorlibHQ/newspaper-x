<?php
/**
 * The template for displaying archive pages.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newspaper X
 */

get_header(); ?>
<?php
/**
 * Enable breadcrumbs
 */
$breadcrumbs_enabled = get_theme_mod( 'newspaper_x_enable_post_breadcrumbs', 'breadcrumbs_enabled' );
if ( $breadcrumbs_enabled == 'breadcrumbs_enabled' ) { ?>
	<div class="col-xs-12">
		<?php newspaper_x_breadcrumbs(); ?>
	</div>
<?php } ?>

<?php
/**
 * Banner Settings;
 */
$banner_count = get_theme_mod( 'newspaper_x_show_banner_after', 6 );

$archive     = newspaper_x_check_archive();
$first_posts = newspaper_x_get_first_posts( $archive );
global $wp_query;

if ( $first_posts->have_posts() ):
	?>
	<header class="col-xs-12">
		<?php
		the_archive_title( '<h3 class="page-title"><span>', '</span></h3>' );
		the_archive_description( '<div class="taxonomy-description">', '</div>' );
		?>
	</header><!-- .page-header -->

	<div class="col-xs-12 newspaper-x-archive-first-posts">
		<div class="row">
			<?php while ( $first_posts->have_posts() ) : $first_posts->the_post(); ?>

				<div class="col-md-6">
					<?php
					get_template_part( 'template-parts/content', get_post_format() );
					?>
				</div>

			<?php endwhile; ?>
		</div>
	</div>
<?php endif; ?>

	<div id="primary" class="newspaper-x-content newspaper-x-archive-page col-lg-8 col-md-8 col-sm-12 col-xs-12">
		<main id="main" class="site-main" role="main">
			<?php
			/**
			 * Render the first banner
			 */
			$enable_banner = get_theme_mod( 'newspaper_x_show_banner_on_archive_pages', true );

			if ( $enable_banner ) {
				echo wp_kses_post( newspaper_x_render_banner() );
			}

			?>

			<div class="row">
				<?php if ( have_posts() ) : ?>

				<?php
				/* Start the Loop */
				$count              = 1;
				$banner_count_index = 0;
				while ( have_posts() ) : the_post();
					$count ++;
					if ( $count <= 3 ) {
						$banner_count_index = 0;
						continue;
					}

					if ( fmod( $banner_count_index, $banner_count ) == 0 && $banner_count_index != 0 ) {
						echo wp_kses_post( newspaper_x_render_banner() );
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
					if ( fmod( ( $count - 1 ), 2 ) == 0 && ( $count - 1 ) != (int) $wp_query->post_count ) {
						echo '</div><div class="row">';
					} elseif ( ( $count - 1 ) == (int) $wp_query->post_count ) {
						continue;
					}
				endwhile;
				?>
			</div>
		<?php the_posts_pagination( array( 'prev_text' => 'prev', 'next_text' => 'next' ) ); ?>
		<?php
		else :
			echo '<div class="row">';
			get_template_part( 'template-parts/content', 'none' );
			echo '</div>';
		endif;
		?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_sidebar();
get_footer();
