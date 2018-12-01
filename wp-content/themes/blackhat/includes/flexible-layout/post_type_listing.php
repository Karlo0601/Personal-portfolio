<?php
	/*
	* Post type listing
	*/

class blackhat_Flexible_Layout_Render_post_type_listing {
	
	function __construct($field) {
		$this->field 		= $field;
		$this->field_name 	= 'post_type_listing';
	}

	function render() {
		global $block_position;
		$block_position ++;
		$context['block_position'] 	= $block_position;		
		$block = $this->field;
		
		$output = '';
		
		$context['post_type_title'] 	= $block['post_type_title'];
		$context['post_type_top_title']	= $block['post_type_top_title'];
		$number_of_posts 				= $block['posts_number'];
		$post_type						= $block['post_type'];

		$args = array(
			'post_type'              => $post_type,
			'post_status'            => array( 'publish' ),
			'posts_per_page'         => $number_of_posts,
			'order'                  => 'DESC',
			'orderby'                => 'date',
		);
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();

				$post_id = get_the_ID();
				if($post_type == 'projects'){
					$temp['post_images'] = get_field('project_images', $post_id);
					$temp['post_title'] = get_field('project_title', $post_id);
					$temp['post_description'] = get_field('project_description', $post_id);
					$temp['post_permalink'] = get_permalink($post_id);
				}elseif($post_type == 'post'){
					$temp['post_image'] = get_the_post_thumbnail_url( $post_id, 'full' );
					$temp['post_title'] = get_the_title( $post_id );
					$temp['post_date'] = get_the_date( $post_id );
					$temp['post_description'] = blackhat_excerpt(150, $post_id);
					$temp['post_permalink'] = get_permalink($post_id);
				}
				
				$context['posts'][] = $temp;
			}
			
		} else {
			$context['no_posts'] = __('More content coming soon.');
		}
		
		wp_reset_postdata();
		/* echo '<pre>';
		print_r($context);
		echo '</pre>'; */
		if($post_type == 'projects'){
			$output .= Timber::compile( 'projects-listing.twig', $context );
		}elseif($post_type == 'post'){
			$output .= Timber::compile( 'posts-listing.twig', $context );
		}
		
		return $output;

	}
}