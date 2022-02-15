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
?>
<p>
    <?php
    /**
     * @see \GuestSubmission\App\Frontend\Templates
     * @var $args
     */
    echo __( 'This is being loaded inside "wp_footer" from the templates class', 'guest-submission' ) . ' ' . $args[ 'data' ][ 'text' ];
    ?>
</p>
