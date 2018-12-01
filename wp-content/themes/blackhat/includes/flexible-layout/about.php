<?php
	/*
	* About block
	*/

class blackhat_Flexible_Layout_Render_about {
	
	function __construct($field) {
		$this->field 		= $field;
		$this->field_name 	= 'about';
	}

	function render() {
		global $block_position;
		$block_position ++;
		$context['block_position'] 	= $block_position;		
		$block = $this->field;
		
		$output = '';
		
		$context['about_top_title']             = $block['about_top_title'];
		$context['about_title']                 = $block['about_title'];
		$context['date_of_birth']               = $block['date_of_birth'];
		$context['language']                    = $block['language'];
		$context['expert_in']                   = $block['expert_in'];
		$context['phone'] 	                    = $block['phone'];		
        $context['email'] 	                    = $block['email'];
        $context['country_and_city'] 	        = $block['country_and_city'];
        $context['available'] 	                = $block['available'];
        $context['not_available_explanation'] 	= $block['not_available_explanation'];
        $context['image'] 	                    = $block['image'];

		$output .= Timber::compile( 'about.twig', $context );
		return $output;

	}
}