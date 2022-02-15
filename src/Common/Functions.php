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

namespace GuestSubmission\Common;

use GuestSubmission\App\Frontend\Templates;
use GuestSubmission\Common\Abstracts\Base;

/**
 * Main function class for external uses
 *
 * @see test_plugin()
 * @package GuestSubmission\Common
 */
class Functions extends Base {
	/**
	 * Get plugin data by using test_plugin()->getData()
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function getData(): array {
		return $this->plugin->data();
	}

	/**
	 * Get the template instantiated class using test_plugin()->templates()
	 *
	 * @return Templates
	 * @since 1.0.0
	 */
	public function templates(): Templates {
		return new Templates();
	}
}
