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

use TestPlugin\Common\Abstracts\Base;
use TestPlugin\Common\Utils\Errors;

/**
 * Check if any requirements are needed to run this plugin. We use the
 * "Requirements" package from "MicroPackage" to check if any PHP Extensions,
 * plugins, themes or PHP/WP version are required.
 * @docs https://github.com/micropackage/requirements
 *
 * @package TestPlugin\Config
 * @since 1.0.0
 */
final class Requirements extends Base {
	/**
	 * Specifications for the requirements
	 *
	 * @return array : used to specify the requirements
	 * @since 1.0.0
	 */
	public function specifications(): array {
		return apply_filters( 'test_plugin_plugin_requirements', [
			'php'            => $this->plugin->requiredPhp(),
			'php_extensions' => [
				/**
				 * 'mbstring'
				 */
			],
			'wp'             => $this->plugin->requiredWp(),
			'plugins'        => [
				/**
				 * [
				 *  'file'    => 'hello-dolly/hello.php',
				 *  'name'    => 'Hello Dolly',
				 *  'version' => '1.5'
				 * ],
				 */
			],
		] );
	}

	/**
	 * Plugin requirements checker
	 *
	 * @since 1.0.0
	 */
	public function check() {
		// We use "Requirements" if the package is required and installed by composer.json
		if ( class_exists( '\Micropackage\Requirements\Requirements' ) ) {
			$this->requirements = new \Micropackage\Requirements\Requirements(
				$this->plugin->name(),
				$this->specifications()
			);
			if ( ! $this->requirements->satisfied() ) {
				// Print notice
				$this->requirements->print_notice();
				// Kill plugin
				Errors::pluginDie();
			}
		} else {
			// Else we do a version check based on version_compare
			$this->versionCompare();
		}
	}

	/**
	 * Compares PHP & WP versions and kills plugin if it's not compatible
	 *
	 * @since 1.0.0
	 */
	public function versionCompare() {
		foreach (
			[
				// PHP version check
				[
					'current' => phpversion(),
					'compare' => $this->plugin->requiredPhp(),
					'title'   => __( 'Invalid PHP version', 'test-plugin' ),
					'message' => sprintf( /* translators: %1$1s: required php version, %2$2s: current php version */
						__( 'You must be using PHP %1$1s or greater. You are currently using PHP %2$2s.', 'test-plugin' ),
						$this->plugin->requiredPhp(),
						phpversion()
					),
				],
				// WP version check
				[
					'current' => get_bloginfo( 'version' ),
					'compare' => $this->plugin->requiredWp(),
					'title'   => __( 'Invalid WordPress version', 'test-plugin' ),
					'message' => sprintf( /* translators: %1$1s: required wordpress version, %2$2s: current wordpress version */
						__( 'You must be using WordPress %1$1s or greater. You are currently using WordPress %2$2s.', 'test-plugin' ),
						$this->plugin->requiredWp(),
						get_bloginfo( 'version' )
					),
				],
			] as $compat_check ) {
			if ( version_compare(
				$compat_check['compare'],
				$compat_check['current'],
				'>='
			) ) {
				// Kill plugin
				Errors::pluginDie(
					$compat_check['message'],
					$compat_check['title'],
					plugin_basename( __FILE__ )
				);
			}
		}
	}
}
