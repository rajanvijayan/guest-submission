<?php
/**
 * Guest Submission
 *
 * @package   guest-submission
 * @author    Rajan Vijayan <me@rajanvijayan.com>
 * @copyright rajanvijayan
 * @license   MIT
 * @link      https://rajanvijayan.com
 *
 * Plugin Name:     Guest Submission
 * Plugin URI:      https://rajanvijayan.com/guest-submission
 * Description:     This plugin is about creating an interface in Front-end site of website, so that guest authors can submit posts from front-side. Using this interface, the guest author should be able to create a post from front side. We can also create another page where all the posts created by this author will be listed.
 * Version:         1.0.0
 * Author:          Rajan Vijayan
 * Author URI:      https://rajanvijayan.com
 * Text Domain:     guest-submission
 * Domain Path:     /languages
 * Requires PHP:    7.1
 * Requires WP:     5.5.0
 * Namespace:       GuestSubmission
 */

declare( strict_types = 1 );

/**
 * Define the default root file of the plugin
 *
 * @since 1.0.0
 */
const GUEST_PLUGIN_FILE = __FILE__;

/**
 * Load PSR4 autoloader
 *
 * @since 1.0.0
 */
$test_plugin_autoloader = require plugin_dir_path( GUEST_PLUGIN_FILE ) . 'vendor/autoload.php';

/**
 * Setup hooks (activation, deactivation, uninstall)
 *
 * @since 1.0.0
 */
register_activation_hook( __FILE__, [ 'GuestSubmission\Config\Setup', 'activation' ] );
register_deactivation_hook( __FILE__, [ 'GuestSubmission\Config\Setup', 'deactivation' ] );
register_uninstall_hook( __FILE__, [ 'GuestSubmission\Config\Setup', 'uninstall' ] );

/**
 * Bootstrap the plugin
 *
 * @since 1.0.0
 */
if ( ! class_exists( '\GuestSubmission\Bootstrap' ) ) {
	wp_die( __( 'Guest Submission is unable to find the Bootstrap class.', 'guest-submission' ) );
}
add_action(
	'plugins_loaded',
	static function () use ( $test_plugin_autoloader ) {
		/**
		 * @see \GuestSubmission\Bootstrap
		 */
		try {
			new \GuestSubmission\Bootstrap( $test_plugin_autoloader );
		} catch ( Exception $e ) {
			wp_die( __( 'Guest Submission is unable to run the Bootstrap class.', 'guest-submission' ) );
		}
	}
);

/**
 * Create a main function for external uses
 *
 * @return \GuestSubmission\Common\Functions
 * @since 1.0.0
 */
function test_plugin(): \GuestSubmission\Common\Functions {
	return new \GuestSubmission\Common\Functions();
}
