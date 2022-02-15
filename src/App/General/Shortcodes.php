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

		add_action( 'wp_ajax_gs_do_create_post', [ $this, 'gs_ajax_create_post' ] );

		add_shortcode( 'submission_form', [ $this, 'submissionFormFunc' ] );
		add_shortcode( 'submission_list', array( $this, 'submissionListFunc' ) );
	}

	/**
	 * Shortcode
	 *
	 * @param array $atts Parameters.
	 * @return string
	 * @since 1.0.0
	 */
	public function submissionListFunc( $atts ): string {
		ob_start();

		if ( ! is_user_logged_in() ) {
			return '<p>Please <a href="' . esc_url( wp_login_url( get_permalink() ) ) . '" >login</a> here.</p>';
		}

		$args = array(
			'public'   => true,
			'_builtin' => false,
		);
		
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

		$query = new \WP_Query(
			array(
				'post_type'      => get_post_types( $args ),
				'author'         => get_current_user_id(),
				'posts_per_page' => 10,
				'paged'          => $paged,
			)
		);

		if ( $query->have_posts() ) {
			echo '<div class="gs-list-wrap">';
			while ( $query->have_posts() ) {
				$query->the_post();
				?>
					<div class="gs-post">
						<h3><?php the_title(); ?></h3>
						<?php the_excerpt(); ?>
						<a href="<?php the_permalink(); ?>" class="gs-link">Read More</a>
					</div>
				<?php
			}
			echo '</div>';
			?>
			<div class="gs-pagination">
				<?php
				echo paginate_links(
					array(
						'format'  => '?paged=%#%',
						'current' => max( 1, get_query_var( 'paged' ) ),
						'total'   => $query->max_num_pages,
					)
				);
				?>

			</div>
			<?php
		}
		wp_reset_postdata();
		return ob_get_clean();

	}

	/**
	 * Shortcode
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

		if ( ! is_user_logged_in() ) {
			return '<p>Please <a href="' . esc_url( wp_login_url( get_permalink() ) ) . '" >login</a> here.</p>';
		}

		$args = [
			'public'   => true,
			'_builtin' => false,
		];

		$output   = 'objects';
		$operator = 'and';

		$post_types = get_post_types( $args, $output, $operator );

		?>
		<div id="gs-form-wrap">
			<h3>Add New Post</h3>
			<form action="" method="post" id="gs-post-form" enctype="multipart/form-data">
				<div class="gs-form-row">
					<label for="gs_post_title">Post Title</label>
					<input type="text" name="gs_post_title" id="gs_post_title" class="form-control" size="40" required>
				</div>
				<div class="gs-form-row">
					<label for="gs_post_type">Post type</label>
					<select name="gs_post_type" id="gs_post_type" class="form-control" required>
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
				<div class="gs-form-row">
					<label for="gs_post_content">Description</label>
					<?php
					$content   = '';
					$editor_id = 'gs_post_content';
					$settings  = [ 'media_buttons' => false ];
					wp_editor( $content, $editor_id, $settings );
					?>
				</div>
				<div class="gs-form-row">
					<label for="gs_post_excerpt">Excerpt</label>
					<textarea name="gs_post_excerpt" id="gs_post_excerpt" cols="30" rows="3" class="form-control"></textarea>
				</div>
				<div class="gs-form-row">
					<label for="gs_post_featured_image">Featured image</label>
					<input type="file" name="gs_post_featured_image" id="gs_post_featured_image">
				</div>
				<div class="gs-form-row">
					<input type="submit" value="Submit" class="gs-btn">
				</div>
			</form>
			<div class="gs-result"></div>
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
	public function gs_ajax_create_post() {

		// User login check
		if ( ! is_user_logged_in() ) {
			return;
		}

		// Nonce verification
		if ( ! isset( $_POST['gs_nonce'] ) || ! wp_verify_nonce( $_POST['gs_nonce'], 'guest-submission-ajax-nonce' ) ) {
			return;
		}
		
		// Sanitize the form data 
		$title     = wp_strip_all_tags( wp_unslash( $_POST['gs_post_title'] ) );
		$post_type = sanitize_text_field( wp_unslash( $_POST['gs_post_type'] ) );
		$content   = wp_kses_post( $_POST['gs_post_content'] );
		$excerpt   = sanitize_textarea_field( wp_unslash( $_POST['gs_post_excerpt'] ) );
		$author_id = get_current_user_id();

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

			// Admin Notification.
			$to      = get_option( 'admin_email' );
			$subject = 'New Post Submission from ' . get_bloginfo( 'name' );
			$body    = 'New post created by '. get_the_author_meta('display_name', $author_id);;
			$headers = array( 'Content-Type: text/html; charset=UTF-8' );
			wp_mail( $to, $subject, $body, $headers );

			if ( isset( $_FILES['gs_post_featured_image'] ) ) {

				// Featured Image.
				$upload = wp_upload_bits( $_FILES['gs_post_featured_image']['name'], null, file_get_contents( $_FILES['gs_post_featured_image']['tmp_name'] ) );

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
			echo '<div class="gs-alert succ"><p>Saved your post successfully! ' . esc_html( $respone ) . '</p></div>';
		} else {
			echo '<div class="gs-alert err"><p>Failed to save your post!</p></div>';
		}

		wp_die();
	}
}
