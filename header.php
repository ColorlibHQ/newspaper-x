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
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<?php wp_body_open(); ?>
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
								   href="<?php echo esc_url( get_home_url() ) ?>"> <?php echo esc_html( get_option( 'blogname', 'newspaper-x' ) ) ?></a>
							<?php endif; ?>
							<?php
							$description = get_bloginfo( 'description', 'display' );
							if ( $header_textcolor !== 'blank' && ! empty( $description ) ) : ?>
								<p class="site-description"><?php echo wp_kses_post( $description ); /* WPCS: xss ok. */ ?></p>
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
						<?php
						if ( has_nav_menu( 'primary' ) ) {
							wp_nav_menu( array(
								             'theme_location' => 'primary',
								             'menu_id'        => 'primary-menu'
							             ) );
						} else {
							?>
							<div class="menu-all-pages-container">
								<ul id="primary-menu" class="menu nav-menu" aria-expanded="false">
									<?php if ( current_user_can( 'administrator' ) ): ?>
										<li>
											<a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>"><?php echo esc_html__( 'Add a menu', 'newspaper-x' ); ?></a>
										</li>
									<?php else: ?>
										<li>
											<a href="<?php echo esc_url( get_home_url() ); ?>"><?php echo esc_html__( 'Home', 'newspaper-x' ); ?></a>
										</li>
									<?php endif; ?>
								</ul>
							</div>
							<?php
						} ?>
					</div>
				</div>
			</div>

		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content container">
		
