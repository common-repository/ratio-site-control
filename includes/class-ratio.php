<?php
/**
 * The plugin main class file
 *
 * @link              https://losol.io
 * @package           Ratio
 */

/**
 * Add action to load plugin.
 *
 * @package    Ratio
 * @subpackage Ratio/includes
 * @author     losol.io <wp@losol.io>
 */
class Ratio {
	/**
	 * Plugin name.
	 *
	 * @var      string    $plugin_name    The name/slug of the plugin.
	 */
	protected $plugin_name;

	/**
	 * Plugin title.
	 *
	 * @var      string    $plugin_title    The title of the plugin.
	 */
	protected $plugin_title;

	/**
	 * Plugin version.
	 *
	 * @var      string    $version    The version of the plugin.
	 */
	protected $version;

	/**
	 * URL to this plugin's directory.
	 *
	 * @var      string    $plugin_url    The url of the plugin's directory.
	 */
	public $plugin_url = '';

	/**
	 * Path to this plugin's directory.
	 *
	 * @var      string    $plugin_path    The path of the plugin's directory.
	 */
	public $plugin_path = '';

	/**
	 * Constructor left blank and private.
	 * Use get_instance
	 */
	public function __construct() {
		$this->plugin_name = 'ratio';
		$this->plugin_title = 'Ratio. Site Control.';
		$this->version = '1.0.0';
		$this->plugin_url    = plugins_url( '/', __FILE__ );
		$this->plugin_path   = plugin_dir_path( __FILE__ );
		$this->load_language( 'ratio' );
		$this->load_dependencies();

	}

	/**
	 * Load the required dependencies for this plugin.
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ratio-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ratio-public.php';
	}

	/**
	 * Loads translation file.
	 *
	 * @param string $domain The plugin's text domain.
	 * @return  void
	 */
	public function load_language( $domain ) {
		load_plugin_textdomain(
			$domain,
			false,
			$this->plugin_path . 'languages'
		);
	}

	/**
	 * Checks if options is enabled by searching in array
	 *
	 * @param string $option_name The options storing the key.
	 * @param string $key The key to check if exist in option.
	 */
	public function option_enabled( $option_name, $key ) {
		$options = get_option( $option_name );

		if ( is_array( $options ) ) {
			if ( array_key_exists( $key, (array) $options ) ) {
				return true;
			}
		}
		return false;
	}
}
new Ratio();
