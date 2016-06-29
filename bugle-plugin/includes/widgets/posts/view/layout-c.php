<?php
/**
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Bugle
 * @subpackage Bugle/includes
 */

$posts = Bugle_Helper::get_posts( $params );
$size  = 12 / (int) $params['posts_per_row'];
$i = 0;
?>
<div class="row bugle-layout-c-row">
	<?php while ( $posts->have_posts() ) : $posts->the_post();
		$i++;
		$image = '<img class="attachment-bugle-recent-post-big size-bugle-recent-post-big wp-post-image" height="360" src="'.get_template_directory_uri() . '/images/picture_placeholder.jpg" />';

		if ( has_post_thumbnail() ) {
			$image = get_the_post_thumbnail( get_the_ID(), 'bugle-recent-post-big' );
		}
		$new_image = apply_filters( 'bugle_widget_image', $image );
		?>
		<div class="col-md-<?php echo $size ?> col-xs-6">
			<div class="bugle-blog-post-layout-c">
				<div class="bugle-image">
					<a href="<?php echo get_the_permalink(); ?>">
						<?php echo $new_image ?>
					</a>
				</div>
				<div class="bugle-title">
					<h3>
						<a href="<?php echo get_the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), 6 ); ?></a>
					</h3>
				</div>
				<div class="bugle-post-meta">
					<?php echo Bugle_Helper::get_post_meta( get_the_ID() ) ?>
				</div>
			</div>
		</div>
		<?php
		
			if(fmod( $i, (int) $params['posts_per_row']  ) == 0 && $i != (int) $posts->post_count){
				echo '</div><div class="row bugle-layout-c-row">';
			} elseif ($i == (int) $posts->post_count) {
				continue;
			}
			
		?>
	<?php endwhile; ?>
</div>