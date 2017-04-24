
<div class="row">
	<?php
		$enable_banner = get_theme_mod( 'newspaper_x_show_banner_on_homepage', true );
	?>

	<?php if ( $enable_banner ): ?>
			<div class="col-md-offset-2 newspapper-spacer col-md-8 header-banner">
				<?php
				$banner = get_theme_mod( 'newspaper_x_banner_type', 'image' );
				get_template_part( 'template-parts/banner/banner', $banner );
				?>
			</div>
	<?php endif; ?>
</div>
