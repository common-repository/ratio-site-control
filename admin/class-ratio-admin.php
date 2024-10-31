<?php
/**
 * The plugin admin functionality
 *
 * @link              https://losol.io
 * @package           Ratio
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://losol.io
 *
 * @package    Ratio
 * @subpackage Ratio/admin
 */
class Ratio_Admin extends Ratio {
	/**
	 * Initialize the class
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
		$this->load_modules();
	}

	/**
	 * Adds the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * Add a settings page for this plugin to the WordPress dashboard.
	 *
	 * @link Administration Menus docs: http://codex.wordpress.org/Administration_Menus.
	 */
	public function add_plugin_admin_menu() {
		if ( empty( $GLOBALS['admin_page_hooks']['ratio'] ) ) {
			// add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', string $icon_url = '', int $position = null ).
			add_menu_page( 'Ratio. Site Control.', 'Ratio', 'manage_options', 'ratio', array( $this, 'display_menu_page' ), 'dashicons-clipboard' );
		}
	}
	/**
	 * Set up fields
	 */
	public function load_modules() {
		require_once plugin_dir_path( __FILE__ ) . 'class-ratio-admin-google.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-ratio-admin-facebook.php';
	}

	/**
	 * Render the settings page for this plugin.
	 */
	public function display_menu_page() {
		include_once( 'partials/ratio-admin.php' );
	}

	/**
	 * Shows information for each section.
	 *
	 * @param array $args Display arguments.
	 */
	public function settings_section_callback( $args ) {
		switch ( $args['id'] ) {
			case 'ratio_scripts_settings':
				echo 'Settings for head and body scripts';
				break;
		}
	}

	/**
	 * Sets up fields.
	 *
	 * @param array $fields Fields to add and register.
	 */
	public function setup_fields( $fields ) {
		foreach ( $fields as $field ) {
			/*
			Parameters: add_settings_field( string $id, string $title, callable $callback, string $page, string $section = 'default', array $args = array() )
			*/
			add_settings_field(
				$field['uid'],
				$field['label'],
				array( $this, 'settings_field_callback' ),
				$field['page'],
				$field['section'],
			$field );

			/*
			Parameters: register_setting( string $option_group, string $option_name, array $args = array() )
			Args: 'type': string/boolean/integer/number, 'description', 'sanitize_callback', 'show_in_rest', 'default'
			*/
			register_setting(
				$field['page'],
				$field['uid'],
				array(
					'sanitize_callback' => $field['sanitize'],
				)
			);

		}
	}

	/**
	 * Settings section display callback.
	 *
	 * Renders the html for editing a field. This function is based on the work of Matthew Ray
	 *
	 * @param array $arguments Display arguments.
	 */
	public function settings_field_callback( $arguments ) {

		$value = get_option( $arguments['uid'] );

		if ( ! $value ) {
			$value = $arguments['default'];
		}

		switch ( $arguments['type'] ) {
			case 'text':
			case 'password':
			case 'number':
				printf(
					'<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
					esc_attr( $arguments['uid'] ),
					esc_attr( $arguments['type'] ),
					esc_attr( $arguments['placeholder'] ),
					esc_attr( $value )
				);
				break;
			case 'textarea':
				printf( '
					<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="80">%3$s</textarea>',
					esc_attr( $arguments['uid'] ),
					esc_attr( $arguments['placeholder'] ),
					esc_attr( $value )
				);
				break;
			case 'select':
			case 'multiselect':
				if ( ! empty( $arguments['options'] ) && is_array( $arguments['options'] ) ) {
					$attributes = '';
					$options_markup = '';
					foreach ( $arguments['options'] as $key => $label ) {
						$options_markup .= sprintf(
							'<option value="%s" %s>%s</option>',
							$key,
							selected( $value[ array_search( $key, $value, true ) ],
							$key, false ),
							$label
						);
					}
					if ( 'multiselect' === $arguments['type'] ) {
						$attributes = ' multiple="multiple" ';
					}
					printf( '<select name="%1$s[]" id="%1$s" %2$s>%3$s</select>',
						esc_attr( $arguments['uid'] ),
						esc_attr( $attributes ),
						esc_attr( $options_markup )
					);
				}
				break;
			case 'radio':
			case 'checkbox':
				if ( ! empty( $arguments['options'] ) && is_array( $arguments['options'] ) ) {
					$options_markup = '';
					$iterator = 0;
					foreach ( $arguments['options'] as $key => $label ) {
						$iterator++;
						$options_markup .= sprintf(
							'<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s[%3$s]" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>',
							esc_attr( $arguments['uid'] ),
							esc_attr( $arguments['type'] ),
							esc_attr( $key ),
							checked( array_key_exists( $key, (array) $value ), 1, 0 ),
							esc_attr( $label ),
							$iterator
						);
					}
					printf( '<fieldset>%s</fieldset>',  $options_markup );
				}
				break;
		} // End switch().

		$allowed_html = array(
			'a' => array(
				'href' => array(),
				'title' => array(),
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			);

		if ( ! empty( $arguments['helper'] ) ) {
			printf( '<span class="helper"> %s</span>', wp_kses( $arguments['helper'], $allowed_html ) );
		}
		if ( ! empty( $arguments['supplemental'] ) ) {
			printf( '<p class="description">%s</p>', wp_kses( $arguments['supplemental'], $allowed_html ) );
		}
	}

	/**
	 * Admin notice.
	 *
	 * Shows a message for administrator in the WordPress Dashboard.
	 *
	 * @param string $message Message to show.
	 * @param string $type Type of message: error, success or info.
	 * @param bool   $dismissible Could user dismiss the message.
	 */
	public static function admin_notice( $message = '', $type = 'info', $dismissible = true ) {
			$notice = $this->admin_notice_callback( $message, $type, $dismissible );
			add_action( 'admin_notices', $notice );
	}

	/**
	 * Returns a function for using as admin notice callback.
	 *
	 * @see admin_notice
	 * @param string $message Message to show.
	 * @param string $type Type of message: error, success or info.
	 * @param bool   $dismissible Could user dismiss the message.
	 */
	private static function admin_notice_callback( $message = '', $type = 'info', $dismissible = true ) {
		$class = 'notice notice-' . $type;

		if ( $dismissible ) {
			$class .= ' is-dismissible';
		}

		$output = sprintf( '<div class="%s"><p>%s</p></div>', $class, $message );

		$allowed_html = array(
			'a' => array(
				'href' => array(),
				'title' => array(),
			),
			'br' => array(),
			'em' => array(),
			'strong' => array(),
		);
		$func = function() use ( $output ) {
			echo ( wp_kses( $output, $allowed_html ) );
		};
		return $func;
	}

	/**
	 * Returns a sanitized nested array.
	 *
	 * @param array $array Array to sanitize.
	 */
	public function sanitize_array_recursive( $array ) {
		foreach ( $array as $key => &$value ) {
			if ( is_array( $value ) ) {
				$value = sanitize_array_recursive( $value );
			} else {
				$value = sanitize_text_field( $value );
			}
		}
		return $array;
	}

	/**
	 * Returns a sanitized array.
	 *
	 * @param array $array Array to sanitize.
	 */
	public function sanitize_array( $array ) {
		$multi_values = ! is_array( $values ) ? explode( ',', $values ) : $values;
		return ! empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
	}
}
new Ratio_Admin();
