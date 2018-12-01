<?php
/*
 * Assets manager
 * All assets ( styles and scripts ) are administrated here
 */

/*
 * All thumbnails are administrated here
 */
add_theme_support( 'post-thumbnails' );
add_image_size( 'slider', 1400, 450, true );
add_image_size( 'thumb-large', 320, 240, true );
/*
 * All scripts and styles are administrated here
 */
if ( ! function_exists( 'blackhat_enqueue_default_assets' ) ) {

	if ( ! is_admin() ) {
		add_action( 'wp_enqueue_scripts', 'blackhat_enqueue_default_assets' );
	}

	function blackhat_enqueue_default_assets() {
		global $env;

		//Main Theme CSS file
		if( 'development' === $env ) {
			wp_enqueue_style( 'style', blackhat_template_path . '/assets/css/style.css', array(), time(), null );
		} else {
			$dirCSS = new DirectoryIterator( get_stylesheet_directory() . '/assets/build/' ); // Target CSS Build Path
			foreach ($dirCSS as $file) {

				if ( pathinfo($file, PATHINFO_EXTENSION) === 'css' ) {
					$fullName = basename($file);
					$name = substr(basename($fullName), 0, strpos(basename($fullName), '.'));
					$deps = array('style');
					$media = 'all';

					wp_enqueue_style( $name, get_stylesheet_directory_uri() . '/assets/build/' . $fullName , array(), null );
				}
			}
		}
		
		//Use different jQuery version
		wp_deregister_script( 'jquery' );

		wp_register_script( 'jquery', blackhat_template_path . '/assets/js/jquery.min.js', null, null, false );
		wp_enqueue_script( 'jquery' );

		wp_register_script( 'toastr', blackhat_template_path . '/resources/js/toastr.js', null, null, false );
		wp_enqueue_script( 'toastr' );


		//Main Theme JS file
		if( 'development' === $env ) {
			wp_register_script( 'blackhat-functions', blackhat_template_path . '/resources/js/blackhat-core.js', null, null, true );
			wp_enqueue_script( 'blackhat-functions' );
			
			wp_register_script( 'functions', blackhat_template_path . '/resources/js/functions.js', null, null, true );
			wp_enqueue_script( 'functions' );
		} else {
			$dirJS = new DirectoryIterator( get_stylesheet_directory() . '/assets/build/' ); // Target JS Build Path
			foreach ($dirJS as $file) {
				if ( pathinfo($file, PATHINFO_EXTENSION) === 'js' ) {
					$fullName = basename($file);
					$name = substr(basename($fullName), 0, strpos(basename($fullName), '.'));
					$deps = array('style');
					$media = 'all';

					wp_register_script( $name, get_stylesheet_directory_uri() . '/assets/build/' . $fullName , null, null, true );
					wp_enqueue_script( $name );
				}
			}
		}

	}
	
}

/*
 *  Hook inline Javascript to head
 */
function blackhat_hook_javascript() {
    ?>
        <script>
            var blackhat = window.blackhat || {};
			blackhat.main = {};
			blackhat.functionsQueue = [];
			blackhat.adminAjax = '<?php echo admin_url('admin-ajax.php'); ?>';
			blackhat.ajax_nonce = '<?php echo wp_create_nonce( "security-nonce" ); ?>';
			blackhat.templateDirectory = '<?php echo blackhat_template_path; ?>';
        </script>
    <?php
}
add_action( 'wp_head', 'blackhat_hook_javascript' );

/*
 *  Enable svg images in media uploader
 */
function cc_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

/*
 *  Display svg images on media uploader and feature images
 */
function fix_svg_thumb_display() {
	echo '<style> td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail { width: 100% !important; height: auto !important; } </style>';
}
add_action('admin_head', 'fix_svg_thumb_display');

/*
 *  Disable WPCF7 styles
 */
if( function_exists( 'wpcf7_load_css' ) ) {
	add_filter( 'wpcf7_load_css', '__return_false' );
}

/*
 *  Add Google Maps API Key to ACF
 */
function blackhat_acf_google_map_api( $api ) {
	
	$api['key'] = get_field( 'google_maps_api_key', 'options' );
	
	return $api;
	
}
add_filter( 'acf/fields/google_map/api', 'blackhat_acf_google_map_api' );


//Global labels
function global_labels(){
	$labels = [ 
		'label_full_name'    		=> __('Full name', 'blackhat'),
		'label_email'    			=> __('Email address', 'blackhat'),
        'label_phone'    			=> __('Phone', 'blackhat'),
        'label_subject'       		=> __('Subject', 'blackhat'),
		'label_message'       		=> __('Message', 'blackhat'),
		'label_button_contact'      => __('Send Message', 'blackhat'),
		'label_success'				=> __('Thank you for getting in touch!','blackhat'),
		'label_error'				=> __('Please enter required fields.','blackhat'),
		'label_error_contact'		=> __('Greška! Molimo provjerite unesene podatke.','blackhat'),
	  ];
	return $labels;
}