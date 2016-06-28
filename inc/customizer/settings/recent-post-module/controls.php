<?php
global $wp_customize;

/**
 * Multiple category select for the recent post module
 */
$categories = get_categories( 'hide_empty=0' );
$options    = array();

foreach ( $categories as $category ) {
	$options[ $category->term_id ] = $category->cat_name;
}

$wp_customize->add_control(
	new Bugle_Control_Checkbox_Multiple(
		$wp_customize,
		'bugle_recent_posts_category',
		array(
			'choices' => $options,
			'label'   => esc_html__( 'Categories', 'bugle' ),
			'section' => 'bugle_recent_post_module',
		)
	)
);

/**
 * Ordering
 */
$wp_customize->add_control(
	'bugle_recent_posts_ordering',
	array(
		'type'    => 'radio',
		'choices' => array(
			'ASC'  => esc_html__( 'Ascending', 'bugle' ),
			'DESC' => esc_html__( 'Descending', 'bugle' ),
		),
		'label'   => esc_html__( 'Ordering', 'bugle' ),
		'section' => 'bugle_recent_post_module',
	)
);
/**
 * Order by control
 */
$wp_customize->add_control(
	'bugle_recent_posts_order_by',
	array(
		'type'    => 'radio',
		'choices' => array(
			'date'          => esc_html__( 'By Date', 'bugle' ),
			'title'         => esc_html__( 'By Title', 'bugle' ),
			'comment_count' => esc_html__( 'By Comment Count', 'bugle' ),
			'rand'          => esc_html__( 'Random', 'bugle' )
		),
		'label'   => esc_html__( 'Order By', 'bugle' ),
		'section' => 'bugle_recent_post_module',
	)
);