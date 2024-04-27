<?php

/**
 * Class translentor_Machine_Translator
 *
 * Facilitates Machine Translation calls
 */
class translentor_Machine_Translator {
    protected $settings;
	protected $referer;
	protected $lang_url;
	//protected $machine_translator_logger;
	protected $machine_translation_codes;
	protected $translentor_languages;
    protected $correct_api_key = null;
    /**
     * translentor_Machine_Translator constructor.
     *
     * @param array $settings         Settings option.
     */
    public function __construct( $settings ){
        
        $this->settings = $settings;

        $translentor                             = translentor_Translentor::get_translentor_instance();
        // if ( ! $this->machine_translator_logger ) {
        //     $this->machine_translator_logger = $translentor->get_translentorelements('machine_translator_logger');
        // }
        if ( ! $this->translentor_languages ) {
            $this->translentor_languages = $translentor->get_translentorelements('languages');
        }
        $this->machine_translation_codes = get_option('translentor_settings_elementor')['translentor-lang-slugs'];//$this->translentor_languages->get_iso_codes($this->settings['translation-languages']);
       
    }

    /**
     * Whether automatic translation is available.
     *
     * @param array $languages
     * @return bool
     */
    public function is_available( $languages = array() ){
        if( get_option('deepl_translation')== 'yes'
        ) {
            if ( empty( $languages ) ){
                // can be used to simply know if machine translation is available
                return true;
            }

            return $this->check_languages_availability($languages);

        }else {
            return false;
        }
    }

    public function check_languages_availability( $languages, $force_recheck = false ){
      
        if ( !method_exists( $this, 'get_supported_languages' ) || !method_exists( $this, 'get_engine_specific_language_codes' )){
            return true;
        }
        $force_recheck = ( current_user_can('manage_options') &&
            !empty( $_GET['translentor_recheck_supported_languages']) && $_GET['translentor_recheck_supported_languages'] === '1' &&
            wp_verify_nonce( sanitize_text_field( $_GET['translentor_recheck_supported_languages_nonce'] ), 'translentor_recheck_supported_languages' ) ) ? true : $force_recheck; //phpcs:ignore
        $data = get_option('translentor_db_stored_data', array() );
        if ( isset( $_GET['translentor_recheck_supported_languages'] )) {
            unset($_GET['translentor_recheck_supported_languages'] );
        }

        // if supported languages are not stored, fetch them and update option
        if ( empty( $data['translentor_mt_supported_languages']['deepl']['last-checked'] ) || $force_recheck || ( method_exists($this,'check_formality') && !isset($data['translentor_mt_supported_languages']['deepl']['formality-supported-languages']))){
            if ( empty( $data['translentor_mt_supported_languages'] ) ) {
                $data['translentor_mt_supported_languages'] = array();
            }
            if ( empty( $data['translentor_mt_supported_languages'][ 'deepl' ] ) ) {
                $data['translentor_mt_supported_languages'][ 'deepl' ] = array( 'languages' => array() );
            }

            $data['translentor_mt_supported_languages']['deepl']['languages'] = $this->get_supported_languages();
            if (method_exists($this, 'check_formality')) {
                $data['translentor_mt_supported_languages'][ 'deepl' ]['formality-supported-languages'] = $this->check_formality();
            }
            $data['translentor_mt_supported_languages']['deepl']['last-checked'] = date("Y-m-d H:i:s" );
            update_option('translentor_db_stored_data', $data );
        }

        $languages_iso_to_check = $this->get_engine_specific_language_codes( $languages );

        $all_are_available = !array_diff($languages_iso_to_check, $data['translentor_mt_supported_languages']['deepl']['languages']);

        return apply_filters('translentor_mt_available_supported_languages', $all_are_available, $languages, get_option('translentor_settings_elementor') );
    }

    public function get_last_checked_supported_languages(){
        $data = get_option('translentor_db_stored_data', array() );
        if ( empty( $data['translentor_mt_supported_languages']['deepl']['last-checked'] ) ){
            $this->check_languages_availability( get_option('translentor_settings_elementor')['translentor_lang'], true);
        }
        return $data['translentor_mt_supported_languages']['deepl']['last-checked'];
    }

    /**
     * Output an SVG based on translation engine and error flag.
     *
     * @param bool $show_errors true to show an error SVG, false if not.
     */
    public function automatic_translation_svg_output( $show_errors ) {
        if ( method_exists( $this, 'automatic_translate_error_check' ) ) {
            if ( $show_errors ) {
                translentor_output_svg( 'error' );
            } else {
                translentor_output_svg( 'check' );
            }
        }
        
    }

    /**
     *
     * @deprecated
     * Check the automatic translation API keys for Google Translate and DeepL.
     *
     * @param translentor_Translentor $machine_translator Machine translator instance.
     * @param string $translation_engine              The translation engine (can be google_translate_v2 and deepl).
     * @param string $api_key                         The API key to check.
     *
     * @return array [ (string) $message, (bool) $error ].
     */
    public function automatic_translate_error_check( $machine_translator, $translation_engine, $api_key ) {

        $is_error       = false;
        $return_message = '';

        switch ( $translation_engine ) {
            case 'deepl':
                if ( empty( $api_key ) ) {
                    $is_error = true;
                    $return_message = __( 'Please enter your DeepL API key.', 'translatepress-multilingual' );
                } else {
                    // Perform test.
                    $is_error= false;
                    $response = $machine_translator->test_request();
                    $code     = wp_remote_retrieve_response_code( $response );
                    if ( 200 !== $code && ( method_exists( 'translentor_DeepL', 'deepl_response_codes' ) || method_exists( 'translentor_IN_DeepL', 'deepl_response_codes' ) ) ) {

						// Test whether the old deepL add-on or the new repackaging model is used
						if ( method_exists( 'translentor_DeepL', 'deepl_response_codes' ) ) {
							$translate_response = translentor_DeepL::deepl_response_codes( $code );
						} else {
							$translate_response = translentor_IN_DeepL::deepl_response_codes( $code );
						}
	                    $is_error       = true;
                        $return_message = $translate_response['message'];
                    }
                }
                break;
            default:
                break;
        }


        $this->correct_api_key=array(
            'message' => $return_message,
            'error'   => $is_error,
        );

        return $this->correct_api_key;
    }

    // checking if the api_key is correct in order to display unsupported languages

    public function is_correct_api_key(){

        if(method_exists($this, 'check_api_key_validity')){
            $verification = $this->check_api_key_validity();
        }else {
            //we only need this values for automatic translate error check function for backwards compatibility

            $machine_translator = $this;
            $translation_engine = 'deepl';
            $api_key = '5068a37f-c64b-5cae-834b-0340fd439dc3:fx';
            $verification = $this->automatic_translate_error_check( $machine_translator, $translation_engine, $api_key );
        }
        if($verification['error']== false) {
            return true;
        }
        return false;
    }


	/**
	 * Return site referer
	 *
	 * @return string
	 */
	public function get_referer(){
		if( ! $this->referer ) {
			if( ! $this->lang_url ) {
				$translentor = translentor_Translentor::get_translentor_instance();
				$this->lang_url = $translentor->get_translentorelements( 'lang_url' );
			}

			$this->referer = $this->lang_url->get_abs_home();
		}

		return $this->referer;
	}

    /**
     * Verifies that the machine translation request is valid
     * @deprecated  since TP 1.6.0 (only here to support Deepl Add-on version 1.0.0)
     *
     * @param  string $to_language language we're looking to translate to
     * @return bool
     */
    public function verify_request( $to_language ){

        if( empty( $this->get_api_key() ) || 
        empty( $to_language ) || $to_language == get_option('translentor_settings_elementor')['translentor-default-language'] ||//$this->settings['default-language'] ||
            empty( $this->machine_translation_codes[get_option('translentor_settings_elementor')['translentor-default-language']] )
          )
            return false;

        // Method that can be extended in the child class to add extra validation
        if( !$this->extra_request_validations( $to_language ) )
            return false;

       

        // Check if daily quota is met
        if( $this->machine_translator_logger->quota_exceeded() )
            return false;

        return true;

    }

    /**
     * Verifies that the machine translation request is valid
     *
     * @param  string $target_language_code language we're looking to translate to
     * @param  string $source_language_code language we're looking to translate from
     * @return bool
     */
    public function verify_request_parameters($target_language_code, $source_language_code){
        if( empty( $this->get_api_key() ) ||
            empty( $target_language_code ) || empty( $source_language_code ) ||
            empty( $this->machine_translation_codes[$target_language_code] ) ||
            empty( $this->machine_translation_codes[$source_language_code] ) ||
            $this->machine_translation_codes[$target_language_code] == $this->machine_translation_codes[$source_language_code]
        )
            return false;

        // Method that can be extended in the child class to add extra validation
        if( !$this->extra_request_validations( $target_language_code ) )
            return false;

      

        // Check if daily quota is met
        // if( $this->machine_translator_logger->quota_exceeded() )
        //     return false;

        return true;
    }

    /**
     * Verifies user agent to check if the request is being made by a crawler
     *
     * @return boolean
     */
    

    private function get_placeholders( $count ){
	    $placeholders = array();
	    for( $i = 1 ; $i <= $count; $i++ ){
            $placeholders[] = '1TP' . $i . 'T';
        }
	    return $placeholders;
    }

    /**
     * Function to be used externally
     *
     * @param $strings
     * @param $target_language_code
     * @param $source_language_code
     * @return array
     */
    public function translate($strings, $target_language_code, $source_language_code = null ){
        
        if(!empty($strings) && is_array($strings) && method_exists( $this, 'translate_array' )){
            
            /* google has a problem translating this characters ( '%', '$', '#' )...for some reasons it puts spaces after them so we need to 'encode' them and decode them back. hopefully it won't break anything important */
            /* we put '%s' before '%' because google seems to transform %s into % in strings for some languages which causes a 500 Fata Error in PHP 8*/
            $translentor_exclude_words_from_automatic_translation = apply_filters('translentor_exclude_words_from_automatic_translation', array('%s','%', '$', '#'));
            $placeholders = $this->get_placeholders(count($translentor_exclude_words_from_automatic_translation));
            $shortcode_tags_to_execute = apply_filters( 'translentor_do_these_shortcodes_before_automatic_translation', array('translentor_language') );

            $strings = array_unique($strings);
            $original_strings = $strings;
            foreach ($strings as $key => $string) {
                /* html_entity_decode is needed before replacing the character "#" from the list because characters like &#8220; (8220 utf8)
                 * will get an extra space after '&' which will break the character, rendering it like this: & #8220;
                 */
                $strings[$key] = str_replace($translentor_exclude_words_from_automatic_translation, $placeholders, html_entity_decode( $string ));
                $strings[$key] = translentor_do_these_shortcodes( $strings[$key], $shortcode_tags_to_execute );
            }

            
                // backwards compatibility with deepl version 1.0.0 which doesn't have the third function parameter $source_language_code
                $machine_strings = $this->translate_array($strings, $target_language_code);
                //$machine_strings = $this->translate_array($strings, $target_language_code, $source_language_code);

            $machine_strings_return_array = array();
            if (!empty($machine_strings)) {
               
                foreach ($machine_strings as $key => $machine_string) {
                    $machine_strings_return_array[$original_strings[$key]] = str_ireplace( $placeholders, $translentor_exclude_words_from_automatic_translation, $machine_string );
                }
            }
            return $machine_strings_return_array;
        }else{
            return array();
        }
        
    }


    public function test_request(){}

    public function get_api_key(){
        return false;
    }

    public function extra_request_validations( $to_language ){
        return true;
    }
}
