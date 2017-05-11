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
	new Epsilon_Control_Checkbox_Multiple(
		$wp_customize,
		'newspaper_x_frontpage_header_category',
		array(
			'choices' => $options,
			'label'   => esc_html__( 'Categories', 'newspaper-x' ),
			'section' => 'newspaper_x_frontpage_header_section',
		)
	)
);

/**
 * Ordering
 */
$wp_customize->add_control(
	'newspaper_x_frontpage_header_ordering',
	array(
		'type'    => 'radio',
		'choices' => array(
			'ASC'  => esc_html__( 'Ascending', 'newspaper-x' ),
			'DESC' => esc_html__( 'Descending', 'newspaper-x' ),
		),
		'label'   => esc_html__( 'Ordering', 'newspaper-x' ),
		'section' => 'newspaper_x_frontpage_header_section',
	)
);
/**
 * Order by control
 */
$wp_customize->add_control(
	'newspaper_x_frontpage_header_order_by',
	array(
		'type'    => 'radio',
		'choices' => array(
			'date'          => esc_html__( 'By Date', 'newspaper-x' ),
			'title'         => esc_html__( 'By Title', 'newspaper-x' ),
			'comment_count' => esc_html__( 'By Comment Count', 'newspaper-x' ),
			'rand'          => esc_html__( 'Random', 'newspaper-x' )
		),
		'label'   => esc_html__( 'Order By', 'newspaper-x' ),
		'section' => 'newspaper_x_frontpage_header_section',
	)
);