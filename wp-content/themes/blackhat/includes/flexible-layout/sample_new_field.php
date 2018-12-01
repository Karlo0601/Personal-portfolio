<?php
/**
 * Class loaded using SPL autoloader.
 */
/* 
NAMING:
file name needs to be named fieldname.php

SAMPLE 
class blackhat_Flexible_Layout_Render_fieldname {
	
	function __construct($field) { 
		$this->field = $field;
		$this->field_name = 'fieldname';
	}

	function render() {

		global $block_position;
		$block_position ++;
		$context['block_position'] = $block_position;

		$block = $this->field;
		//This is support for acf-reusable-field-groups addon
		if(!empty($this->field[$this->field_name])) {
			$block = $this->field[$this->field_name];
		}
		
		if ( empty( $block['fieldname'] ) ) {
			break;
		}

		// PUT BLOCK LOGIC HERE
		
		return $output;

	}
}
*/

