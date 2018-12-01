<?php
/*
 * Menu manager
 * All menus are administrated here
 */
/*
 * Option Pages
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page();
	acf_add_options_sub_page( 'Header' );
	acf_add_options_sub_page( 'Tracking Codes' );
	acf_add_options_sub_page( 'Website Settings' );
	acf_add_options_sub_page( 'Social Networks' );
	acf_add_options_sub_page( 'Footer' );
}

/*
 * Menu Locations
 */
register_nav_menus( array(
		'main_menu'   => __( 'Main menu', 'Main menu' ),
		/*'footer_menu'   => __( 'Footer menu', 'Footer menu' )*/
	)
);

/*
 * Fallback Menu
 */
if ( ! function_exists( 'blackhat_fallback_menu' ) ) {
	function blackhat_fallback_menu() {
	  $output = '<p class="fallback-menu-notice">';
	  $output .= __( 'Go to Admin > Appearance > Menus to create your menu and add it to desired Theme location.', 'am2' );
	  $output .= '</p>';
	  echo $output;
	}
}