<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bugle
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">

	<?php
	/**
	 * Enable / Disable the top bar
	 */
	if ( get_theme_mod( 'bugle_enable_top_bar', 'enabled' ) !== 'disabled' ) :
		get_template_part( 'template-parts/top-header' );
	endif;

	?>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding container">
			<div class="row">
				<div class="col-md-4 header-logo">
					<?php
					if ( function_exists( 'the_custom_logo' ) ) {
						the_custom_logo();
						if ( ! get_theme_mod( 'custom_logo' ) ) {
							?>
							<a class="custom-logo-link" href="<?php echo get_home_url() ?>"> <img class="custom-logo"
							                                                                      src="<?php echo get_template_directory_uri() . '/images/logo.png' ?>"/></a>
							<?php
						}
					}
					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
						<?php
					endif; ?>
				</div>

				<?php if ( get_theme_mod( 'bugle_show_banner_on_homepage', 'enabled' ) === 'enabled' ): ?>
					<div class="col-md-8 header-banner">
						<?php
						$banner = get_theme_mod( 'bugle_banner_type', 'image' );
						get_template_part( 'template-parts/banner/banner', $banner );
						?>
					</div>
				<?php endif; ?>
			</div>
		</div><!-- .site-branding -->
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<button class="menu-toggle" aria-controls="primary-menu"
						        aria-expanded="false"><span class="fa fa-bars"></span></button>
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
					</div>
				</div>
			</div>

		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content container">
		<div class="row">

			<?php if ( get_theme_mod( 'bugle_enable_news_ticker', 'enabled' ) === 'enabled' ) { ?>
			<div class="col-md-12">
				<section class="bugle-news-ticker">
					<?php
					get_template_part( 'template-parts/news-ticker' );
					?>
				</section>
			</div>
			<?php }