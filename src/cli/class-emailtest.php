<?php
/**
 * Simple email configuration within WordPress.
 *
 * @package sb-simple-smtp
 * @author soup-bowl <code@soupbowl.io>
 * @license MIT
 */

namespace wpsimplesmtp\cli;

use wpsimplesmtp\Mailtest;
use WP_CLI;

/**
 * Adds operations to WP-CLI environments.
 */
class EmailTest {
	/**
	 * Tests the site email functionality.
	 *
	 * <email>
	 * : Email address to send the test to.s
	 *
	 * @when before_wp_load
	 */
	public function test_email( $args, $assoc_args ) {
		if ( is_email( $args[0] )) {
			$email     = Mailtest::generate_test_email( true );
			$recipient = sanitize_email( $args[0] );
			
			$is_sent = wp_mail( $recipient, $email['subject'], $email['message'], $email['headers'] );

			if ( $is_sent ) {
				WP_CLI::success( __( 'Test email sent!', 'simple-smtp' ) );
			} else {
				WP_CLI::error( __( 'Email failed to send. Check the logs to see what happened.', 'simple-smtp' ) );
			}
		} else {
			WP_CLI::error( __( 'Email address provided is invalid.', 'simple-smtp' ) );
		}
	}
}
