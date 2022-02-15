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

namespace GuestSubmission\App\General;

use GuestSubmission\Common\Abstracts\Base;

/**
 * Class Shortcodes
 *
 * @package GuestSubmission\App\General
 * @since 1.0.0
 */
class Shortcodes extends Base {
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
		 * Add plugin code here
		 */

		add_shortcode( 'submission_form', [ $this, 'submissionFormFunc' ] );
	}

	/**
	 * Shortcode example
	 *
	 * @param array $atts Parameters.
	 * @return string
	 * @since 1.0.0
	 */
	public function submissionFormFunc( $atts ): string {
		
		$atts = shortcode_atts( array(
			'post_type' => PostTypes::POST_TYPE['id'],
			'status' => 'draft',
		), $atts, 'submission_form' );
	 
		return 'FORM RENDER PART';
	}
}
