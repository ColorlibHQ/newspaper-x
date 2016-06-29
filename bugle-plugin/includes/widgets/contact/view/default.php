<?php if ( isset( $params['contact_title'] ) ): ?>
	<h3 class="widget-title"><?php echo esc_html( $params['contact_title'] ) ?></h3>
<?php endif; ?>

<?php if ( isset( $params['phone'] ) ): ?>
	<p class="bugle-contact-p"><?php echo __( 'Phone:', 'bugle' ) ?> <?php echo esc_html( $params['phone'] ) ?></p>
<?php endif; ?>

<?php if ( isset( $params['email'] ) ): ?>
	<p class="bugle-contact-p"><?php echo __( 'Email:', 'bugle' ) ?> <?php echo esc_html( $params['email'] ) ?></strong></p>
<?php endif; ?>

<?php if ( isset( $params['address'] ) ): ?>
	<p class="bugle-contact-p"><?php echo __( 'Address:', 'bugle' ) ?> <?php echo esc_html( $params['address'] ) ?></strong></p>
<?php endif;

if ( has_nav_menu( 'social' ) ) {

	wp_nav_menu(
		array(
			'theme_location'  => 'social',
			'container'       => 'div',
			'container_id'    => 'menu-social-1',
			'container_class' => 'menu',
			'menu_id'         => 'menu-social-items-1',
			'menu_class'      => 'menu-items',
			'depth'           => 1,
			'link_before'     => '<span class="screen-reader-text">',
			'link_after'      => '</span>',
			'fallback_cb'     => '',
		)
	);
}
