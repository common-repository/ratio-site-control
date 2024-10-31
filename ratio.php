<?php
/**
 * The plugin bootstrap file
 *
 * @link              https://losol.io
 * @since             1.0.0
 * @package           Ratio
 *
 * @wordpress-plugin
 * Plugin Name:       Ratio. Site control.
 * Plugin URI:        https://losol.io/projects/ratio
 * Description:       Ratio. Site control. Gives you Facebook SDK and Google analytics.
 * Version:           1.0.0
 * Author:            losol.io
 * Author URI:        https://losol.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ratio
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_ratio() {
	// Requires PHP 5.3.
	if ( version_compare( PHP_VERSION, '5.3', '<' ) ) {
		add_action( 'admin_notices', create_function( '', "echo '<div class=\"error\"><p>" . __( 'Ratio requires PHP 5.3. Please upgrade PHP or deactivate plugin.', 'ratio' ) . "</p></div>';" ) );
		return;
	} else {
		include_once plugin_dir_path( __FILE__ ) . 'includes/class-ratio.php';
	}
}
run_ratio();
