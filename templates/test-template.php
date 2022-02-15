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
?>
<p>
    <?php
    /**
     * @see \TestPlugin\App\Frontend\Templates
     * @var $args
     */
    echo __( 'This is being loaded inside "wp_footer" from the templates class', 'test-plugin' ) . ' ' . $args[ 'data' ][ 'text' ];
    ?>
</p>
