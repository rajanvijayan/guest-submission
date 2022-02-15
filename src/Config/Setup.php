<?php
/**
 * Guest Submission
 *
 * @package   guest-submission
 * @author    Rajan Vijayan <me@rajanvijayan.com>
 * @copyright rajanvijayan
 * @license   MIT
 * @link      https://rajanvijayan.com
 */

declare( strict_types = 1 );

namespace GuestSubmission\Config;

use GuestSubmission\Common\Traits\Singleton;

/**
 * Plugin setup hooks (activation, deactivation, uninstall)
 *
 * @package GuestSubmission\Config
 * @since 1.0.0
 */
final class Setup {
	/**
	 * Singleton trait
	 */
	use Singleton;

	/**
	 * Run only once after plugin is activated
	 * @docs https://developer.wordpress.org/reference/functions/register_activation_hook/
	 */
	public static function activation() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		/**
		 * Use this to add a database table after the plugin is activated for example
		 */

		// Clear the permalinks
		flush_rewrite_rules();

		# Uncomment the following line to see the function in action
		# exit( var_dump( $_GET ) );
	}

	/**
	 * Run only once after plugin is deactivated
	 * @docs https://developer.wordpress.org/reference/functions/register_deactivation_hook/
	 */
	public static function deactivation() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		/**
		 * Use this to register a function which will be executed when the plugin is deactivated
		 */

		// Clear the permalinks
		flush_rewrite_rules();

		# Uncomment the following line to see the function in action
		# exit( var_dump( $_GET ) );
	}

	/**
	 * Run only once after plugin is uninstalled
	 * @docs https://developer.wordpress.org/reference/functions/register_uninstall_hook/
	 */
	public static function uninstall() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		/**
		 * Use this to remove plugin data and residues after the plugin is uninstalled for example
		 */

		# Uncomment the following line to see the function in action
		# exit( var_dump( $_GET ) );
	}
}
