<?php
/**
 * Image File Type in WooCommerce Admin Table
 *
 * @package       IMAGEFILET
 * @author        George Nicolaou
 * @license       gplv2
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   Image File Type in WooCommerce Admin Table
 * Plugin URI:    https://www.georgenicolaou.me/plugins/image-file-type-in-woocommerce-admin-table
 * Description:   Displays the image file type within the WooCommerce admin product table.
 * Version:       1.0.0
 * Author:        George Nicolaou
 * Author URI:    https://www.georgenicolaou.me/
 * Text Domain:   image-file-type-in-woocommerce-admin-table
 * Domain Path:   /languages
 * License:       GPLv2
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 *
 * You should have received a copy of the GNU General Public License
 * along with Image File Type in WooCommerce Admin Table. If not, see <https://www.gnu.org/licenses/gpl-2.0.html/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
// Plugin name
define( 'IMAGEFILET_NAME',			'Image File Type in WooCommerce Admin Table' );

// Plugin version
define( 'IMAGEFILET_VERSION',		'1.0.0' );

// Plugin Root File
define( 'IMAGEFILET_PLUGIN_FILE',	__FILE__ );

// Plugin base
define( 'IMAGEFILET_PLUGIN_BASE',	plugin_basename( IMAGEFILET_PLUGIN_FILE ) );

// Plugin Folder Path
define( 'IMAGEFILET_PLUGIN_DIR',	plugin_dir_path( IMAGEFILET_PLUGIN_FILE ) );

// Plugin Folder URL
define( 'IMAGEFILET_PLUGIN_URL',	plugin_dir_url( IMAGEFILET_PLUGIN_FILE ) );

/**
 * Load the main class for the core functionality
 */
require_once IMAGEFILET_PLUGIN_DIR . 'core/class-image-file-type-in-woocommerce-admin-table.php';

/**
 * The main function to load the only instance
 * of our master class.
 *
 * @author  George Nicolaou
 * @since   1.0.0
 * @return  object|Image_File_Type_In_Woocommerce_Admin_Table
 */
function IMAGEFILET() {
	return Image_File_Type_In_Woocommerce_Admin_Table::instance();
}

// Register activation hook
register_activation_hook( __FILE__, 'image_file_type_activation_hook' );

// Activation hook function
function image_file_type_activation_hook() {
    // Check if WooCommerce is active
    if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        // Deactivate the plugin
        deactivate_plugins( plugin_basename( __FILE__ ) );
        // Display error message
        wp_die( 'Sorry, this plugin requires WooCommerce to be installed and activated. Please activate WooCommerce and try again.' );
    }
}

// Add Image File Type column to the Product table if user has permission.
add_filter( 'manage_edit-product_columns', 'add_image_file_type_column' );
add_filter( 'manage_edit-product_sortable_columns', 'make_image_file_type_column_sortable' );
add_action( 'pre_get_posts', 'sort_by_image_file_type_column' );


/**
 * Make Image File Type column sortable.
 *
 * @param array $columns
 * @return array
 */
function make_image_file_type_column_sortable( $columns ) {
    $columns['image_file_type'] = 'image_file_type';
    return $columns;
}

function sort_by_image_file_type_column( $query ) {
    if ( is_admin() && $query->is_main_query() ) {
        $orderby = $query->get( 'orderby' );
        if ( 'image_file_type' === $orderby ) {
            $query->set( 'meta_key', '_thumbnail_id' );
            $query->set( 'orderby', 'meta_value' );
        }

        // Make sure 'Image File Type' column is always visible
        $screen = get_current_screen();
        if ( isset( $screen->id ) && 'edit-product' === $screen->id ) {
            $screen_options = get_user_option( 'manageedit-productcolumnshidden' );
            if ( ! isset( $screen_options['image_file_type'] ) ) {
                $screen_options['image_file_type'] = false;
                update_user_option( get_current_user_id(), 'manageedit-productcolumnshidden', $screen_options );
            }
        }
    }
}
add_action( 'pre_get_posts', 'sort_by_image_file_type_column' );

add_filter( 'manage_edit-product_columns', 'add_image_file_type_column', 20 );
function add_image_file_type_column( $columns ) {
    $new_columns = array();
    foreach ( $columns as $column_key => $column_label ) {
        $new_columns[ $column_key ] = $column_label;
        if ( 'name' === $column_key ) {
            $new_columns['image_file_type'] = __( 'Image File Type', 'image-file-type-in-woocommerce-admin-table' );
        }
    }
    return $new_columns;
}

function populate_image_file_type_column( $column_name, $post_id ) {
    if ( 'image_file_type' === $column_name ) {
        $attachment_id = get_post_thumbnail_id( $post_id );
        if ( $attachment_id ) {
            $attachment = get_post( $attachment_id );
            $filetype = wp_check_filetype( get_attached_file( $attachment_id ) );
            echo esc_html( $filetype['ext'] );
        } else {
            echo '—';
        }
    }
}
add_action( 'manage_product_posts_custom_column', 'populate_image_file_type_column', 20, 2 );

IMAGEFILET();
