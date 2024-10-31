<?php
/**
 * The plugin admin functionality
 *
 * @link              https://losol.io
 * @package           Ratio
 */

/**
 * The admin-specific functionality for the google module.
 *
 * @link       https://losol.io
 *
 * @package    Ratio
 * @subpackage Ratio/admin/google
 */
class Ratio_Admin_Google extends Ratio_Admin {
	/**
	 * Initialize the class
	 */
	public function __construct() {
		// Add menu page.
		add_action( 'admin_menu', array( $this, 'add_module_submenu_page' ) );

		// Register settings for module.
		add_action( 'admin_menu', array( $this, 'register_module_settings' ) );
	}

	/**
	 * Register the administration page for this module into the WordPress Dashboard menu.
	 */
	public function add_module_submenu_page() {
		// add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '' ).
		add_submenu_page( 'ratio' , 'Google analytics', 'Google analytics', 'manage_options', 'ratio-admin-google', array( $this, 'display_options_page' ) );
	}

	/**
	 * Get the options page for this plugin.
	 */
	public function display_options_page() {
		include_once( 'partials/ratio-admin-google.php' );
	}

	/**
	 * Register all related settings of this module
	 */
	public function register_module_settings() {

		// Add settings sections.
		// add_settings_section( string $id, string $title, callable $callback, string $page ).
		add_settings_section( 'ratio_google_settings', __( 'Google Analytics', 'ratio' ), array( $this, 'settings_section_callback' ), 'ratio-admin-google' );

		// Define fields.
		$settings_google_fields = array(

		array(
			'uid' => 'ratio_google_add_analytics',
			'label' => 'Add Google analytics tracking code',
			'page' => 'ratio-admin-google',
			'section' => 'ratio_google_settings',
			'type' => 'checkbox',
			'sanitize' => array( $this, 'sanitize_array_recursive' ),
			'options' => array(
				'googleanalytics' => 'Add Google analytics',
				),
			'default' => array(),
			),
		array(
			'uid' => 'ratio_google_analytics_tracking_id',
			'label' => 'Tracking ID',
			'page' => 'ratio-admin-google',
			'section' => 'ratio_google_settings',
			'type' => 'text',
			'sanitize' => array( $this, 'validate_ga_id' ),
			'options' => false,
			'placeholder' => 'UA-XXXX-YY',
			'helper' => '',
			'supplemental' => 'If you don´t know how to find this, just follow <a href="https://losol.io/find-your-google-analytics-tracking-id/">this guide</a>.',
			'default' => '',
			),
			);

		$this->setup_fields( $settings_google_fields );
	}

	/**
	 * Validates Google analytics ids.
	 *
	 * @param string $value Google Analytics Id.
	 */
	public function validate_ga_id( $value ) {
		$validated = sanitize_text_field( $value );
		$matched[0] = '';

		if ( ! preg_match( '/^UA-[0-9]+-[0-9]+$/', $validated, $matched ) ) {
			/*
			 * Add settings error.
			 * From WP Docs: add_settings_error( $setting, $code, $message, $type ).
			 */
			add_settings_error(
				'ratio_google_setting',
				'settings_updated',
				$message = __( 'Your Tracking Id does not seem to be right. It should be something like UA-123456-12!', 'ratio' ),
			$type = 'error');
		}
			return $matched[0];
	}

	/**
	 * Displays section settings information.
	 *
	 * @param array $arguments Arguments for section.
	 */
	public function settings_section_callback( $arguments ) {
		switch ( $arguments['id'] ) {
			case 'ratio_google_settings':
				echo 'To track your site with Google Analytics you just check the box below and supply yor Google Analytics Tracking ID. ';
				break;
		}
	}
}
new Ratio_Admin_Google;
