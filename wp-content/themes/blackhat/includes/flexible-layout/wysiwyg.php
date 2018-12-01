<?php
/*
 * WYSIWYG
 */
 class blackhat_Flexible_Layout_Render_wysiwyg {

	function __construct($field) {
		$this->field 		= $field;
		$this->field_name 	= 'wysiwyg';
	}

	function render() {
		global $block_position;
		$block_position ++;
		$block = $this->field;

		$output = '';

		if ( empty( $block['wysiwyg'] ) ) {
			return;
		}

		$context['block_position'] = $block_position;
		$context['content'] = $block['wysiwyg'];
		$context['column'] = 'col-1';

		$output .= Timber::compile( 'wysiwyg.twig', $context );
		return $output;

	}
}