<?php
/**
 * Main class for public-facing functionality of the plugin.
 *
 * @link       https://losol.io
 * @since      1.0.0
 *
 * @package    Ratio
 * @subpackage Ratio/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Ratio
 * @subpackage Ratio/public
 * @author     losol.io <wp@losol.io>
 */
class Ratio_Public extends Ratio {

	/**
	 * Initializes the class and set its properties.
	 */
	public function __construct() {
		$this->load_modules();
	}

	/**
	 * Load modules
	 */
	public function load_modules() {
		require_once plugin_dir_path( __FILE__ ) . 'class-ratio-public-google.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-ratio-public-facebook.php';
	}
	/**
	 * Insert script to header, top of body or footer.
	 *
	 * The body position requires the theme  to have a suitable action tag.
	 * This function tries body_top.
	 *
	 * @param string $script Script to insert.
	 * @param string $position Where to place script: head tag, after body opens, or footer.
	 */
	public static function insert_script( $script = '', $position = 'footer' ) {
		$script_callback = Ratio_Public::insert_script_callback( $script );
		switch ( $position ) {
			case 'head':
				add_action( 'wp_head', $script_callback );
				break;
			case 'body':
				// Use body_top action if exists, otherwise fallback to footer.
				if ( has_action( 'body_top' ) ) {
						add_action( 'body_top', $script_callback );
				} else {
						add_action( 'wp_footer', $script_callback );
				}
				break;
			case 'footer':
				add_action( 'wp_footer', $script_callback );
				break;
		}
	}

	/**
	 * Returns a script.
	 *
	 * @see insert_script
	 * @param string $script Script to insert.
	 */
	private static function insert_script_callback( $script = '' ) {
		$func = function() use ( $script ) {
			echo ( $script );
		};
		return $func;
	}

}
new Ratio_Public();
