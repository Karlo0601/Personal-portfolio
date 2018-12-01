<?php
	/*
	* Instagram feed
	*/

class blackhat_Flexible_Layout_Render_cta {
	
	function __construct($field) {
		$this->field 		= $field;
		$this->field_name 	= 'cta';
	}

	function render() {
		global $block_position;
		$block_position ++;
		$context['block_position'] 	= $block_position;		
		$block = $this->field;
		
        $output = '';
        
		$context['cta_title'] 	        	= $block['cta_title'];
		$context['cta_description'] 	    = $block['cta_description'];
		$context['cta_button_label'] 	    = $block['cta_button_label'];
		$context['cta_button_link'] 	    = $block['cta_button_link'];
		$context['cta_background_image'] 	= $block['cta_background_image'];

		$output .= Timber::compile( 'cta.twig', $context );
		return $output;

	}
}