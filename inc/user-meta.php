<?php
add_filter( 'user_contactmethods', 'add_social_media_fields', 10, 1 );

function add_social_media_fields( $social ) {

		$new_socials = array(
			'twitter'     => 'Twitter',
			'facebook'    => 'Facebook',
			'github'      => 'GitHub',
			'youtube'     => 'YouTube',
			'google-plus' => 'Google Plus',
			'linkedin'    => 'LinkedIn'
		);

		return array_merge( $social, $new_socials );
	}

function echo_social_media() {

		$socials = array(
			'twitter'     => get_the_author_meta( 'twitter' ),
			'facebook'    => get_the_author_meta( 'facebook' ),
			'github'      => get_the_author_meta( 'github' ),
			'youtube'     => get_the_author_meta( 'youtube' ),
			'google-plus' => get_the_author_meta( 'google-plus' ),
		);

		$socials = array_filter( $socials );

		$html = '<div class="social-list"><ul>';
		foreach ( $socials as $k => $v ) {
			$html .= '<li><a href="' . esc_url( $v ) .'" target="_blank"><i class="fa fa-' . esc_attr( $k ) . '"></i></a></li>';
		}
		$html .= '</ul></div><!-- end .author-bio-social -->';

		echo $html;
	}