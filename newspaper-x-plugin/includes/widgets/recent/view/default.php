<?php
/**
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Newspaper X
 * @subpackage Newspaper X/includes
 */

$posts = NewspaperX_Helper::get_posts( $params ); ?>


<?php while ( $posts->have_posts() ) : $posts->the_post();

	$image = '<img class="attachment-newspaperx-recent-post-list-image size-newspaperx-recent-post-list-image wp-post-image" src="' . get_template_directory_uri() . '/images/picture_placeholder.jpg' . '" width="95px" 
	height="65px" />';

	if ( has_post_thumbnail() ) {
		$image = get_the_post_thumbnail( get_the_ID(), 'newspaperx-recent-post-list-image' );
	}

	$new_image = apply_filters( 'newspaperx_widget_image', $image );
	?>

	<div class="newspaperx-recent-post-widget">
		<div class="newspaperx-image">
			<a href="<?php echo get_the_permalink(); ?>">
				<?php echo $new_image ?>
			</a>
		</div>
		<div class="newspaperx-post-content">
			<div class="newspaperx-title">
				<h3><a href="<?php echo get_the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), 6 ); ?></a>
				</h3>
			</div>
			<div class="newspaperx-post-meta">
				<?php echo NewspaperX_Helper::get_post_meta( get_the_ID() ) ?>
			</div>
		</div>
	</div>

<?php endwhile; ?>
