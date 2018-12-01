<?php
/* BlackHat Image function */
function blackhat_image( $args ) {

	if ( empty( $args['dummy_width'] ) || empty( $args['dummy_height'] ) ) {
		return false;
	}
	if ( empty( $args['image_size'] ) ) {
		$args['image_size'] = 'medium';
	}
	if ( empty( $args['return'] ) ) {
		$args['return'] = 'class';
	}
	if ( empty( $args['alt'] ) ) {
		$args['alt'] = get_post_meta( $args['image_id'], '_wp_attachment_image_alt', true );
	}

	$image_class   = null;
	$article_image = null;
	$html          = '';
	$article_image = wp_get_attachment_image_src( $args['image_id'], $args['image_size'] );

	if ( empty( $article_image ) ) {
		$article_image[0] = get_stylesheet_directory_uri() . '/assets/images/no-image.png';
		$article_image[1] = 300;
		$article_image[2] = 200;
	}

	$dummy_ratio         = $args['dummy_width'] / $args['dummy_height'];
	$article_image_ratio = $article_image[1] / $article_image[2];

	if ( $article_image_ratio > $dummy_ratio ) {
		$image_class = 'taller';
	} else {
		$image_class = 'wider';
	}

	//RETURNING HTML OR CSS CLASS
	if ( $args['return'] == 'class' ) {
		return $image_class;
	} elseif ( $args['return'] == 'html' ) {
		$html .= '<img src="data:image/png;base64,'.blackhat_generate_base64_dummy( $args['dummy_width'], $args['dummy_height'] ).'" class="dummy" width="' . $args['dummy_width'] . '" height="' . $args['dummy_height'] . '" alt="" /><img src="' . $article_image[0] . '" class="real_img ' . $image_class . '" alt="' . $args['alt'] . '" width="' . $args['dummy_width'] . '" height="' . $args['dummy_height'] . '" />';

		return $html;
	}

	return null;

}

/* Generates base64 encoded dummy image */
function blackhat_generate_base64_dummy( $width, $height ) {

	$new_dummy = imagecreatetruecolor($width, $height);
	imageAlphaBlending($new_dummy, false);
	imageSaveAlpha($new_dummy, true);
	$dummy_source = imagecreatefrompng( realpath(dirname(__FILE__) . '/../assets/images/dummy-source.png') );
	imagecopyresampled($new_dummy, $dummy_source, 0, 0, 0, 0, $width, $height, 10, 10);
	
	ob_start();
	imagepng($new_dummy);
	$imagedata = ob_get_clean();
	
	return base64_encode($imagedata);

}

/* Generates social networks icon links */
function blackhat_social_links( $container_css_class_modifier = "" ) {
	$output = "";
	$socials = array();

	$facebook = get_field( 'facebook', 'options' );
	$github = get_field( 'github', 'options' );
	$codepen = get_field( 'codepen', 'options' );
    $twitter = get_field( 'twitter', 'options' );
    $instagram = get_field( 'instagram', 'options' );
    $linkedin = get_field( 'linkedin', 'options' );
    $snapchat = get_field( 'snapchat', 'options' );
    $googleplus = get_field( 'googleplus', 'options' );
    $pinterest = get_field( 'pinterest', 'options' );
    $youtube = get_field( 'youtube', 'options' );

    if( !empty( $facebook ) ) {
        $socials['facebook'] = $facebook;
	}
	if( !empty( $github ) ) {
        $socials['github'] = $github;
	}
	if( !empty( $codepen ) ) {
        $socials['codepen'] = $codepen;
    }
    if( !empty( $instagram ) ) {
        $socials['instagram'] = $instagram;
    }
    if( !empty( $twitter ) ) {
        $socials['twitter'] = $twitter;
    }
	if( !empty( $linkedin ) ) {
        $socials['linkedin'] = $linkedin;
    }
    if( !empty( $snapchat ) ) {
        $socials['snapchat'] = $snapchat;
    }
    if( !empty( $googleplus ) ) {
        $socials['googleplus'] = $googleplus;
    }
    if( !empty( $pinterest ) ) {
        $socials['pinterest'] = $pinterest;
    }
    if( !empty( $youtube ) ) {
        $socials['youtube'] = $youtube;
    }

    if( !empty( $socials ) ) {
        $output .= '<ul class="social ' . $container_css_class_modifier . ' clearfix">';

	        foreach( $socials as $key => $value ) {

	            $output .= '<li class="social__item social__item--' . $key . '">
	                    <a href="' . $value . '" target="_blank">
	                    	<span class="social__icon social__icon--' . $key . '">
	                    		<svg class="social--' . $key . '">
	                                <use xlink:href="' . get_stylesheet_directory_uri() . '/assets/images/sprite.svg#social--' . $key . '"></use>
	                            </svg>
	                    	</span>
	                    </a> 
	                </li>';

	        }

        $output .= '</ul>';
    }

    return $output;
}

?>