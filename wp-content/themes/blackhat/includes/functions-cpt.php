<?php
/*
 * CPT manager
 * All CPTs ( custom post types ) are administrated here
 */
add_action( 'init', 'blackhat_cpt' );

function blackhat_cpt() {

	$labels = array(
		'name'               => _x( 'Projects', 'post type general name' ),
		'singular_name'      => _x( 'Project', 'post type singular name' ),
		'add_new'            => _x( 'Add Project', 'Services' ),
		'add_new_item'       => __( 'Add Project' ),
		'edit_item'          => __( 'Edit Project' ),
		'new_item'           => __( 'New Project' ),
		'view_item'          => __( 'View Project' ),
		'search_items'       => __( 'Search Projects' ),
		'not_found'          => __( 'No Projects found' ),
		'not_found_in_trash' => __( 'No Projects found in the trash' ),
		'parent_item_colon'  => '',
		'show_in_nav_menus'  => true
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'query_var'          => true,
		'has_archive'        => false,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'author', 'excerpt', 'thumbnail', 'page-attributes' ),
		'taxonomies'         => array( '' )
	);

	register_post_type( 'projects', $args );
}


//Register Players position taxonomy
function project_tags() {
	
	$labels = array(
		'name'                       => _x( 'Tags', 'Taxonomy General Name', 'blackhat' ),
		'singular_name'              => _x( 'Tag', 'Taxonomy Singular Name', 'blackhat' ),
		'menu_name'                  => __( 'Tags', 'blackhat' ),
		'all_items'                  => __( 'All Items', 'blackhat' ),
		'parent_item'                => __( 'Parent Item', 'blackhat' ),
		'parent_item_colon'          => __( 'Parent Item:', 'blackhat' ),
		'new_item_name'              => __( 'New Item Name', 'blackhat' ),
		'add_new_item'               => __( 'Add New Item', 'blackhat' ),
		'edit_item'                  => __( 'Edit Item', 'blackhat' ),
		'update_item'                => __( 'Update Item', 'blackhat' ),
		'view_item'                  => __( 'View Item', 'blackhat' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'blackhat' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'blackhat' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'blackhat' ),
		'popular_items'              => __( 'Popular Items', 'blackhat' ),
		'search_items'               => __( 'Search Items', 'blackhat' ),
		'not_found'                  => __( 'Not Found', 'blackhat' ),
		'no_terms'                   => __( 'No items', 'blackhat' ),
		'items_list'                 => __( 'Items list', 'blackhat' ),
		'items_list_navigation'      => __( 'Items list navigation', 'blackhat' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite' 		=> array('slug' => 'project-tags'),
	);
	register_taxonomy( 'project_tags', array( 'projects' ), $args );

}
add_action( 'init', 'project_tags', 0 );
/*
 * Taxonomy manager
 * All taxonomies are administrated here
 */
function blackhat_taxonomy_init() {
	register_taxonomy(
		'taxonomy',
		'services',
		array(
			'label'        => __( 'Taxonomy' ),
			'rewrite'      => array( 'slug' => 'taxonomy' ),
			'capabilities' => array()
		)
	);
}
/*
add_action( 'init', 'blackhat_taxonomy_init' );
*/

?>