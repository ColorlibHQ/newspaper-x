<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Newspaper X
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
	$top_bar = get_theme_mod( 'newspaper_x_enable_top_bar', true );
	if ( $top_bar ) :
		get_template_part( 'template-parts/top-header' );
	endif;

	?>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding container">
			<div class="row">
				<div class="col-md-4 header-logo">
					<?php
					$header_textcolor = get_theme_mod( 'header_textcolor' );
					if ( function_exists( 'the_custom_logo' ) ) {
						if ( has_custom_logo() ) {
							the_custom_logo();
						} else { ?>
							<?php
							if ( $header_textcolor !== 'blank' ):
								?>
								<a class="site-title"
								   href="<?php echo esc_url_raw( get_home_url() ) ?>"> <?php echo esc_html( get_option( 'blogname', 'newsmag-pro' ) ) ?></a>
							<?php endif; ?>
							<?php
							$description = get_bloginfo( 'description', 'display' );
							if ( $header_textcolor !== 'blank' && ! empty( $description ) ) : ?>
								<p class="site-description" <?php echo ( ! empty( $header_textcolor ) ) ? 'style="color:#' . esc_attr( $header_textcolor ) . '"' : ''; ?>><?php echo wp_kses_post( $description ); /* WPCS: xss ok. */ ?></p>
								<?php
							endif;
						}
					}
					?>
				</div>

				<?php
				$enable_banner = get_theme_mod( 'newspaper_x_show_banner_on_homepage', true );
				?>

				<?php if ( $enable_banner ): ?>
					<div class="col-md-8 header-banner">
						<?php
						$banner = get_theme_mod( 'newspaper_x_banner_type', 'image' );
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
						<?php wp_nav_menu( array(
							                   'theme_location' => 'primary',
							                   'menu_class'     => 'menu-main-menu-container'
						                   ) ); ?>
					</div>
				</div>
			</div>

		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content container">
		<?php $news_ticker = get_theme_mod( 'newspaper_x_enable_news_ticker', true ); ?>
		<?php if ( $news_ticker ) { ?>
		<div class="row">
			<div class="col-md-12">
				<section class="newspaper-x-news-ticker">
					<?php
					get_template_part( 'template-parts/news-ticker' );
					?>
				</section>
			</div>
		</div>
<?php }