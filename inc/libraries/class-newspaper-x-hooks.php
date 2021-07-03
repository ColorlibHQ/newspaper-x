<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Newspaper_X_Hooks
 */
class Newspaper_X_Hooks {
	/**
	 * Newspaper_X_Hooks constructor.
	 */
	public function __construct() {
		/**
		 * Fix responsive videos
		 */
		add_filter( 'embed_oembed_html', array( $this, 'fix_responsive_videos' ), 10, 3 );
		add_filter( 'video_embed_html', array( $this, 'fix_responsive_videos' ) );

		/**
		 * Comment form defaults
		 */
		add_filter( 'comment_form_defaults', array( $this, 'comment_form_defaults' ) );

		/**
		 * Ajax request to retrieve Attachment Image
		 */
		add_action( 'wp_ajax_newspaper_x_get_attachment_image', array( $this, 'get_attachment_image' ) );
		add_action( 'wp_ajax_nopriv_newspaper_x_get_attachment_image', array( $this, 'get_attachment_image' ) );
		/**
		 * Custom body classes
		 */
		add_filter( 'body_class', array( $this, 'body_classes' ) );

		/**
		 * Flush the category transient on category edit or post save
		 */
		add_action( 'edit_category', array( $this, 'category_transient_flusher' ) );
		add_action( 'save_post', array( $this, 'category_transient_flusher' ) );
		/**
		 * Change title of archive
		 */
		add_filter( 'get_the_archive_title', array( $this, 'remove_from_archive_title' ) );
		/**
		 * Add a <span> html tag to the category item
		 */
		add_filter( 'wp_list_categories', array( $this, 'add_span_cat_count' ) );
		add_filter( 'get_archives_link', array( $this, 'add_span_archive_count' ) );

		/**
		 * Load related posts
		 */
		add_action( 'wp_loaded', array( $this, 'load_related_posts' ) );

		/**
		 * Add post tags
		 */
		add_filter( 'the_content', array( $this, 'post_tags_bottom' ), 0 );

		/**
		 * Add action that the import has finished
		 */
		add_action( 'import_end', array( $this, 'import_finished' ) );
	}

	/**
	 * Add a reference in the database that the theme import has finished
	 */
	public function import_finished() {
		update_option( 'newspaper_x_importer_finished', '1' );
	}

	/**
	 * Filter the categories widget to add a <span> element before the count
	 *
	 * @param $links
	 *
	 * @return mixed
	 */
	public function add_span_cat_count( $links ) {
		$links = str_replace( '</a> (', '</a> <span class="newspaper-x-cat-count">', $links );
		$links = str_replace( ')', '</span>', $links );

		return $links;
	}

	/**
	 * Filter the archives widget to add a <span> element before the count
	 *
	 * @param $links
	 *
	 * @return mixed
	 */
	public function add_span_archive_count( $links ) {
		$links = str_replace( '</a>&nbsp;(', '</a> <span class="newspaper-x-cat-count"', $links );
		$links = str_replace( ')', '</span>', $links );

		return $links;
	}

	/**
	 * @param $title
	 *
	 * @return string|void
	 */
	public function remove_from_archive_title( $title ) {
		if ( is_category() ) {

			$title = single_cat_title( '', false );

		} elseif ( is_tag() ) {

			$title = single_tag_title( '', false );

		} elseif ( is_author() ) {

			$title = '<span class="vcard">' . get_the_author() . '</span>';

		}

		return $title;
	}

	/**
	 * Flush out the transients used in newspaper_x_categories.
	 */
	public function category_transient_flusher() {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Like, beat it. Dig?
		delete_transient( 'newspaper_x_categories' );
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 */
	public function body_classes( $classes ) {
		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		return $classes;
	}


	/**
	 * @param $content
	 *
	 * @return mixed|string
	 */
	public function add_plyr_layout( $content ) {
		if ( ! is_single() ) {
			return $content;
		}

		// has normal video
		// remove video tag
		preg_match( '/\[video.*?\]/', $content, $matches );
		if ( ! empty( $matches ) ) {
			preg_match_all( '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $matches[0], $match );
			if ( ! empty( $match ) && filter_var( $match[0][0], FILTER_VALIDATE_URL ) ) {
				$content = preg_replace( '/\[video.*?\]/', '', $content );
				$content = preg_replace( '/\[\/video.*?\]/', '', $content );

				$html = '<div>';
				$html .= '<video class="plyr">';
				$html .= '<source src=' . $match[0][0] . '>';
				$html .= '</video>';
				$html .= '</div>';

				return $html . $content;
			}
		};

		return $content;
	}

	/**
	 * @param $html
	 *
	 * @return string
	 */
	public function fix_responsive_videos( $html ) {
		return '<div class="newspaper-x-video-container">' . $html . '</div>';
	}

	/**
	 *
	 */
	public function get_attachment_image() {
		$id   = intval( $_POST['attachment_id'] );
		$size = esc_html( $_POST['attachment_size'] );

		$src = wp_get_attachment_image( $id, false );

		echo $src;
		die();
	}

	/**
	 * Init related posts
	 */
	public function load_related_posts() {
		$display_related_blog_posts = get_theme_mod( 'newspaper_x_related_posts_enabled', true );

		if ( $display_related_blog_posts ) {
			Newspaper_X_Related_Posts::getInstance();
		}
	}

	/**
	 * @param $defaults
	 *
	 * @return mixed
	 */
	public function comment_form_defaults( $defaults ) {
		$commenter                        = wp_get_current_commenter();
		$req                              = get_option( 'require_name_email' );
		$aria_req                         = ( $req ? " aria-required='true'" : '' );
		$defaults['title_reply']          = '<span>' . esc_html__( 'Leave a reply', 'newspaper-x' ) . '</span>';
		$defaults['label_submit']         = esc_html__( 'Submit', 'newspaper-x' );
		$defaults['comment_notes_before'] = '<span class="comment_notes_before">' . esc_html__( 'Your email address will not be published. Required fields are marked *', 'newspaper-x' ) . '</span>';
		$defaults['comment_field']        = '<p class="comment-form-comment"><textarea id="comment" name="comment"  placeholder="' . esc_html__( 'Comment', 'newspaper-x' ) . '" aria-required="true"></textarea></p>';
		$defaults['fields']               = array(

			'author' =>
				'<div class="row"><p class="comment-form-author col-sm-4"><input id="author" name="author" type="text" placeholder="' . esc_html__( 'Name', 'newspaper-x' ) . ( $req ? '*' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) .
				'" size="30"' . $aria_req . ' /></p>',

			'email' =>
				'<p class="comment-form-email col-sm-4"><input id="email" name="email" type="text" placeholder="' . esc_html__( 'Email', 'newspaper-x' ) . ( $req ? '*' : '' ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) .
				'" size="30"' . $aria_req . ' /></p>',

			'url' =>
				'<p class="comment-form-url col-sm-4">' .
				'<input id="url" name="url" type="text" placeholder="' . esc_html__( 'Website', 'newspaper-x' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) .
				'" size="30" /></p></div>',
		);

		return $defaults;
	}

	/**
	 * @param $content
	 *
	 * @return string
	 */
	public function post_tags_bottom( $content ) {
		$tags_list = get_the_tag_list( '<span>', '</span>' );
		if ( ! $tags_list ) {
			return $content;
		}

		$tags = '<div class="newspaper-x-tags"><span></span></div>';
		if ( $tags_list ) {
			$tags = '<div class="newspaper-x-tags"><strong>' . esc_html__( 'TAGS: ', 'newspaper-x' ) . '</strong>' . $tags_list . ' </div>';
		}
		$fullcontent = $content . $tags;

		return $fullcontent;
	}
}