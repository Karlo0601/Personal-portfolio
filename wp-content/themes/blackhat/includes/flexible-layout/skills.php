<?php
	/*
	* Skills block
	*/

class blackhat_Flexible_Layout_Render_skills {
	
	function __construct($field) {
		$this->field 		= $field;
		$this->field_name 	= 'skills';
	}

	function render() {
		global $block_position;
		$block_position ++;
		$context['block_position'] 	= $block_position;		
		$block = $this->field;
		
		$output = '';
		
		$context['skills_top_title']            = $block['skills_top_title'];
		$context['skills_title']                = $block['skills_title'];
		$context['skills_background_image']		= $block['skills_background_image'];
		$context['skills'] 		                = $block['skills'];

		$output .= Timber::compile( 'skills.twig', $context );
		return $output;

	}
}