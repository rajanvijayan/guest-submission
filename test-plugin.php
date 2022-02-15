<?php
/**
 * Test Plugin
 *
 * @package   the-test-plugin
 * @author    Rajan Vijayan <me@rajanvijayan.com>
 * @copyright rajanvijayan
 * @license   MIT
 * @link      https://rajanvijayan.com
 *
 * Plugin Name:     Test Plugin
 * Plugin URI:      https://rajanvijayan.com/test-plugin
 * Description:     Starter plugin project for WordPress
 * Version:         1.0.0
 * Author:          Rajan Vijayan
 * Author URI:      https://rajanvijayan.com
 * Text Domain:     test-plugin
 * Domain Path:     /languages
 * Requires PHP:    7.1
 * Requires WP:     5.5.0
 * Namespace:       TestPlugin
 */

declare( strict_types = 1 );

/**
 * Define the default root file of the plugin
 *
 * @since 1.0.0
 */
const TEST_PLUGIN_FILE = __FILE__;

/**
 * Load PSR4 autoloader
 *
 * @since 1.0.0
 */
$test_plugin_autoloader = require plugin_dir_path( TEST_PLUGIN_FILE ) . 'vendor/autoload.php';

/**
 * Setup hooks (activation, deactivation, uninstall)
 *
 * @since 1.0.0
 */
register_activation_hook( __FILE__, [ 'TestPlugin\Config\Setup', 'activation' ] );
register_deactivation_hook( __FILE__, [ 'TestPlugin\Config\Setup', 'deactivation' ] );
register_uninstall_hook( __FILE__, [ 'TestPlugin\Config\Setup', 'uninstall' ] );

/**
 * Bootstrap the plugin
 *
 * @since 1.0.0
 */
if ( ! class_exists( '\TestPlugin\Bootstrap' ) ) {
	wp_die( __( 'Test Plugin is unable to find the Bootstrap class.', 'test-plugin' ) );
}
add_action(
	'plugins_loaded',
	static function () use ( $test_plugin_autoloader ) {
		/**
		 * @see \TestPlugin\Bootstrap
		 */
		try {
			new \TestPlugin\Bootstrap( $test_plugin_autoloader );
		} catch ( Exception $e ) {
			wp_die( __( 'Test Plugin is unable to run the Bootstrap class.', 'test-plugin' ) );
		}
	}
);

/**
 * Create a main function for external uses
 *
 * @return \TestPlugin\Common\Functions
 * @since 1.0.0
 */
function test_plugin(): \TestPlugin\Common\Functions {
	return new \TestPlugin\Common\Functions();
}
