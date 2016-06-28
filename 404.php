<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link    https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Bugle
 */

get_header(); ?>
<div class="container">
	<div class="row">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<section class="error-404 not-found">
					<header class="page-header">
						<h1><?php _e( 'Oops! That page can&rsquo;t be found.', 'bugle' ); ?></h1>
					</header><!-- .page-header -->

					<div class="page-content">
						<p><?php _e( 'It looks like nothing was found at this location. Maybe try a better search?', 'bugle' ); ?></p>

						<?php get_search_form(); ?>

					</div><!-- .page-content -->
				</section><!-- .error-404 -->

			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!--/.row-->
</div><!--/.container-->
<?php get_footer(); ?>

