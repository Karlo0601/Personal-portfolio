<?php
	/*
	* Hero image
	*/

class blackhat_Flexible_Layout_Render_hero_image {
	
	function __construct($field) {
		$this->field 		= $field;
		$this->field_name 	= 'hero_image';
	}

	function render() {
		global $block_position;
		$block_position ++;
		$context['block_position'] 	= $block_position;		
		$block = $this->field;
		
		$output = '';
		
		$context['hero_image_title'] 	= ( $block['hero_image_title'] ) ? $block['hero_image_title'] : get_the_title();
		$context['hero_image_subtitle'] 	= $block['hero_image_subtitle'];
		$context['button_label'] = $block['button_label'];
		$context['button_hover_label'] = $block['button_hover_label'];
		$context['button_link'] = $block['button_link'];
		$context['hero_image'] 	= $block['hero_image'];		

		$output .= Timber::compile( 'hero-image.twig', $context );
		return $output;

	}
}