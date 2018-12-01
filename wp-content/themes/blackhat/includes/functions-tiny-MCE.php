<?php
/*
 * MCE manager
 * MCE is administrated here
 */
add_editor_style( 'editor-style.css' );

/* 
 * tinyMCE Font size option support 
 */
if ( ! function_exists( 'blackhat_tiny_mce_args' ) ) {
	function blackhat_tiny_mce_args( $options ) {
		$options['height']           = '250px';
		$options['fontsize_formats'] = '10px 12px 13px 14px 15px 16px 18px 20px 22px 24px 26px 28px 30px 32px 34px 36px 38px 40px 42px 44px 46px 48px 64px';

		return $options;
	}

	add_filter( 'tiny_mce_before_init', 'blackhat_tiny_mce_args' );
}

if ( ! function_exists( 'blackhat_tiny_mce_fontsize_filter' ) ) {
	function blackhat_tiny_mce_fontsize_filter( $options ) {
		array_shift( $options );
		array_unshift( $options, 'fontsizeselect' );
		array_unshift( $options, 'fontweightselect' );

		array_unshift( $options, 'formatselect' );

		return $options;
	}

	add_filter( 'mce_buttons_2', 'blackhat_tiny_mce_fontsize_filter' );
}