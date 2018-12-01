<?php
	/*
	* Blog listing
	*/

class blackhat_Flexible_Layout_Render_blog_listing {
	
	function __construct($field) {
		$this->field 		= $field;
		$this->field_name 	= 'blog_listing';
	}

	function render() {
		global $block_position;
		$block_position ++;
		$context['block_position'] 	= $block_position;		
		$block = $this->field;
		
		$output = '';
		
		$context['blog_title'] 	= $block['blog_title'];
		$context['blog_top_title'] 	= $block['blog_top_title'];
		$number_of_posts = $block['number_of_posts'];

		$args = array(
			'post_type'              => array( 'post' ),
			'post_status'            => array( 'publish' ),
			'posts_per_page'         => $number_of_posts,
			'order'                  => 'DESC',
			'orderby'                => 'date',
		);
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				print_r($post);
				$post_id = get_the_ID();
				$temp['post_images'] = get_field('project_images', $post_id);
				$temp['post_title'] = get_the_title($post_id);
				$temp['post_description'] = blackhat_excerpt($post_id, 150);
				$temp['post_permalink'] = get_permalink($post_id);
				$temp['post_date'] = get_the_date('d.m.Y', $post_id);
				$context['blog'][] = $temp;
			}
			
		} else {

		}
		
		wp_reset_postdata();
		
		$output .= Timber::compile( 'blog-listing.twig', $context );
		return $output;

	}
}