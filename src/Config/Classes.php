<?php
/**
 * Test Plugin
 *
 * @package   the-test-plugin
 * @author    Rajan Vijayan <me@rajanvijayan.com>
 * @copyright rajanvijayan
 * @license   MIT
 * @link      https://rajanvijayan.com
 */

declare( strict_types = 1 );

namespace TestPlugin\Config;

/**
 * This array is being used in ../Boostrap.php to instantiate the classes
 *
 * @package TestPlugin\Config
 * @since 1.0.0
 */
final class Classes {

	/**
	 * Init the classes inside these folders based on type of request.
	 * @see Requester for all the type of requests or to add your own
	 */
	public static function get(): array {
		// phpcs:disable
		// ignore for readable array values one a single line
		return [
			[ 'init' => 'Integrations' ],
			[ 'init' => 'App\\General' ],
			[ 'init' => 'App\\Frontend', 'on_request' => 'frontend' ],
			[ 'init' => 'App\\Backend', 'on_request' => 'backend' ],
			[ 'init' => 'App\\Rest', 'on_request' => 'rest' ],
			[ 'init' => 'App\\Cli', 'on_request' => 'cli' ],
			[ 'init' => 'App\\Cron', 'on_request' => 'cron' ],
			[ 'init' => 'Compatibility' ],
		];
		// phpcs:enable
	}
}
