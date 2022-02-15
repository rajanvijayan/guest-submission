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
use GuestSubmission\App\General\PostTypes;

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

		$atts = shortcode_atts( [
			'post_type' => PostTypes::POST_TYPE['id'],
			'status' => 'draft',
		], $atts, 'submission_form' );

		ob_start();

		// Allow logged in user only.
		if ( ! is_user_logged_in() ) {
			return '<p>Login required! Click here to <a href="' . esc_url( wp_login_url( get_permalink() ) ) . '" >login</a>.</p>';
		}

		// Get custom post types.
		$args = [
			'public'   => true,
			'_builtin' => false,
		];

		$output   = 'objects';
		$operator = 'and';

		$post_types = get_post_types( $args, $output, $operator );

		?>
		<div id="wpps-form-wrap">
			<h3>Add New Post</h3>
			<form action="" method="post" id="wpps-post-form" enctype="multipart/form-data">
				<div class="wpps-form-row">
					<label for="wpps_post_title">Post Title</label>
					<input type="text" name="wpps_post_title" id="wpps_post_title" class="form-control" size="40" required>
				</div>
				<div class="wpps-form-row">
					<label for="wpps_post_type">Post type</label>
					<select name="wpps_post_type" id="wpps_post_type" class="form-control" required>
						<option value="">Select post type</option>
					<?php
					foreach ( $post_types as $post_type ) {
						?>
						<option value="<?php echo esc_attr( $post_type->name ); ?>"><?php echo esc_html( $post_type->label ); ?></option>
						<?php
					}
					?>
					</select>
				</div>
				<div class="wpps-form-row">
					<label for="wpps_post_content">Description</label>
					<?php
					$content   = '';
					$editor_id = 'wpps_post_content';
					$settings  = [ 'media_buttons' => false ];
					wp_editor( $content, $editor_id, $settings );
					?>
				</div>
				<div class="wpps-form-row">
					<label for="wpps_post_excerpt">Excerpt</label>
					<textarea name="wpps_post_excerpt" id="wpps_post_excerpt" cols="30" rows="3" class="form-control"></textarea>
				</div>
				<div class="wpps-form-row">
					<label for="wpps_post_featured_image">Featured image</label>
					<input type="file" name="wpps_post_featured_image" id="wpps_post_featured_image">
				</div>
				<div class="wpps-form-row">
					<input type="submit" value="Submit" class="wpps-btn">
				</div>
			</form>
			<div class="wpps-res"></div>
		</div>
		<?php
		$str = ob_get_clean();

		return $str;

	}
}
