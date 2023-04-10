<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Image_File_Type_In_Woocommerce_Admin_Table_Run
 *
 * Thats where we bring the plugin to life
 *
 * @package		IMAGEFILET
 * @subpackage	Classes/Image_File_Type_In_Woocommerce_Admin_Table_Run
 * @author		George Nicolaou
 * @since		1.0.0
 */
class Image_File_Type_In_Woocommerce_Admin_Table_Run{

	/**
	 * Our Image_File_Type_In_Woocommerce_Admin_Table_Run constructor 
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct(){
		$this->add_hooks();
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOKS
	 * ###
	 * ######################
	 */

	/**
	 * Registers all WordPress and plugin related hooks
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function add_hooks(){
	
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backend_scripts_and_styles' ), 20 );
	
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOK CALLBACKS
	 * ###
	 * ######################
	 */

	/**
	 * Enqueue the backend related scripts and styles for this plugin.
	 * All of the added scripts andstyles will be available on every page within the backend.
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function enqueue_backend_scripts_and_styles() {
		wp_enqueue_style( 'imagefilet-backend-styles', IMAGEFILET_PLUGIN_URL . 'core/includes/assets/css/backend-styles.css', array(), IMAGEFILET_VERSION, 'all' );
		wp_enqueue_script( 'imagefilet-backend-scripts', IMAGEFILET_PLUGIN_URL . 'core/includes/assets/js/backend-scripts.js', array(), IMAGEFILET_VERSION, false );
		wp_localize_script( 'imagefilet-backend-scripts', 'imagefilet', array(
			'plugin_name'   	=> __( IMAGEFILET_NAME, 'image-file-type-in-woocommerce-admin-table' ),
		));
	}

}
