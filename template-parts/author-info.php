<?php
/**
 * Template part for displaying author info.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newspaper X
 */
$social_media = array(
	'twitter',
	'facebook',
	'google-plus',
	'linkedin',
	'dribbble',
	'github',
	'pinterest',
	'tumblr',
	'youtube',
	'flickr',
	'vimeo',
	'instagram',
	'codepen',
);

$filtered = array();
foreach ( $social_media as $social_link ) {
	if ( ! empty( get_the_author_meta( $social_link ) ) ) {
		$filtered[ $social_link ] = get_the_author_meta( $social_link );
	}
}

// Grab the current author
$curauth = get_userdata( $post->post_author );

if ( is_single() && ! empty( $curauth->description ) && get_theme_mod( 'newspaperx_enable_author_box', 'enabled' ) === 'enabled' ) { ?>
	<!-- Author description -->
	<div class="row author-description">
		<!-- Avatar -->
		<div class="col-md-2 tpl-avatar">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 85 ); ?>
		</div>
		<!-- .Avatar -->
		<!-- Short Description -->
		<div class="col-md-10" itemscope="" itemtype="http://schema.org/Person">
			<h4 class="post-author"><?php echo get_the_author_posts_link(); ?></h4>
			<a class="post-author-website" href="<?php echo get_the_author_meta( 'url' ) ?>"><?php echo
				get_the_author_meta( 'url' ) ?></a>
			<ul class="social-links">
				<?php foreach ( $filtered as $key => $val ): ?>
					<li><a href="<?php echo esc_url( $val ) ?>"><span class="fa fa-<?php echo $key ?>"></span></a></li>
				<?php endforeach; ?>
			</ul>
			<p><?php the_author_meta( 'description' ); ?></p>
		</div>
		<!-- .Short Description -->
	</div>
	<!-- .Author description -->
<?php } ?>
