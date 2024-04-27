<?php

/**
 * Class translentor_Languages
 *
 * Provides available languages, with name and code.
 */
class translentor_Languages{

  	protected $languages = array();
	protected $wp_languages;
	protected $wp_languages_backup = array();
	protected $settings;
	protected $is_admin_request;


	public function change_locale( $locale ){
        if ( !$this->is_admin_request ){
            $translentor = translentor_Translentor::get_translentor_instance();
            $translentor_is_admin_request = $translentor->get_translentorelements( 'lang_url' );
            $this->is_admin_request= $translentor_is_admin_request->is_admin_request();
        }

		if ( $this->is_admin_request )
		    return $locale;


	    global $translentor_LANGUAGE;
		if( !empty($translentor_LANGUAGE) ){
			$locale = $translentor_LANGUAGE;
		}
		return $locale;
	}

    
	public function get_wp_languages(){
		
		if ( empty( $this->wp_languages ) ){
			require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
			$this->wp_languages = wp_get_available_translations();
			if ( count( $this->wp_languages ) == 0 ) {
				$this->wp_languages = $this->get_wp_languages_backup();
			}
		}
		
	
		$default = array( 'en' => array( 'language'	=> 'en', 'english_name'=> 'English (United States)', 'native_name' => 'English', 'iso' => array( 'en' ) ) );
		return apply_filters( 'translentor_wp_languages', $default + $this->wp_languages );
	}

    

	public function get_all_language_codes(){
		return array_keys ( $this->get_wp_languages_backup() );
	}

	public function get_language_names( $language_codes, $english_or_native_name = null ){
		
		if ( !$english_or_native_name ){
			if ( !$this->settings ){
				$translentor = translentor_Translentor::get_translentor_instance();
				$translentor_settings = get_option('translentor_settings_elementor');
				$this->settings = get_option('translentor_settings_elementor');
			}
			$english_or_native_name = $this->settings['translentor-lang-native-name'];
		}
		$return = array();
        $languages = $this->get_wp_languages_backup();
		
		foreach ( $language_codes as $language_code ){
			if( isset( $languages[$language_code] ) ) {
				$return[$language_code] = apply_filters( 'translentor_language_name', $languages[$language_code], $language_code, $english_or_native_name, $language_codes );
			}
		}

		return $return;
	}

	/**
	 * Returns substring of the string from the beginning until the occurrence of character
	 *
	 * If character not found do nothing.
	 *
	 * @param $string string    String to trim
	 * @param $character string Delimitator string
	 *
	 * @return string
	 */
	public function string_trim_after_character( $string, $character ){
		if ( strpos( $string, $character ) !== false ) {
			$string = substr($string, 0, strpos($string, $character ));
		}
		return $string;
	}

	/**
	 * Return true if the language (without country) of the language_code is present multiple times in the array
	 *
	 * (ex. For language code en_UK, language_code_array [en_US, en_UK], return true)
	 *
	 * @param $language_code string         Language code (ex. en_US)
	 * @param $language_code_array array    Array of language codes
	 *
	 * @return bool
	 */
	public function duplicated_language( $language_code, $language_code_array ){
		// strip country from code ( ex. en_US => en )
		$stripped_language_code = $this->string_trim_after_character( $language_code, "_" );
		foreach ( $language_code_array as $key => $value ){
			$stripped_value = $this->string_trim_after_character( $value, "_" );
			if ( $language_code != $value && $stripped_language_code == $stripped_value ){
				return true;
			}
		}
		return false;

	}

    /**
     * Return the short language name for English name.
     *
     * @param string $name                  Original language name.
     * @param string $code                  Language code.
     * @param string $english_or_native     'english_name' | 'native_name'
     * @return string                       Short language name.
     */
	public function beautify_language_name( $name, $code, $english_or_native, $language_codes ){
	    $wp_lang = $this->get_wp_languages();
		
		if ( $english_or_native == 'english_name' ) {
			if ( ! $this->duplicated_language( $code, $language_codes) && (!isset($wp_lang[$code]['is_custom_language']) || (isset($wp_lang[$code]['is_custom_language']) && $wp_lang[$code]['is_custom_language'] !== true))){
				$name = $this->string_trim_after_character( $name, " (" );
			}
		}
		return apply_filters( 'translentor_beautify_language_name', $name, $code, $english_or_native, $language_codes );
	}

	/**
	 * Return language arrays with English languages first
	 *
	 * @param $languages_array array            Languages array
	 * @param $english_or_native_name string    'english_name' | 'native_name'
	 *
	 * @return array
	 */
	public function reorder_languages( $languages_array, $english_or_native_name ){
		$english_array = array();
		foreach( $languages_array as $key => $value ){
			if ( $this->string_trim_after_character( $key, '_' ) == 'en' ){
				$english_array[$key] = $value;
				unset( $languages_array[$key] );
			}
		}

		return $english_array + $languages_array;
	}

	public function get_wp_languages_backup(){
		return  array (
            'af' => 'Afrikaans',
            'ga' => 'Irish',
            'sq' => 'Albanian',
            'it' => 'Italian',
            'ar' => 'Arabic',
            'ja' => 'Japanese',
            'az' => 'Azerbaijani',
            'kn' => 'Kannada',
            'eu' => 'Basque',
            'ko' => 'Korean',
            'bn' => 'Bangla',
            'la' => 'Latin',
            'be' => 'Belarusian',
            'lv' => 'Latvian',
            'bg' => 'Bulgarian',
            'lt' => 'Lithuanian',
            'ca' => 'Catalan',
            'mk' => 'Macedonian',
            'zh' => 'Chinese Simplified',
            'ms' => 'Malay',
            'zh-TW' => 'Chinese Traditional',
            'mt' => 'Maltese',
            'hr' => 'Croatian',
            'no' => 'Norwegian',
            'cs' => 'Czech',
            'fa' => 'Persian',
            'da' => 'Danish',
            'pl' => 'Polish',
            'nl' => 'Dutch',
            'pt' => 'Portugese',
            'en' => 'English',
            'ro' => 'Romanian',
            'eo' => 'Esperanto',
            'ru' => 'Russian',
            'et' => 'Estonian',
            'sr' => 'Serbian',
            'tl' => 'Filipino',
            'sk' => 'Slovak',
            'fi' => 'Finnish',
            'sl' => 'Slovenian',
            'fr' => 'French',
            'es' => 'Spanish',
            'gl' => 'Galician',
            'sw' => 'Swahili',
            'ka' => 'Georgian',
            'sv' => 'Swedish',
            'de' => 'German',
            'ta' => 'Tamil',
            'el' => 'Greek',
            'te' => 'Telugu',
            'gu' => 'Gujarati',
            'th' => 'Thai',
            'ht' => 'Haitian Creole',
            'tr' => 'Turkish',
            'iw' => 'Hebrew',
            'uk' => 'Ukranian',
            'hi_IN' => 'Hindi',
            'ur' => 'Urdu',
            'hu' => 'Hungarian',
            'vi' => 'Vietnamese',
            'is' => 'Icelandic',
            'cy' => 'Welsh',
            'id' => 'Indonesian',
            'yi' => 'Yiddish'
        );
	}
}