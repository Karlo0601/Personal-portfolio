<?php
/*
 * BlackHat Functions
 */
//require 'includes//WP_Mail.php';
define( 'blackhat_template_path', get_template_directory_uri() );
define( 'blackhat_template_dir', get_template_directory() );

 /*
 * Set ENV variable
 */
global $env;
$env = constant( "ENV" );

/*
 * Collecting all dependencies
 */
//require_once( 'assets/calendar/functions-calendar.php' );
require_once( 'includes/functions-blackhat.php' );
require_once( 'includes/functions-assets.php' );
require_once( 'includes/functions-menus.php' );
require_once( 'includes/functions-cpt.php' );
require_once( 'includes/functions-excerpt.php' );
require_once( 'includes/functions-flexible-layout.php' );
require_once( 'includes/functions-tiny-MCE.php' );
require_once( 'includes/WP_Mail.php' );
require_once( 'includes/functions-ajax.php' );

/**
* Check for dependencies and notify the user
*/
function blackhat_check() {
	// Check if ACF is activated
	if ( ! class_exists( 'acf' ) ) {
		echo '<div class="notice notice-error">
				<p>' . __( 'BlackHat Theme is dependant on Advanced Custom Fields plugin. Please install and activate it.', 'blackhat' ) . '</p>
			</div>';
	} else {
		return;
	}
}
add_action( 'admin_notices', 'blackhat_check' );

/*
 * Clearing some unnecessary WP
 */
add_filter( 'show_admin_bar', '__return_false' );

function blackhat_remove_head_links() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
}

add_action( 'init', 'blackhat_remove_head_links' );