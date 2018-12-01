<?php
function blackhat_handle_settings( $properties ) {
	if ( empty( $properties ) ) {
		return null;
	}

	$style = '';

	foreach ( $properties as $group ):
		foreach ( $group as $prop => $att ) :
			if ( empty( $att ) && $att != '0' ) {
				continue;
			}
			if ( $prop == 'acf_fc_layout' ) {
				continue;
			}
			if ( $prop == 'background_type' ) {
				continue;
			}
			if ( $prop == 'background-image' ) {
				$style .= $prop . ':url(' . $att . ');';
				continue;
			}
			if ( $prop == 'color' ) {
				$style .= 'color:' . $att . ' !important;';
				continue;
			}
			$px_fields = array( 'padding', 'margin', 'width', 'height', 'line-height', 'font-size' );
			foreach ( $px_fields as $px_field ):
				if ( strpos( $prop, $px_field ) !== false ) {
					$style .= $prop . ':' . $att . 'px;';
					continue 2;
				}
			endforeach;
			if ( strpos( $prop, '%' ) ) {
				$style .= str_replace( "%", "", $prop ) . ':' . $att . '%;';
				continue;
			}
			$style .= $prop . ':' . $att . ';';

		endforeach;
	endforeach;

	if ( ! empty( $style ) ) {
		$style = 'style="' . $style . '"';
	}

	return $style;
}

// Register the autoloader.
include( 'flexible-layout/autoloader.php' );
$autoload = new blackhat_Autoloader();
$autoload->register();

// Flexible Layout Class
class blackhat_Flexible_Layout {

	function __construct( $field, $is_flexible = true, $field_name = '' ) {
		$this->field 		= $field;
		$this->is_flexible 	= $is_flexible;
		$this->field_name 	= $field_name;
	}

	public function render() {
		global $block_position;
		$blocks = $this->field;
		// Count
		if ( empty( $block_position ) ) {
			$block_position = 0;
		}
		// Bail if empty
		if ( empty( $blocks ) ) {
			return null;
		}

		$output = '';

		if( $this->is_flexible ) :

			foreach ( $blocks as $block ):
				$block_position ++;
				$context                   = array();
				$context['block_position'] = $block_position;

				$class_name = 'blackhat_Flexible_Layout_Render_' . $block['acf_fc_layout'];
				if( class_exists( $class_name ) ) {
					$handle_block = new $class_name( $block );
					$output .= $handle_block->render();
				}

			endforeach;

		elseif( ! empty( $blocks[$this->field_name] ) ) :

			$blocks[$this->field_name] = $blocks;
			$class_name = 'blackhat_Flexible_Layout_Render_' . $this->field_name;
			if( class_exists( $class_name ) ) {
				$handle_block = new $class_name( $blocks );
				$output .= $handle_block->render();
			}

		endif;

		return $output;
	}
}

// Add Flexible layout to the_content()
add_filter( 'the_content', 'blackhat_flexible_layout' );
function blackhat_flexible_layout( $data ) {
	$name 		= 'flexible_content';
	$blocks 	= get_field( $name );
	$flexible 	= new blackhat_Flexible_Layout( $blocks );
	$output 	= $flexible->render();

	$data .= $output;

	return $data;
}