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

namespace TestPlugin\App\General;

use TestPlugin\Common\Abstracts\Base;

/**
 * Class Widgets
 *
 * @package TestPlugin\App\General
 * @since 1.0.0
 */
class Widgets extends Base {

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		/**
		 * This general class is always being instantiated as requested in the Bootstrap class
		 *
		 * @see Bootstrap::__construct
		 *
		 * Widget is registered from the Integrations folder, but it can also be registered
		 * from the integration class file self
		 * @see HTML_Widget::init()
		 */
		add_action( 'widgets_init', function () {
			register_widget( $this->plugin->namespace() . '\Integrations\Widget\HTML_Widget' );
		} );
	}
}

