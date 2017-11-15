<?php

/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package canis
 */
if ( ! function_exists( 'canis_posted_on' ) ) {
	function canis_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string, esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() ), esc_attr( get_the_modified_date( 'c' ) ), esc_html( get_the_modified_date() ) );
		$posted_on = $time_string;

		return $posted_on;
	}
}

if ( ! function_exists( 'canis_entry_footer' ) ) :

	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function canis_entry_footer() {
		$posted_on = canis_posted_on();
		$allowed_meta = get_theme_mod( 'canis_manage_meta', array( 'author', 'date', 'comment' ) );

		$byline = sprintf( _x( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>', 'post author', 'canis' ), esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), get_the_author() );

		$cat_links = false;
		$tags_list = false;

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'canis' ) );
			if ( $categories_list && canis_categorized_blog() ) {
				$cat_links = esc_html( $categories_list );
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '<ul class="canis-tags"><li>', '</li><li>', '</li></ul>' );
		}

		if ( in_array( 'author', $allowed_meta, true ) ) {
			echo "<span class='byline canis-meta-item canis-icon-user'>" . $byline . '</span> ';
		}

		if ( in_array( 'date', $allowed_meta, true ) ) {
			echo "<span class='posted-on canis-meta-item canis-icon-calendar'>" . $posted_on . '</span> ';
		}

		if ( $cat_links && in_array( 'categories', $allowed_meta, true ) ) {
			echo "<span class='cat-links canis-meta-item canis-icon-category'>" . $cat_links . '</span> ';
		}
		if ( $tags_list && in_array( 'tags', $allowed_meta, true ) ) {
			echo "<span class='tag-links canis-meta-item canis-icon-tags'>" . $tags_list . '</span> ';
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) && in_array( 'comment', $allowed_meta, true ) ) {
			echo '<span class="comments-link canis-meta-item canis-icon-comment">';
			comments_popup_link( esc_html__( 'Leave a comment', 'canis' ), esc_html__( 'Comment (1)', 'canis' ), esc_html__( 'Comments (%)', 'canis' ) );
			echo '</span>';
		}

		edit_post_link( esc_html__( 'Edit', 'canis' ), '<i class="edit-link">', '</i>' );
	}

endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function canis_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'canis_categories' ) ) ) {
		$args = array(
			'fields'	 => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'	 => 2,
		);

		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( $args );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'canis_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so canis_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so canis_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in canis_categorized_blog.
 */
function canis_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'canis_categories' );
}

add_action( 'edit_category', 'canis_category_transient_flusher' );
add_action( 'save_post', 'canis_category_transient_flusher' );
