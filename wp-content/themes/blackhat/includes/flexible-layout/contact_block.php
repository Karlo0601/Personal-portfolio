<?php
	/*
	* Instagram feed
	*/

class blackhat_Flexible_Layout_Render_contact_block {
	
	function __construct($field) {
		$this->field 		= $field;
		$this->field_name 	= 'contact_block';
	}

	function render() {
		global $block_position;
		$block_position ++;
		$context['block_position'] 	= $block_position;		
		$block = $this->field;
		
        $output = '';
        
        $context['contact_top_title'] 	        = $block['contact_top_title'];
		$context['contact_title'] 	            = $block['contact_title'];
		$context['contact_background_image'] 	= $block['contact_form_background_image'];
		$context['labels']                		= global_labels();

		$output .= Timber::compile( 'contact-block.twig', $context );
		return $output;

	}
}