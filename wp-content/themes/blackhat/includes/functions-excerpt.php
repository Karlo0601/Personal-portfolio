<?php
/*
 * Excerpt manager
 * All Excerpts are administrated here
 */


/**
 * Get excerpt if post has one, otherwise get character limited stripped content.
 *
 * @param integer $char_count Character limit, optional.
 * @param string $id optional.
 * @return string.
 */
function blackhat_excerpt( $char_count = 200, $id = false ) {

	if ( ! $id ) {
		$id = get_the_ID();
	}

	$tag_list = array(
		'h1',
		'h2',
		'h3'
	);

	$the_post = get_post( $id );

	if ( has_excerpt($id) ) {

		$excerpt = $the_post->post_excerpt;

		return '<p>' . $excerpt . '</p>';

	} else {
		$content = $the_post->post_content;

		foreach ( $tag_list as $tag ) {
			$regex = "@<" . $tag . "[^>]*?>.*?<\/" . $tag . ">@si";
			$content = preg_replace($regex, ' ', $content);
		}

		$excerpt = wp_strip_all_tags( strip_shortcodes($content), true );
		
		if ( strlen($excerpt) > $char_count ) {
			$str = wordwrap($excerpt, $char_count, "<blackhat_break>", false);
			$str = explode("<blackhat_break>", $str);
			$excerpt = $str[0];
		}
		
		$last_three_chars = substr($excerpt, -3);
		$last_char = substr($excerpt, -1);
		
		if ( ($last_three_chars != '...') && ($last_char == '.') ) {
			return '<p>' . $excerpt . '</p>';
		} elseif ( strlen($excerpt) == 0 ) {
			return;
		} else {
			return '<p>' . $excerpt . '...</p>';
		}

	}

}

?>