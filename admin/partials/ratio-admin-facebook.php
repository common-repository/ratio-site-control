<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://losol.io
 * @since      1.0.0
 *
 * @package    Ratio
 * @subpackage Ratio/admin/scripts
 */

?>

<div class="wrap">
	<h2><?php esc_html_e( 'Facebook settings', 'ratio' ) ?></h2>
	<?php settings_errors( 'ratio_facebook_settings' ); ?>
	<form action="options.php" method="post">
		<?php settings_fields( 'ratio-admin-facebook' ); ?>
		<?php do_settings_sections( 'ratio-admin-facebook' ); ?>
			
		<input name="Submit" type="submit" value="<?php esc_attr_e( 'Save Changes', 'ratio' ); ?>" class="button button-primary" />
	</form>
</div>
