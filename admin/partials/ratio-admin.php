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
 * @subpackage Ratio/admin/partials
 */

?>

<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
	<h1><?php esc_html_e( 'Ratio. Site Control.', 'ratio' ) ?></h1>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<h2><span><?php esc_attr_e( 'Ratio. Site control plugin', 'ratio' ); ?></span></h2>

						<div class="inside">
							<p><?php esc_attr_e(
								'This plugin was built to have a plugin for adding your most wanted scripts to your site.',
								'ratio'
							); ?></p>
							<a class="button-primary" href="<?php echo esc_url( admin_url( 'admin.php?page=ratio-admin-google', 'admin' ) ) ?>"><?php esc_attr_e( 'Set up Google analytics' ); ?></a>
							<a class="button-primary" href="<?php echo esc_url( admin_url( 'admin.php?page=ratio-admin-facebook', 'admin' ) ) ?>"><?php esc_attr_e( 'Add Facebook SDK' ); ?></a>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables .ui-sortable -->

			</div>
			<!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

				<div class="meta-box-sortables">

					<div class="postbox">

						<h2><span><?php esc_attr_e(
							'Issues? Feature requests?', 'ratio'
						); ?></span></h2>

						<div class="inside">
							<p><?php esc_attr_e(
								'Feel free to submit issues and feature requests at wordpress.org',
								'ratio'
							); ?></p>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables -->

			</div>
			<!-- #postbox-container-1 .postbox-container -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->
</div>
