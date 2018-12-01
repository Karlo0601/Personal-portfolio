<?php

register_sidebar( array(
	'id'          => 'before-footer',
	'name'        => 'Before Footer Widget',
	'description' => __( 'Your Widget Description.', 'am2studio' ),
	'before_widget' => '<div id="%1$s" class="widget col-13 %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h4>',
	'after_title'   => '</h4>'
) );

function wpb_load_widget() {
	register_widget( 'map_locations' );
	register_widget( 'social_widget' );
	register_widget( 'quick_links' );
}
add_action( 'widgets_init', 'wpb_load_widget' );
// Creating the widget 
class map_locations extends WP_Widget {
 
	function __construct() {
	parent::__construct(
	 
	// Base ID of your widget
	'map_locations', 
	 
	// Widget name will appear in UI
	__('Map location', 'am2studio'), 
	 
	// Widget description
	array( 'description' => __( 'Add google map locations widget to your website page', 'wpb_widget_domain' ), ) 
	);
	}
	 
	// Creating widget front-end
	 
	public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	$image = get_field('location_image', 'widget_'.$args['widget_id']);
	$map_location = get_field('map_location', 'widget_'.$args['widget_id']);

	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	if ( ! empty( $title ) )
		?>
		<div class="col-sm-7">
			<div class="location-box">
				<div class="photo-box">
					<?php if($image){ ?>
					<div class="photo">
						<img src="<?php echo $image['url']; ?>" alt="image">
					</div><!-- end photo -->
					<?php } ?>
					<a id="open-fancybox-map" data-fancybox href="https://www.google.com/maps/search/?api=1&query=<?php echo $map_location['lat']; ?>,<?php echo $map_location['lng']; ?>" data-widget-id="<?php echo $args['widget_id']; ?>"  class="btn btn-md btn-primary">View map</a>
					<div id="google-maps-<?php echo $args['widget_id']; ?>"></div>
				</div><!-- end photo-box -->
				<?php if($title){ ?>
					<h4><?php echo $title; ?></h4>
				<?php } ?>
				<?php if($map_location['address']){ ?>
					<address>
						<span><?php echo $map_location['address']; ?></span>
					</address>
				<?php } ?>
			</div><!-- end location-box -->
		</div>
		<?php
		echo $args['after_widget'];
		
	}
			 
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Location title', 'am2studio' );
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
	<?php 
	}
		 
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
	
}
class quick_links extends WP_Widget {
 
	function __construct() {
	parent::__construct(
	 
	// Base ID of your widget
	'quick_links', 
	 
	// Widget name will appear in UI
	__('Quick links', 'am2studio'), 
	 
	// Widget description
	array( 'description' => __( 'Add Quick links widget to your website page', 'wpb_widget_domain' ), ) 
	);
	}
	 
	// Creating widget front-end
	 
	public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	$links = get_field('links', 'widget_'.$args['widget_id']);
	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	if ( ! empty( $title ) )
		?>
		<div class="col-sm-5">
			<h4><?php echo $title; ?></h4>
			<ul class="footer-links">
				<?php foreach($links as $link){
					echo '<li><a href="'. $link['link_url'] .'">'. $link['link_label'] .'</a></li>';
				} ?>
			</ul><!-- end footer-links -->
		</div>
		<?php
		echo $args['after_widget'];
		
	}
			 
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Quick links', 'am2studio' );
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
	<?php 
	}
		 
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
	
}
class social_widget extends WP_Widget {
 
	function __construct() {
	parent::__construct(
	 
	// Base ID of your widget
	'social_widget', 
	 
	// Widget name will appear in UI
	__('Social Widget', 'am2studio'), 
	 
	// Widget description
	array( 'description' => __( 'Add Social Network widget widget to your website page', 'am2studio' ), ) 
	);
	}
	 
	// Creating widget front-end
	 
	public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	$facebook = get_theme_mod( 'am2_facebook_network' );
    $twitter = get_theme_mod( 'am2_twitter_network' );
    $instagram = get_theme_mod( 'am2_instagram_network' );
    $linkedin = get_theme_mod( 'am2_linkedin_network' );
    $googleplus = get_theme_mod( 'am2_googleplus_network' );
    $pinterest = get_theme_mod( 'am2_facebook_network' );
	$youtube = get_theme_mod( 'am2_youtube_network' );
	$email = get_theme_mod( 'am2_email_network' );

    
	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	if ( ! empty( $title ) )
		?>
		<div class="col-md-3">
			<div class="social-block">
				<h4><?php echo $title; ?></h4>
				<ul class="social-list">
					<?php
						if( !empty( $facebook ) ) {
							echo '<li><a href="'. $facebook .'" class="facebook">facebook</a></li>';
						}
						if( !empty( $instagram ) ) {
							echo '<li><a href="'. $instagram .'" class="instagram">instagram</a></li>';
						}
						if( !empty( $twitter ) ) {
							echo '<li><a href="'. $twitter .'" class="twitter">twitter</a></li>';
						}
						if( !empty( $linkedin ) ) {
							echo '<li><a href="'. $linkedin .'" class="linkedin">linkedin</a></li>';
						}
						if( !empty( $youtube ) ) {
							echo '<li><a href="'. $youtube .'" class="youtube">youtube</a></li>';
						}
						if( !empty( $email ) ) {
							echo '<li><a href="mailto:'. $email .'" class="email">email</a></li>';
						}
					?>
				</ul><!-- end social-list -->
			</div><!-- end social-block -->
		</div>
		<?php
		echo $args['after_widget'];
		
	}
			 
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Social networks title', 'am2studio' );
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
	<?php 
	}
		 
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
	
}
//Customizer social feed
function am2_theme_customizer( $wp_customize ) {

	//Theme options
  
 	$wp_customize->add_panel( 'am2_theme_options' , array(
        'title'       => __( 'Social feed options', 'am2studio' ),
        'priority'    => 40,
        'capability'     => 'edit_theme_options',
        'description' => 'Edit API for social feeds',
    ) );

    //Logo
	$wp_customize->add_section( 'am2_socials_section' , array(
		'title'       => __( 'Social Networks', 'am2studio' ),
		'priority'    => 20,
		'description' => 'Upload a logo to replace the default site name and description in the header',
	) );

	$wp_customize->add_setting( 'am2_facebook_api' );

	$wp_customize->add_control('am2_facebook_api', array(
		'label'   => 'Facebook API',
		'section' => 'am2_socials_section',
		'type'    => 'text',
	));
	$wp_customize->add_setting( 'am2_facebook_secret' );
	$wp_customize->add_control('am2_facebook_secret', array(
		'label'   => 'Facebook Secret ID',
		'section' => 'am2_socials_section',
		'type'    => 'text',
	));

	$wp_customize->add_setting( 'am2_instagram_api_url' );
	$wp_customize->add_control('am2_instagram_api_url', array(
		'label'   => 'Instagram API url',
		'section' => 'am2_socials_section',
		'type'    => 'text',
	));

	$wp_customize->add_setting( 'am2_twitter_oauth_access_token' );
	$wp_customize->add_control('am2_twitter_oauth_access_token', array(
		'label'   => 'Twitter oauth access token',
		'section' => 'am2_socials_section',
		'type'    => 'text',
	));
	$wp_customize->add_setting( 'am2_oauth_access_token_secret' );
	$wp_customize->add_control('am2_oauth_access_token_secret', array(
		'label'   => 'Twitter oauth access token secret',
		'section' => 'am2_socials_section',
		'type'    => 'text',
	));
	$wp_customize->add_setting( 'am2_consumer_key' );
	$wp_customize->add_control('am2_consumer_key', array(
		'label'   => 'Twitter consumer key',
		'section' => 'am2_socials_section',
		'type'    => 'text',
	));
	$wp_customize->add_setting( 'am2_consumer_secret' );
	$wp_customize->add_control('am2_consumer_secret', array(
		'label'   => 'Twitter consumer secret',
		'section' => 'am2_socials_section',
		'type'    => 'text',
	));
	$wp_customize->add_setting( 'am2_screen_name' );
	$wp_customize->add_control('am2_screen_name', array(
		'label'   => 'Twitter screen name',
		'section' => 'am2_socials_section',
		'type'    => 'text',
	));

	$wp_customize->add_setting( 'am2_linkedin_client_id' );
	$wp_customize->add_control('am2_linkedin_client_id', array(
		'label'   => 'LinkedIn Client ID',
		'section' => 'am2_socials_section',
		'type'    => 'text',
	));

	$wp_customize->add_setting( 'am2_linkedin_client_secret' );
	$wp_customize->add_control('am2_linkedin_client_secret', array(
		'label'   => 'LinkedIn Client Secret',
		'section' => 'am2_socials_section',
		'type'    => 'text',
	));

	$wp_customize->add_setting( 'am2_youtube_api' );
	$wp_customize->add_control('am2_youtube_api', array(
		'label'   => 'Youtube API Key',
		'section' => 'am2_socials_section',
		'type'    => 'text',
	));
	$wp_customize->add_setting( 'am2_playerlist_id' );
	$wp_customize->add_control('am2_playerlist_id', array(
		'label'   => 'Youtube Playerlist ID',
		'section' => 'am2_socials_section',
		'type'    => 'text',
	));


//Social networks
	$wp_customize->add_panel( 'am2_social_network_options' , array(
		'title'       => __( 'Social Networks options', 'am2studio' ),
		'priority'    => 40,
		'capability'     => 'edit_theme_options',
		'description' => 'Edit social networks',
	) );
	
	$wp_customize->add_section( 'am2_social_network_section' , array(
		'title'       => __( 'Social Networks', 'am2studio' ),
		'priority'    => 20,
		'description' => 'Upload a logo to replace the default site name and description in the header',
	) );
	
	$wp_customize->add_setting( 'am2_facebook_network' );
	
	$wp_customize->add_control('am2_facebook_network', array(
		'label'   => 'Facebook',
		'section' => 'am2_social_network_section',
		'type'    => 'text',
	));
	$wp_customize->add_setting( 'am2_twitter_network' );
	$wp_customize->add_control('am2_twitter_network', array(
		'label'   => 'Twitter',
		'section' => 'am2_social_network_section',
		'type'    => 'text',
	));
	
	$wp_customize->add_setting( 'am2_instagram_network' );
	$wp_customize->add_control('am2_instagram_network', array(
		'label'   => 'Instagram',
		'section' => 'am2_social_network_section',
		'type'    => 'text',
	));
	
	$wp_customize->add_setting( 'am2_linkedin_network' );
	$wp_customize->add_control('am2_linkedin_network', array(
		'label'   => 'Linkedin',
		'section' => 'am2_social_network_section',
		'type'    => 'text',
	));
	$wp_customize->add_setting( 'am2_googleplus_network' );
	$wp_customize->add_control('am2_googleplus_network', array(
		'label'   => 'Google+',
		'section' => 'am2_social_network_section',
		'type'    => 'text',
	));
	$wp_customize->add_setting( 'am2_youtube_network' );
	$wp_customize->add_control('am2_youtube_network', array(
		'label'   => 'Youtube',
		'section' => 'am2_social_network_section',
		'type'    => 'text',
	));
	$wp_customize->add_setting( 'am2_email_network' );
	$wp_customize->add_control('am2_email_network', array(
		'label'   => 'E-mail',
		'section' => 'am2_social_network_section',
		'type'    => 'text',
	));
		
}
add_action( 'customize_register', 'am2_theme_customizer' );


/**
* Builds a navigation menu based on parent post, children and siblings
*/
function get_secondary_nav($post_type, $current_term) {
	global $post, $wpdb;

	if(!empty($post->post_type)){
		$post_type = $post->post_type;
	}elseif(empty($post_type)){
		$post_type = $post_type;
	}
	if(!empty($post->ID)){
		$current = $post->ID;
	}
	$post_type_name = get_post_type_object( $post_type )->labels->name;
	
	$top_title = get_the_title( $current );

	$string  = '<div class="col-md-3 hidden-sm hidden-xs"><aside class="sidebar"><nav class="secondary-nav appear animate-up opacity">';
	if ( is_page() ) {
		$parent = array_reverse( get_post_ancestors( $current ) );

		if ( isset( $parent[0] ) ) {
			$first_parent = get_post( $parent[0] );
			$parent_id = $first_parent->ID;
		} else {
			$parent_id = $current;
		}

		$top_title = get_the_title( $parent_id );

		if ( $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_parent = '$parent_id' AND post_status != 'attachment'" ) ) {
			$childpages = wp_list_pages( 'sort_column=menu_order&echo=0&title_li=&child_of=' . $parent_id );

			$string .= '  <ul>';
			$string .= 		$childpages;
			$string .= '  </ul>';
		}
	}elseif ( is_single() ) {
		//$nav_title = '  <h3>Recent ' . $post_type_name . '</h3>';
		$ppp = get_option( 'posts_per_page' );
		$rp_args = [
			'post_type'   => $post_type,
			'exclude'     => [ $current ],
			'numberposts' => $ppp,
			'post_status' => 'publish',
		];
		if ( 'vacancies' === $post_type ) {
			$rp_args['meta_key'] = 'closing_date';
			$rp_args['meta_query'] = [
				[
					'key'     => 'closing_date',
					'value'   => time(),
					'compare' => '>=',
				],
			];
		} elseif ( 'events' === $post_type ) {
			//$nav_title = '  <h3>Upcoming Events</h3>';
			$rp_args['meta_key'] = 'event_start';
			$rp_args['meta_query'] = [
				[
					'key'     => 'event_start',
					'value'   => time(),
					'compare' => '>=',
					'type'    => 'TIME',
				],
			];
		} elseif ( 'team' === $post_type ) {
			//$nav_title  = '  <h3>Other Team Members</h3>';
			$terms      = get_the_terms( $current, 'team_category' );
			if ( ! empty( $terms ) ) {
				$term_ids   = wp_list_pluck( $terms, 'term_id' );
				$rp_args['tax_query'] = [
					[
						'taxonomy'  => 'team_category',
						'field'     => 'term_id',
						'terms'     => $term_ids,
					],
				];
			}
		} elseif ( 'case_study' === $post_type ) {
			//$nav_title  = '  <h3>Recent stories</h3>';
		}

		$rp_args    = apply_filters( 'fabric_secondary_nav_post_args_' . $post_type, $rp_args );
		$rp_args    = apply_filters( 'fabric_secondary_nav_post_args', $rp_args, $post_type );
		$siblings   = wp_get_recent_posts( $rp_args );
		$string .= '  <ul>';
		$string .= '    <li class="current_page_item">';
		$string .= '      <a href="' . get_permalink( $current ) . '">' . $top_title . '</a>';
		$string .= '    </li>';
		if ( ! empty( $siblings ) ) {
			$string .= '<ul>';
			foreach ( $siblings as $sibling ) {
				$string .= '    <li>';
				$string .= '      <a href="' . get_permalink( $sibling['ID'] ) . '">' . $sibling['post_title'] . '</a>';
				$string .= '    </li>';
			}
			$string .= '</ul>';
		}
		$string .= '  </ul>';
	}elseif ( is_home() ) {
		$siblings = wp_get_recent_posts( ['numberposts' => get_option( 'posts_per_page' ), 'post_status' => 'publish'] );

		//$string .= '  <h3>Recent ' . $post_type_name . '</h3>';
		$string .= '  <ul>';
		foreach ( $siblings as $sibling ) {
			$string .= '    <li>';
			$string .= '      <a href="' . get_permalink( $sibling['ID'] ) . '">' . $sibling['post_title'] . '</a>';
			$string .= '    </li>';
		}
		$string .= '  </ul>';
	} elseif ( is_tax() ) {
		$siblings = wp_get_recent_posts( ['numberposts' => get_option( 'posts_per_page' ), 'post_type' => $post_type, 'post_status' => 'publish'] );

		//$string .= '  <h3>Recent ' . $post_type_name . '</h3>';
		$string .= '  <ul>';
		foreach ( $siblings as $sibling ) {
			$string .= '    <li>';
			$string .= '      <a href="' . get_permalink( $sibling['ID'] ) . '">' . $sibling['post_title'] . 'is_tax</a>';
			$string .= '    </li>';
		}
		$string .= '  </ul>';
		if($post_type == 'case_study'){
			$taxonomy = 'case_study_category';
		}elseif($post_type == 'events'){
			$taxonomy = 'events_category';
		}elseif($post_type == 'news'){
			$taxonomy = 'news_category';
		}elseif($post_type == 'vacancies'){
			$taxonomy = 'vacancies_category';
		}
		
		$terms = get_terms($taxonomy);
		$string .= '  <ul>';
		foreach ( $terms as $term ) {
			if ($term->parent == 0){
				$string .= '<li>';
					$string .= '<a href="'.get_term_link($term->slug, $taxonomy) .'">'. $term->name .'</a>';
					if(!empty($post_type)){
						$args = array(
							'post_type'             => array( $post_type ),
							'posts_per_page'        => -1,
							'order'                 => 'DESC',
							'orderby'               => 'date',
							'tax_query' => array(
								array(
								'taxonomy'  => $taxonomy,
								'field'     => 'id',
								'terms'     => array($term->term_id)
							)),
							'meta_key'		=> 'featured',
							'meta_value'	=> '1'
						);
						
						$query = new WP_Query( $args );
						if ( $query->have_posts() ) {
							$string .= '<ul>';
							while ( $query->have_posts() ) {
								$query->the_post();
								$string .= '<li><a href="'. get_permalink( $post->ID ) .'">'. get_the_title( $post->ID ) .'</a></li>';
							}
							$string .= '</ul>';
						}else {

						}
						wp_reset_postdata();
					}
					$term_children = get_term_children( $term->term_id, $taxonomy );
					
					if(!empty($term_children)){
						$string .= '<ul>';
						foreach ( $term_children as $child ) {
							$first_term = get_term_by( 'id', $child, $taxonomy );
							if ($first_term->parent == $term->term_id){		
								$string .= '<li>';
								$string .= '<a href="' . get_term_link( $child, $taxonomy ) . '">' . $first_term->name . '</a>';
								if(!empty($post_type)){
									$args = array(
										'post_type'             => array( $post_type ),
										'posts_per_page'        => -1,
										'order'                 => 'DESC',
										'orderby'               => 'date',
										'tax_query' => array(
											array(
											'taxonomy'  => $taxonomy,
											'field'     => 'id',
											'terms'     => array($first_term->term_id)
										)),
										'meta_key'		=> 'featured',
										'meta_value'	=> '1'
									);
									
									$query = new WP_Query( $args );
									if ( $query->have_posts() ) {
										$string .= '  <ul>';
										while ( $query->have_posts() ) {
											$query->the_post();
											$string .= '<li><a href="'. get_permalink( $post->ID ) .'">'. get_the_title( $post->ID ) .'</a></li>';
										}
										$string .= '  </ul>';
									}else {
				
									}
									wp_reset_postdata();
								}
								$term_second_children = get_term_children( $child, $taxonomy );
					
								if(!empty($term_second_children)){
									$string .= '<ul>';
									foreach ( $term_second_children as $second_child ) {
										$first_term = get_term_by( 'id', $second_child, $taxonomy );
										if ($first_term->parent == $child){		
											$string .= '<li>';
											$string .= '<a href="' . get_term_link( $second_child, $taxonomy ) . '">' . $first_term->name . '</a>';

											if(!empty($post_type)){
												$args = array(
													'post_type'             => array( $post_type ),
													'posts_per_page'        => -1,
													'order'                 => 'DESC',
													'orderby'               => 'date',
													'tax_query' => array(
														array(
														'taxonomy'  => $taxonomy,
														'field'     => 'id',
														'terms'     => array($second_child)
													)),
													'meta_key'		=> 'featured',
													'meta_value'	=> '1'
												);
												
												$query = new WP_Query( $args );
												if ( $query->have_posts() ) {
													$string .= '  <ul>';
													while ( $query->have_posts() ) {
														$query->the_post();
														$string .= '<li><a href="'. get_permalink( $post->ID ) .'">'. get_the_title( $post->ID ) .'</a></li>';
													}
													$string .= '  </ul>';
												}else {

												}
												wp_reset_postdata();
											} 
											$string .= '</li>';
										}
									}
									$string .= '</ul>';
								}
								$string .= '</li>';
							}
						}
						$string .= '</ul>';
					}
				$string .= '</li>';
			}
			
		}
		$string .= '  </ul>';
	}elseif ( is_post_type_archive() ) {

		if($post_type == 'case_study'){
			$taxonomy = 'case_study_category';
		}elseif($post_type == 'events'){
			$taxonomy = 'events_category';
		}elseif($post_type == 'news'){
			$taxonomy = 'news_category';
		}elseif($post_type == 'vacancies'){
			$taxonomy = 'vacancies_category';
		}
		
		$terms = get_terms($taxonomy);
		$string .= '  <ul>';
		foreach ( $terms as $term ) {
			if ($term->parent == 0){
				$string .= '<li>';
					$string .= '<a href="'.get_term_link($term->slug, $taxonomy) .'">'. $term->name .'</a>';
					if(!empty($post_type)){
						$args = array(
							'post_type'             => array( $post_type ),
							'posts_per_page'        => -1,
							'order'                 => 'DESC',
							'orderby'               => 'date',
							'tax_query' => array(
								array(
								'taxonomy'  => $taxonomy,
								'field'     => 'id',
								'terms'     => array($term->term_id)
							)),
							'meta_key'		=> 'featured',
							'meta_value'	=> '1'
						);
						
						$query = new WP_Query( $args );
						if ( $query->have_posts() ) {
							$string .= '<ul>';
							while ( $query->have_posts() ) {
								$query->the_post();
								$string .= '<li><a href="'. get_permalink( $post->ID ) .'">'. get_the_title( $post->ID ) .'</a></li>';
							}
							$string .= '</ul>';
						}else {

						}
						wp_reset_postdata();
					}
					$term_children = get_term_children( $term->term_id, $taxonomy );
					
					if(!empty($term_children)){
						$string .= '<ul>';
						foreach ( $term_children as $child ) {
							$first_term = get_term_by( 'id', $child, $taxonomy );
							if ($first_term->parent == $term->term_id){		
								$string .= '<li>';
								$string .= '<a href="' . get_term_link( $child, $taxonomy ) . '">' . $first_term->name . '</a>';
								if(!empty($post_type)){
									$args = array(
										'post_type'             => array( $post_type ),
										'posts_per_page'        => -1,
										'order'                 => 'DESC',
										'orderby'               => 'date',
										'tax_query' => array(
											array(
											'taxonomy'  => $taxonomy,
											'field'     => 'id',
											'terms'     => array($first_term->term_id)
										)),
										'meta_key'		=> 'featured',
										'meta_value'	=> '1'
									);
									
									$query = new WP_Query( $args );
									if ( $query->have_posts() ) {
										$string .= '  <ul>';
										while ( $query->have_posts() ) {
											$query->the_post();
											$string .= '<li><a href="'. get_permalink( $post->ID ) .'">'. get_the_title( $post->ID ) .'</a></li>';
										}
										$string .= '  </ul>';
									}else {
				
									}
									wp_reset_postdata();
								}
								$term_second_children = get_term_children( $child, $taxonomy );
					
								if(!empty($term_second_children)){
									$string .= '<ul>';
									foreach ( $term_second_children as $second_child ) {
										$first_term = get_term_by( 'id', $second_child, $taxonomy );
										if ($first_term->parent == $child){		
											$string .= '<li>';
											$string .= '<a href="' . get_term_link( $second_child, $taxonomy ) . '">' . $first_term->name . '</a>';

											if(!empty($post_type)){
												$args = array(
													'post_type'             => array( $post_type ),
													'posts_per_page'        => -1,
													'order'                 => 'DESC',
													'orderby'               => 'date',
													'tax_query' => array(
														array(
														'taxonomy'  => $taxonomy,
														'field'     => 'id',
														'terms'     => array($second_child)
													)),
													'meta_key'		=> 'featured',
													'meta_value'	=> '1'
												);
												
												$query = new WP_Query( $args );
												if ( $query->have_posts() ) {
													$string .= '  <ul>';
													while ( $query->have_posts() ) {
														$query->the_post();
														$string .= '<li><a href="'. get_permalink( $post->ID ) .'">'. get_the_title( $post->ID ) .'</a></li>';
													}
													$string .= '  </ul>';
												}else {

												}
												wp_reset_postdata();
											} 
											$string .= '</li>';
										}
									}
									$string .= '</ul>';
								}
								$string .= '</li>';
							}
						}
						$string .= '</ul>';
					}
				$string .= '</li>';
			}
			
		}
		$string .= '  </ul>';
	}
	$string .= '</nav></aside></div>';
	echo $string;
}

/* if(!empty($post_type)){
	$args = array(
		'post_type'             => array( $post_type ),
		'posts_per_page'        => -1,
		'order'                 => 'DESC',
		'orderby'               => 'date',
		'tax_query' => array(
			array(
			'taxonomy'  => $taxonomy,
			'field'     => 'id',
			'terms'     => array($term->term_id)
		)),
	);
	$string .= '  <ul>';
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$is_featured = get_field('featured', $post->ID);
			if($is_featured){
				$string .= '<li><a href="'. get_permalink( $post->ID ) .'">'. get_the_title( $post->ID ) .'</a></li>';
			}
		}
	}else {

	}
	$string .= '  </ul>';
} */