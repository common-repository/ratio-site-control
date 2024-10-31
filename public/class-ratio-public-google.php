<?php
/**
 * The public-facing functionality of the scripts module.
 *
 * @package    Ratio
 * @subpackage Ratio/public/google
 */

/**
 * The public-facing functionality of the scripts module.
 */
class Ratio_Public_Google extends Ratio_Public {
	/**
	 * Initializes the class.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'add_google_analytics' ) );
	}

	/**
	 * Adds Google Analytics tracking code to head tag.
	 */
	function add_google_analytics() {

		$add_analytics_option = $this->option_enabled( 'ratio_google_add_analytics', 'google_analytics' );

		if ( $add_analytics_option ) {
			insert_google_analytics();
		}

		// Head script.
		add_action( 'wp_head', array( $this, 'get_code' ) );
	}

	/**
	 * Creates the google analytics tracking code.
	 */
	public function get_code() {
		$ga_id = esc_attr( get_option( 'ratio_google_analytics_tracking_id', '' ) );

		$ga_async_code = "
			<!-- Google Analytics -->
			<script>
			window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
			ga('create', 'UA-XXXXX-Y', 'auto');
			ga('send', 'pageview');
			</script>
			<script async src='https://www.google-analytics.com/analytics.js'></script>
			<!-- End Google Analytics -->
		";
		echo str_replace( 'UA-XXXXX-Y', $ga_id, $ga_async_code );
		return str_replace( 'UA-XXXXX-Y', $ga_id, $ga_async_code );
	}
}
new Ratio_Public_Google;
