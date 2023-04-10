<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Image_File_Type_In_Woocommerce_Admin_Table_Settings
 *
 * This class contains all of the plugin settings.
 * Here you can configure the whole plugin data.
 *
 * @package		IMAGEFILET
 * @subpackage	Classes/Image_File_Type_In_Woocommerce_Admin_Table_Settings
 * @author		George Nicolaou
 * @since		1.0.0
 */
class Image_File_Type_In_Woocommerce_Admin_Table_Settings{

	/**
	 * The plugin name
	 *
	 * @var		string
	 * @since   1.0.0
	 */
	private $plugin_name;

	/**
	 * Our Image_File_Type_In_Woocommerce_Admin_Table_Settings constructor 
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct(){

		$this->plugin_name = IMAGEFILET_NAME;
	}

	/**
	 * ######################
	 * ###
	 * #### CALLABLE FUNCTIONS
	 * ###
	 * ######################
	 */

	/**
	 * Return the plugin name
	 *
	 * @access	public
	 * @since	1.0.0
	 * @return	string The plugin name
	 */
	public function get_plugin_name(){
		return apply_filters( 'IMAGEFILET/settings/get_plugin_name', $this->plugin_name );
	}
}
