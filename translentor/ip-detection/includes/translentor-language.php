<?php

class translentor_IN_ALD_Determine_Language {

	public function __construct() {
		// using relative path because this function is also called outside WP
		require_once( __DIR__ . '/translentor-browser.php' );
		require_once( __DIR__ . '/translentor-ip.php' );
	}

	/**
	 * Return preferred language code based on parameters.
	 *
	 * Returns null if there are no matches between available languages and desired languages.
	 *
	 * @param $published_languages array       TranslatePress settings['publish-languages']
	 * @param $iso_codes array                 Iso codes of the published languages
	 * @param $detection_method string         translentor_settings['detection-method']
	 *
	 * @return null|string
	 */
	public function get_needed_language( $published_languages, $iso_codes, $detection_method  ){
		$needed_language = null;

		$translentor_browser_language = new translentor_IN_Browser_Language();
		$browser_language_code = $translentor_browser_language->get_browser_language( $published_languages, $iso_codes );
       
		$translentor_ip_language = new translentor_IN_IP_Language();
		$ip_language_code = $translentor_ip_language->get_ip_language( $published_languages, $iso_codes );
		
		switch ( $detection_method ) {
			case 'browser-ip': {
				if ( $browser_language_code ){
					$needed_language = $browser_language_code;
				}else if ( $ip_language_code ){
					$needed_language = $ip_language_code;
				}
				break;
			}
			case 'ip-browser': {
				if ( $ip_language_code ){
					$needed_language = $ip_language_code;
					
				}else if ( $browser_language_code ){
					$needed_language = $browser_language_code;
					
				}
				break;
			}
			case 'browser':{
				if ( $browser_language_code ){
					$needed_language = $browser_language_code;
				}
				break;
			}
			case 'ip':{
				if ( $ip_language_code ){
					$needed_language = $ip_language_code;
				}
				break;
			}

		}
		return $needed_language;
	}
}