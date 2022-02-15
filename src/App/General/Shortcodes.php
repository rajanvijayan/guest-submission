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

		add_action( 'wp_ajax_wpps_do_create_post', [ $this, 'wpps_ajax_create_post' ] );

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

	/**
	 * Post form ajax action
	 *
	 * @since    1.0.0
	 */
	public function wpps_ajax_create_post() {

		

		// Check if user logged in.
		if ( ! is_user_logged_in() ) {
			return;
		}
		

		
		// Security check.
		if ( ! isset( $_POST['wpps_nonce'] ) || ! wp_verify_nonce( $_POST['wpps_nonce'], 'guest-submission-ajax-nonce' ) ) {
			return;
		}

		// $_POST sanitization.
		$title     = wp_strip_all_tags( wp_unslash( $_POST['wpps_post_title'] ) );
		$post_type = sanitize_text_field( wp_unslash( $_POST['wpps_post_type'] ) );
		$content   = wp_kses_post( $_POST['wpps_post_content'] );
		$excerpt   = sanitize_textarea_field( wp_unslash( $_POST['wpps_post_excerpt'] ) );
		$author_id = get_current_user_id();

		if ( empty( $title ) ) {
			echo '<p style="color: red; border: 2px solid yellow; padding:10px; text-align: center">Title field mandatory!</p>';
			wp_die();
		}

		

		// Add the content of the form to $post as an array.
		$post = array(
			'post_title'   => $title,
			'post_content' => $content,
			'post_excerpt' => $excerpt,
			'post_status'  => 'draft',
			'post_type'    => $post_type,
			'post_author'  => $author_id,
		);

		$post_id = wp_insert_post( $post );
		$respone = '';


		

		if ( ! empty( $post_id ) ) {

			// send email to admin.
			$to      = get_option( 'admin_email' );
			$subject = 'Page/Post Moderation';
			$body    = 'New post/page have been successfully created by Guest user.';
			$headers = array( 'Content-Type: text/html; charset=UTF-8' );
			wp_mail( $to, $subject, $body, $headers );

			if ( isset( $_FILES['wpps_post_featured_image'] ) ) {

				print_r($_FILES);
				// For Featured Image.
				$upload = wp_upload_bits( $_FILES['wpps_post_featured_image']['name'], null, file_get_contents( $_FILES['wpps_post_featured_image']['tmp_name'] ) );

				if ( ! $upload_file['error'] ) {
					$filename    = $upload['file'];
					$wp_filetype = wp_check_filetype( $filename, null );
					$attachment  = array(
						'post_mime_type' => $wp_filetype['type'],
						'post_title'     => sanitize_file_name( $filename ),
						'post_content'   => '',
						'post_status'    => 'inherit',
					);

					$attachment_id = wp_insert_attachment( $attachment, $filename, $post_id );

					if ( ! is_wp_error( $attachment_id ) ) {
						require_once ABSPATH . 'wp-admin/includes/image.php';

						$attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
						wp_update_attachment_metadata( $attachment_id, $attachment_data );
						set_post_thumbnail( $post_id, $attachment_id );
					}
				} else {
					$respone = '<span style="color: red">and Failed to update attachment.</span>';
				}
			}
			echo '<p style="border: 2px solid green; padding:10px; text-align: center">Saved your post successfully! ' . esc_html( $respone ) . '</p>';
		} else {
			echo '<p style="color: red; border: 2px solid yellow; padding:10px; text-align: center">Failed to save your post!</p>';
		}

		wp_die();
	}
}
