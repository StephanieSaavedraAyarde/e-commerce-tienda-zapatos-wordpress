<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package suitbuilder 
 */

if ( ! function_exists( 'suitbuilder_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function suitbuilder_posted_on( $post_id = false ) {
	global $post;
	$author_id=$post->post_author;
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U', $post_id ) !== get_the_modified_time( 'U', $post_id ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c', $post_id ) ),
		esc_html( get_the_date( '', $post_id ) ),
		esc_attr( get_the_modified_date( 'c', $post_id ) ),
		esc_html( get_the_modified_date( '', $post_id ) )
	);

	$posted_on = sprintf(
		/* translators: %s: search term */
		esc_html_X( '%s', 'post date', 'suitbuilder' ),
		'<a href="' . esc_url(get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d') )) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		/* translators: %s: search term */
		esc_html_X( ' %s', 'post author', 'suitbuilder' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( $author_id ) ) . '">' . esc_html( get_the_author_meta( 'user_nicename', $author_id ) ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'suitbuilder_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function suitbuilder_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html_x( ', ','list item separator', 'suitbuilder') );
		if ( $categories_list && suitbuilder_categorized_blog() ) {
			/* translators: %s: search term */
			printf( '<span class="cat-links">' . esc_html__( ' %1$s', 'suitbuilder' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'suitbuilder' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( ' %1$s', 'suitbuilder' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'suitbuilder' ), esc_html__( '1 Comment', 'suitbuilder' ), esc_html__( '% Comments', 'suitbuilder' ) );
		echo '</span>';
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function suitbuilder_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'suitbuilder_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'suitbuilder_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so suitbuilder_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so suitbuilder_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in suitbuilder_categorized_blog.
 */
function suitbuilder_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'suitbuilder_categories' );
}
add_action( 'edit_category', 'suitbuilder_category_transient_flusher' );
add_action( 'save_post',     'suitbuilder_category_transient_flusher' );
