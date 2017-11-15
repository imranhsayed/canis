<?php

/**
 * Handles frontend
 */

class BLANK_THEME_Customizer_Front
{

	public function __construct() {

	}

	/**
	 * Generates all css
	 * @return css output
	 */
	public static function custom_css() {

		//Backgroud image and background color is handled by wordpress

		do_action( 'canis_customizer_custom_css' );
	}
}

new BLANK_THEME_Customizer_Front();
