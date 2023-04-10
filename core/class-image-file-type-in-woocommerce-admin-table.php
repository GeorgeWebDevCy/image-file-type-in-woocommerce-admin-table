<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'Image_File_Type_In_Woocommerce_Admin_Table' ) ) :

	/**
	 * Main Image_File_Type_In_Woocommerce_Admin_Table Class.
	 *
	 * @package		IMAGEFILET
	 * @subpackage	Classes/Image_File_Type_In_Woocommerce_Admin_Table
	 * @since		1.0.0
	 * @author		George Nicolaou
	 */
	final class Image_File_Type_In_Woocommerce_Admin_Table {

		/**
		 * The real instance
		 *
		 * @access	private
		 * @since	1.0.0
		 * @var		object|Image_File_Type_In_Woocommerce_Admin_Table
		 */
		private static $instance;

		/**
		 * IMAGEFILET helpers object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Image_File_Type_In_Woocommerce_Admin_Table_Helpers
		 */
		public $helpers;

		/**
		 * IMAGEFILET settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Image_File_Type_In_Woocommerce_Admin_Table_Settings
		 */
		public $settings;

		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to clone this class.', 'image-file-type-in-woocommerce-admin-table' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to unserialize this class.', 'image-file-type-in-woocommerce-admin-table' ), '1.0.0' );
		}

		/**
		 * Main Image_File_Type_In_Woocommerce_Admin_Table Instance.
		 *
		 * Insures that only one instance of Image_File_Type_In_Woocommerce_Admin_Table exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @access		public
		 * @since		1.0.0
		 * @static
		 * @return		object|Image_File_Type_In_Woocommerce_Admin_Table	The one true Image_File_Type_In_Woocommerce_Admin_Table
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Image_File_Type_In_Woocommerce_Admin_Table ) ) {
				self::$instance					= new Image_File_Type_In_Woocommerce_Admin_Table;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->helpers		= new Image_File_Type_In_Woocommerce_Admin_Table_Helpers();
				self::$instance->settings		= new Image_File_Type_In_Woocommerce_Admin_Table_Settings();

				//Fire the plugin logic
				new Image_File_Type_In_Woocommerce_Admin_Table_Run();

				/**
				 * Fire a custom action to allow dependencies
				 * after the successful plugin setup
				 */
				do_action( 'IMAGEFILET/plugin_loaded' );
			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function includes() {
			require_once IMAGEFILET_PLUGIN_DIR . 'core/includes/classes/class-image-file-type-in-woocommerce-admin-table-helpers.php';
			require_once IMAGEFILET_PLUGIN_DIR . 'core/includes/classes/class-image-file-type-in-woocommerce-admin-table-settings.php';

			require_once IMAGEFILET_PLUGIN_DIR . 'core/includes/classes/class-image-file-type-in-woocommerce-admin-table-run.php';
		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function base_hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'image-file-type-in-woocommerce-admin-table', FALSE, dirname( plugin_basename( IMAGEFILET_PLUGIN_FILE ) ) . '/languages/' );
		}

	}

endif; // End if class_exists check.