<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Newspaper X
 */

if ( ! function_exists( 'newspaperx_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function newspaperx_posted_on() {
		$cat       = get_the_category();
		$comments  = wp_count_comments( get_the_ID() );
		$date      = get_the_date( 'F d, Y' );
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'newspaper-x' ) );


		$html = '<ul>';
		$html .= '<li class="post-category"><icon class="fa fa-folder"></icon> <a href="' . esc_url( get_category_link( $cat[0]->term_id ) ). '">' . get_the_category_by_ID( $cat[0]->term_id ) . '</a></li>';
		$html .= '<li class="post-comments"><icon class="fa fa-comments"></icon> ' . $comments->approved . ' </li>';
		$html .= '<li class="post-date">' . $date . ' </li>';
		if ( $tags_list ) {
			$html .= '<li class="post-tags"><icon class="fa fa-tags"></icon> ' . $tags_list . '</li>';
		}
		$html .= '</ul>';

		echo $html;
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function newspaperx_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'newspaperx_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			                                     'fields'     => 'ids',
			                                     'hide_empty' => 1,
			                                     // We only need to know if there is more than one category.
			                                     'number'     => 2,
		                                     ) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'newspaperx_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so newspaperx_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so newspaperx_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in newspaperx_categorized_blog.
 */
function newspaperx_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'newspaperx_categories' );
}

add_action( 'edit_category', 'newspaperx_category_transient_flusher' );
add_action( 'save_post', 'newspaperx_category_transient_flusher' );


/**
 * Custom functions to retrieve data
 */
function newspaperx_numeric_posts_nav( $pages = '', $range = 4 ) {
	$showitems = ( $range * 2 ) + 1;

	global $paged;
	if ( empty( $paged ) ) {
		$paged = 1;
	}

	if ( $pages == '' ) {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if ( ! $pages ) {
			$pages = 1;
		}
	}

	if ( 1 != $pages ) {
		echo '<div class="row text-center"><ul class="newspaperx-pager">';
		if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) {
			echo "<li><a href='" . get_pagenum_link( 1 ) .
			     "'><i class='fa fa-angle-double-left'></i></a></li>";
		}
		if ( $paged > 1 && $showitems < $pages ) {
			echo "<li><a href='" . get_pagenum_link( $paged - 1 ) .
			     "'><i class='fa fa-long-arrow-left'></i></a></li>";
		}

		for ( $i = 1; $i <= $pages; $i ++ ) {
			if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
				echo ( $paged == $i ) ? "<li class=\"active\">" . $i .
				                        "</li>" : "<li><a href='" . get_pagenum_link( $i ) .
				                                  "' class=\"inactive\">" . $i .
				                                  "</a></li>";
			}
		}

		if ( $paged < $pages && $showitems < $pages ) {
			echo "<li><a href=\"" . get_pagenum_link( $paged + 1 ) .
			     "\"><i class='fa fa-long-arrow-right'></i></a></li>";
		}
		if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) {
			echo "<li><a href='" . get_pagenum_link( $pages ) .
			     "'><i class='fa fa-angle-double-right'></i></a></li>";
		}
		echo "</ul></div>\n";

	}
}
