<?php
/**
 * The Facebook admin functionality
 *
 * @link              https://losol.io
 * @package           Ratio
 */

/**
 * The admin-specific functionality for the facebook module.
 *
 * @link       https://losol.io
 * @since      1.0.0
 *
 * @package    Ratio
 * @subpackage Ratio/Admin/Facebook
 */
class Ratio_Admin_Facebook extends Ratio_Admin {
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
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 */
	public function add_module_submenu_page() {
		/*
		 * Add a settings page for this module to the Settings menu.
		 *
		 * add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '' )
		 */
		add_submenu_page( 'ratio' , 'Facebook settings', 'Facebook', 'manage_options', 'ratio-admin-facebook', array( $this, 'display_options_page' ) );
	}

	/**
	 * Renders the options page for this plugin.
	 */
	public function display_options_page() {
		include_once( 'partials/ratio-admin-facebook.php' );
	}

	/**
	 * Register all related settings of this module
	 */
	public function register_module_settings() {
		/*
		 * Add settings sections.
		 *
		 * add_settings_section( string $id, string $title, callable $callback, string $page )
		 */
		add_settings_section( 'ratio_facebook', __( 'Social media', 'ratio' ), array( $this, 'settings_section_callback' ), 'ratio-admin-facebook' );

		// Define fields.
		$settings_social_fields = array(

		array(
			'uid' => 'ratio_facebook_add',
			'label' => 'Add Facebook SDK for Javascript',
			'page' => 'ratio-admin-facebook',
			'section' => 'ratio_facebook',
			'type' => 'checkbox',
			'sanitize' => array( $this, 'sanitize_array_recursive' ),
			'options' => array(
				'facebook_sdk_js' => 'Add Facebook SDK for javascript',
				),
			'supplemental' => 'Needed for Facebook Like Box and Like Page',
			'default' => array(),
		),
		array(
			'uid' => 'ratio_facebook_app_id',
			'label' => 'Facebook App ID',
			'page' => 'ratio-admin-facebook',
			'section' => 'ratio_facebook',
			'type' => 'text',
			'sanitize' => array( $this, 'validate_facebook_app_id' ),
			'options' => false,
			'placeholder' => '123456789',
			'helper' => '',
			'supplemental' => 'If you don´t know how to find this, just follow <a href="https://losol.io/getting-your-facebook-app-id/">this guide</a>.',
			'default' => '',
		),
		);

		$this->setup_fields( $settings_social_fields );
	}

	/**
	 * Validates Facebook app ids.
	 *
	 * @param string $value Facebook App Id.
	 */
	public function validate_facebook_app_id( $value ) {
		$validated = sanitize_text_field( $value );
		$matched[0] = '';

		// Match supplied id with pattern.
		if ( ! preg_match( '/^[1-9][0-9]{0,25}$/', $validated, $matched ) ) {
			/*
			 * Add settings error.
			 * From WP Docs: add_settings_error( $setting, $code, $message, $type ).
			 */
			add_settings_error(
				'ratio_facebook_settings',
				'settings_updated',
				$message = __( 'Your App Id does not seem to be right. It should be a number like 456789012345678', 'ratio' ),
			$type = 'error');
		}
		return $matched[0];
	}

	/**
	 * Shows description for section.
	 *
	 * @param array $arguments Arugments.
	 */
	public function settings_section_callback( $arguments ) {
		switch ( $arguments['id'] ) {
			case 'ratio_facebook':
				esc_html_e( 'To Add Facebook functionality you will need to add the SDK and your App Id. ', 'ratio' );
			break;
		}
	}
}
new Ratio_Admin_Facebook;
