<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link    https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Newspaper X
 */

get_header(); ?>
<div class="container">
	<div class="row">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<section class="error-404 not-found">
					<header class="page-header">
						<h1><?php echo esc_html__( 'Oops! That page can&rsquo;t be found.', 'newspaper-x' ); ?></h1>
					</header><!-- .page-header -->

					<div class="page-content">
						<p><?php echo esc_html__( 'It looks like nothing was found at this location. Maybe try a better search?', 'newspaper-x' ); ?></p>

						<?php get_search_form(); ?>

					</div><!-- .page-content -->
				</section><!-- .error-404 -->

			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!--/.row-->
</div><!--/.container-->
<?php get_footer(); ?>

