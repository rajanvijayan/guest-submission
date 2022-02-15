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

namespace TestPlugin\Common\Abstracts;

use TestPlugin\Config\Plugin;

/**
 * The Base class which can be extended by other classes to load in default methods
 *
 * @package TestPlugin\Common\Abstracts
 * @since 1.0.0
 */
abstract class Base {
	/**
	 * @var array : will be filled with data from the plugin config class
	 * @see Plugin
	 */
	protected $plugin = [];

	/**
	 * Base constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->plugin = Plugin::init();
	}
}
