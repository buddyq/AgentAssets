<<<<<<< HEAD
<<<<<<< HEAD
<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

class RevSliderBaseFront extends RevSliderBase {		
	
	const ACTION_ENQUEUE_SCRIPTS = "wp_enqueue_scripts";
	
	/**
	 * 
	 * main constructor		 
	 */
	public function __construct($t){
		
		parent::__construct($t);
		
		add_action('wp_enqueue_scripts', array('RevSliderFront', 'onAddScripts'));
	}	
	
}

/**
 * old classname extends new one (old classnames will be obsolete soon)
 * @since: 5.0
 **/
class UniteBaseFrontClassRev extends RevSliderBaseFront {}
=======
=======
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

class RevSliderBaseFront extends RevSliderBase {		
	
	const ACTION_ENQUEUE_SCRIPTS = "wp_enqueue_scripts";
	
	/**
	 * 
	 * main constructor		 
	 */
	public function __construct($t){
		
		parent::__construct($t);
		
		add_action('wp_enqueue_scripts', array('RevSliderFront', 'onAddScripts'));
	}	
	
}

/**
 * old classname extends new one (old classnames will be obsolete soon)
 * @since: 5.0
 **/
class UniteBaseFrontClassRev extends RevSliderBaseFront {}
<<<<<<< HEAD
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
=======
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
?>