<?php
/**
 * The plugin main file
 *
 * @link              https://github.com/priyankasoni97/
 * @since             1.0.0
 * @package           CMS_Custom_Feeds
 *
 * @wordpress-plugin
 * Plugin Name:       CMS Custom Feeds
 * Plugin URI:        https://github.com/priyankasoni97/
 * Description:       This plugin is used to display WordPress feeds
 * Version:           1.0.0
 * Author:            Priyanka Soni
 * Author URI:        https://github.com/priyankasoni97/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cms-custom-feeds
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CCF_PLUGIN_VERSION', '1.0.0' );

// Plugin path.
if ( ! defined( 'CCF_PLUGIN_VERSION' ) ) {
	define( 'CCF_PLUGIN_VERSION', plugin_dir_path( __FILE__ ) );
}

// Plugin URL.
if ( ! defined( 'CCF_PLUGIN_VERSION' ) ) {
	define( 'CCF_PLUGIN_VERSION', plugin_dir_url( __FILE__ ) );
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function ccf_core_funcitons() {
	// The core plugin class that is used to define internationalization and public-specific hooks.
	require_once 'includes/class-ccf-custom-feed-widget.php';
	new CCF_Custom_Feed_Widget();
}

/**
 * This initiates the plugin.
 * Checks for the required plugins to be installed and active.
 */
function ccf_plugins_loaded_callback() {
	ccf_core_funcitons();
}

add_action( 'plugins_loaded', 'ccf_plugins_loaded_callback' );

/**
 * Debugger function which shall be removed in production.
 */
if ( ! function_exists( 'debug' ) ) {
	/**
	 * Debug function definition.
	 *
	 * @param string $params Holds the variable name.
	 */
	function debug( $params ) {
		echo '<pre>';
		// phpcs:disable WordPress.PHP.DevelopmentFunctions
		print_r( $params );
		// phpcs:enable
		echo '</pre>';
	}
}
