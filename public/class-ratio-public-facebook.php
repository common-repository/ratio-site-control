<?php
/**
 * The Facebook admin functionality
 *
 * @link              https://losol.io
 * @package           Ratio
 */

/**
 * The public-facing functionality of the scripts module.
 *
 * @package    Ratio
 * @subpackage Ratio/Public/Facebook
 * @author     losol.io <wp@losol.io>
 */
class Ratio_Public_Facebook extends Ratio_Public {
	/**
	 * Initialize the class.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'add_facebook_sdk_js' ) );
	}

	/**
	 * Check if Facebook SDK should be loaded.
	 */
	public function add_facebook_sdk_js() {

		$facebook_sdk_js = $this->option_enabled( 'ratio_facebook_add', 'facebook_sdk_js' );

		if ( $facebook_sdk_js ) {
			$facebook_script = $this->get_facebook_sdk_js_code();
			$this->insert_script( $facebook_script, 'body' );
		}
	}

	/**
	 * Makes the code for Facebook SKD for JavaScript.
	 */
	public function get_facebook_sdk_js_code() {
		$facebook_app_id = esc_attr( get_option( 'ratio_facebook_app_id', '' ) );
		$facebook_sdk_js_src = 'https://connect.facebook.net/en_US/sdk.js';

		// Checks if Facebook has translation for Site Locale.
		$facebook_sdk_supported_langauges = array( 'en_US', 'ca_ES', 'cs_CZ', 'cx_PH', 'cy_GB', 'da_DK', 'de_DE', 'eu_ES', 'en_UD', 'es_LA', 'es_ES', 'gn_PY', 'fi_FI', 'fr_FR', 'gl_ES', 'hu_HU', 'it_IT', 'ja_JP', 'ko_KR', 'nb_NO', 'nn_NO', 'nl_NL', 'fy_NL', 'pl_PL', 'pt_BR', 'pt_PT', 'ro_RO', 'ru_RU', 'sk_SK', 'sl_SI', 'sv_SE', 'th_TH', 'tr_TR', 'ku_TR', 'zh_CN', 'zh_HK', 'zh_TW', 'af_ZA', 'sq_AL', 'hy_AM', 'az_AZ', 'be_BY', 'bn_IN', 'bs_BA', 'bg_BG', 'hr_HR', 'nl_BE', 'en_GB', 'et_EE', 'fo_FO', 'fr_CA', 'ka_GE', 'el_GR', 'gu_IN', 'hi_IN', 'is_IS', 'id_ID', 'ga_IE', 'jv_ID', 'kn_IN', 'kk_KZ', 'lv_LV', 'lt_LT', 'mk_MK', 'mg_MG', 'ms_MY', 'mt_MT', 'mr_IN', 'mn_MN', 'ne_NP', 'pa_IN', 'sr_RS', 'so_SO', 'sw_KE', 'tl_PH', 'ta_IN', 'te_IN', 'ml_IN', 'uk_UA', 'uz_UZ', 'vi_VN', 'km_KH', 'tg_TJ', 'ar_AR', 'he_IL', 'ur_PK', 'fa_IR', 'ps_AF', 'my_MM', 'qz_MM', 'or_IN', 'si_LK', 'rw_RW', 'cb_IQ', 'ha_NG', 'ja_KS', 'br_FR', 'tz_MA', 'co_FR', 'as_IN', 'ff_NG', 'sc_IT', 'sz_PL' );
		$wp_locale = get_locale();
		if ( in_array( $wp_locale, $facebook_sdk_supported_langauges, true ) ) {
			$facebook_sdk_js_src = str_replace( 'en_US', $wp_locale, $facebook_sdk_js_src );
		}

		$facebook_sdk_js_async_code = "
			<!-- Facebook SDK for JS added by plugin 'Ratio. Site Control'. -->
			<script>
				window.fbAsyncInit = function() {
					FB.init({
					appId            : 'your-app-id',
					autoLogAppEvents : true,
					xfbml            : true,
					version          : 'v2.9'
					});
					FB.AppEvents.logPageView();
				};

				(function(d, s, id){
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) {return;}
					js = d.createElement(s); js.id = id;
					js.src = '***SRC***';
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			</script>
			<!-- End Facebook SDK for JS -->
		";

		// Replace Facebook App Id.
		$facebook_sdk_js_async_code = str_replace( 'your-app-id', $facebook_app_id, $facebook_sdk_js_async_code );

		// Replace locale.
		$facebook_sdk_js_async_code = str_replace( '***SRC***', $facebook_sdk_js_src, $facebook_sdk_js_async_code );

		echo $facebook_sdk_js_async_code;
	}
}
new Ratio_Public_Facebook;
