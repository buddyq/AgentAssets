<?php
/**
 * Pluggable - aveone pluggable functions.
 *
 * These functions can be replaced via styles/plugins. If styles/plugins do
 * not redefine these functions, then these will be used instead.
 *
 * @package WPaveone
 * @subpackage Core
 */

/**
 * aveone_entry_comments() - Displays the number of comments in current post enclosed in a link.
 *
 * @since 0.3
 */
if ( ! function_exists( 'aveone_entry_comments' ) ):
	function aveone_entry_comments() {
		if (is_singular()) return;
		ob_start();

		comments_popup_link( 'leave a comment', '<span class="comment-count">1</span> comment', '<span class="comment-count">%</span> '.__( 'comments', 'aveone').'', 'commentslink', '<span class="comments-closed">'.__( 'comments closed', 'aveone' ).'</span>' );

		return '<span class="entry-comments">' . ob_get_clean() . '</span>';
	}
endif;

/**
 * aveone_comment_name() - short description
 *
 * @since 0.3
 */
if ( ! function_exists( 'aveone_comment_name' ) ):
	function aveone_comment_name() {
		$commenter = get_comment_author_link(); // Get comentor's details
		return "<cite class=\"commenter fn n\">{$commenter}</cite>"; // Commentor vcard
	}
endif;

/**
 * aveone_comment_avatar() - short description
 *
 * @since 0.3
 */
 



 

if ( ! function_exists( 'aveone_comment_avatar' ) ):
	function aveone_comment_avatar( $avatar = true, $gravatar_size = 45 ) {
		$author = get_comment_author();

		if ( $avatar ) {
			// Get author's gavatar
			$gravatar_email = get_comment_author_email();
			$gravatar_size = apply_filters( 'aveone_gravatar_size', (int) $gravatar_size ); // Available filter: aveone_gravatar_size
			$gravatar = get_avatar( $gravatar_email, $gravatar_size );
			
			// get the $src data from $gavatar
			if ( preg_match( '/src=\'(.*?)\'/i', $gravatar, $matches ) )
				$src = $matches[1];
			
			// Rebuild Gravatar link because get_avatar() produces invalid code :/ (P.S. adds "gravatar" class)
		$output = "<img class=\"avatar gravatar gravatar-{$gravatar_size}\" alt=\"{$author}'s Gravatar\" src=\"{$src}\" width=\"{$gravatar_size}\" height=\"{$gravatar_size}\" />";
    
    if (get_option('show_avatars')){  // Avatars enabled?
			return apply_filters( 'aveone_comment_avatar', (string) $output ); // Available filter: aveone_comment_avatar
      }
		}
	}
endif;



/**
 * aveone_entry_time() - Displays the current post time
 *
 * @since 0.3
 */
if ( ! function_exists( 'aveone_entry_time' ) ):
	function aveone_entry_time() {
		return '<span class="entry-time">' . get_the_time( get_option('time_format') ) . '</span>';
	}
endif;

/**
 * aveone_comment_date() - short description
 *
 * @since 0.3.1
 */
if ( ! function_exists( 'aveone_comment_date' ) ):
	function aveone_comment_date() {
		$date  = '<span class="comment-date">';
		$date .= get_comment_date();
		$date .= '</span>' . "\n";
		return apply_filters( 'aveone_comment_date', (string) $date ); // Available filter: aveone_comment_date
	}
endif;

/**
 * aveone_comment_time() - short description
 *
 * @since 0.3.1
 */
if ( ! function_exists( 'aveone_comment_time' ) ):
	function aveone_comment_time() {
		$time  = '<span class="comment-date">';
		$time .= get_comment_time();
		$time .= '</span>' . "\n";
		return apply_filters( 'aveone_comment_time', (string) $time ); // Available filter: aveone_comment_time
	}
endif;

/**
 * aveone_comment_link() - short description
 *
 * @since 0.3.1
 */
if ( ! function_exists( 'aveone_comment_link' ) ):
	function aveone_comment_link() {
		$link  = '<span class="comment-permalink">';
		$link .= '<a rel="bookmark" title="'.__( 'Permalink to this comment', 'aveone' ).'" href="'. htmlspecialchars( get_comment_link() ) .'">';
		$link .= apply_filters( 'aveone_comment_link_text', (string) '<i class="fa fa-link"></i>' );
		$link .= '</a></span>' . "\n";
		return apply_filters( 'aveone_comment_link', (string) $link ); // Available filter: aveone_comment_link
	}
endif;

/**
 * aveone_comment_edit() - short description
 *
 * @since 0.3.1
 */
if ( ! function_exists( 'aveone_comment_edit' ) ):
	function aveone_comment_edit() {
		ob_start();
		edit_comment_link( __( 'EDIT', 'aveone' ), '<span class="edit-comment">', '</span>' );
		return ob_get_clean();
	}
endif;

/**
 * aveone_comment_reply() - short description
 *
 * @since - 0.3.1
 */
if ( ! function_exists( 'aveone_comment_reply' ) ):
	function aveone_comment_reply( $return = false ) {
		global $comment_depth;
		$max_depth = get_option( 'thread_comments_depth' );
		$reply_text = apply_filters( 'aveone_reply_text', (string) 'Reply' ); // Available filter: aveone_reply_text
		$login_text = apply_filters( 'aveone_login_text', (string) 'Log in to reply.' ); // Available filter: aveone_login_text
		if ( ( get_option( 'thread_comments' ) ) && get_comment_type() == 'comment' ) {
			
			if ( $return ) {
				return get_comment_reply_link( array(
					'reply_text' => $reply_text,
					'login_text' => $login_text,
					'depth' => $comment_depth,
					'max_depth' => $max_depth,
					'before' => '<span class="comment-reply">', 
					'after' => '</span>'
				));
			} else {
				comment_reply_link( array(
					'reply_text' => $reply_text,
					'login_text' => $login_text,
					'depth' => $comment_depth,
					'max_depth' => $max_depth,
					'before' => '<div class="comment-reply">', 
					'after' => '</div>'
				));
			}
		}
	}
endif;



add_filter( 'wp_get_attachment_link' , 'add_lighbox_rel' );
function add_lighbox_rel( $attachment_link ) {
	if( strpos( $attachment_link , 'a href') != false && strpos( $attachment_link , 'img src') != false )
		$attachment_link = str_replace( 'a href' , 'a rel="gallery" href' , $attachment_link );
	return $attachment_link;
}

?>