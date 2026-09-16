<?php
/**
 * The social links in the author box.
 *
 * A class of this name was removed in January 2021, but
 * template-parts/author-info.php kept calling it -- so from that release on,
 * every single post by an author with a bio died with a fatal error on an
 * undefined class. The demo site was hand-patched in June 2026 to work around
 * it; this fixes it in the theme.
 *
 * The original registered its own fields through user_contactmethods, which is
 * why it went: WordPress.org counts that as plugin territory, and theme-check
 * fails a theme for it. So nothing is registered here. The box renders whatever
 * contact methods the site already has -- WordPress' own, or any a plugin has
 * added -- which is a theme doing its job: displaying data it did not invent.
 *
 * @package Newspaper X
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Newspaper_X_Profile_Fields' ) ) {

	class Newspaper_X_Profile_Fields {

		/**
		 * Icon for a contact method, by its key.
		 *
		 * Written out in full rather than assembled from the key: the Font
		 * Awesome subset is built by scanning the theme for class strings, and
		 * a name put together at runtime is invisible to it -- the glyph would
		 * simply be missing.
		 *
		 * @return array
		 */
		public static function icons() {
			return array(
				'twitter'   => 'fa-brands fa-twitter',
				'facebook'  => 'fa-brands fa-facebook',
				'github'    => 'fa-brands fa-github',
				'youtube'   => 'fa-brands fa-youtube',
				'linkedin'  => 'fa-brands fa-linkedin',
				'instagram' => 'fa-brands fa-instagram',
				'pinterest' => 'fa-brands fa-pinterest',
				'tumblr'    => 'fa-brands fa-tumblr',
				'dribbble'  => 'fa-brands fa-dribbble',
				'myspace'   => 'fa-brands fa-square-js',
				'soundcloud' => 'fa-brands fa-soundcloud',
				'wikipedia' => 'fa-brands fa-wikipedia-w',
			);
		}

		/**
		 * Print the author's social links.
		 *
		 * @return void
		 */
		public static function echo_social_media() {

			if ( ! function_exists( 'wp_get_user_contact_methods' ) ) {
				return;
			}

			$icons = self::icons();
			$links = array();

			foreach ( wp_get_user_contact_methods() as $key => $label ) {
				$value = get_the_author_meta( $key );

				if ( ! $value ) {
					continue;
				}

				/*
				 * A contact method may hold a handle rather than a URL -- the
				 * Twitter field traditionally holds @name. Only linkable values
				 * become links.
				 */
				$url = esc_url( $value );

				if ( ! $url ) {
					continue;
				}

				/* translators: %s: the name of a social network or contact method. */
				$title = sprintf( __( '%s profile', 'newspaper-x' ), $label );

				$links[] = sprintf(
					'<li><a href="%1$s" target="_blank" rel="noopener noreferrer"><i class="%2$s" aria-hidden="true"></i><span class="screen-reader-text">%3$s</span></a></li>',
					$url,
					esc_attr( isset( $icons[ $key ] ) ? $icons[ $key ] : 'fa-solid fa-link' ),
					esc_html( $title )
				);
			}

			if ( ! $links ) {
				return;
			}

			echo '<div class="social-list"><ul>' . implode( '', $links ) . '</ul></div><!-- end .author-bio-social -->'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
		}
	}
}
