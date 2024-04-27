<?php
/**
 * Translentor Website Translator.
 *
 * @package translentor-website-translator
 */

namespace Translentor\Modules\Translentor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if(
   get_option('manual_translation')=='yes' || 
   get_option('deepl_translation')=='yes')
{
	if(get_option('dropdown')=='yes'){
require_once plugin_dir_path( __FILE__ ) . 'widget/tanslentor_widget.php';
	}
}
if(get_option('google_translation')=='yes'){
	if(get_option('dropdown')=='yes'){
		require_once plugin_dir_path( __FILE__ ) . 'widget/tanslentor_widget.php';
	}
	if(get_option('popup')=='yes'){
		require_once plugin_dir_path(__FILE__).'widget/translentor_popup_model.php';
	}
	if(get_option('bottomsheet')=='yes'){
		require_once plugin_dir_path(__FILE__).'widget/translentor_bottom_sheet_footer.php';
	}

}

class Module
{

	/**
	 * Module should load or not.
	 *
	 * @since 1.20.0
	 * @access public
	 *
	 * @return bool true|false.
	 */
	public static function is_enabled() 
	{
		return true;
	}

	/**
	 * Constructor.
	 */
	public function __construct() 
	{ // phpcs:ignore Generic.CodeAnalysis.UselessOverridingMethod.Found
		//parent::__construct();
	}
}