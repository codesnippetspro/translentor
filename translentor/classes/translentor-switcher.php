<?php

/**
 * Class translentor_Language_Switcher
 *
 * Generates all types of language switchers.
 */
class translentor_Language_Switcher{

    protected $settings;
	/** @var translentor_Lang_Url */
    protected $lang_url;
    protected $translentor_settings_object;
	/** @var translentor_Languages */
    protected $translentor_languages;
	/** @var translentor_Translentor */
    protected $translentor;

    public function __construct( $settings, $translentor ){
        $this->settings = $settings;
        $this->translentor = $translentor;
        $this->lang_url = $this->translentor->get_translentorelements( 'lang_url' );
        $language = $this->get_current_language($translentor);
        global $translentor_LANGUAGE;
        $translentor_LANGUAGE = $language;
        
    }

	
	private function get_current_language( $translentor ){
		$language_from_url = $this->lang_url->get_lang_from_url_string();

		$needed_language = $this->determine_needed_language( $language_from_url, $translentor );

		$allow_redirect = apply_filters( 'translentor_allow_language_redirect', true, $needed_language, $this->lang_url->cur_page_url() );
		if ( $allow_redirect ) {
			if ( ( $language_from_url == null && isset( $this->settings['translentor-subdirectory-default-lang'] ) && $this->settings['translentor-subdirectory-default-lang'] == 'yes' ) ||
			     ( $language_from_url == null && $needed_language != $this->settings['translentor-default-language'] ) ||
			     ( $language_from_url != null && $needed_language != $language_from_url )
			) {
                global $translentor_NEEDED_LANGUAGE;
                $translentor_NEEDED_LANGUAGE = $needed_language;
                add_filter( 'template_redirect', array( $this, 'redirect_to_correct_language' ) );
			}
		}

        return $needed_language;
	}


	public function determine_needed_language( $lang_from_url, $translentor ){
		if ( $lang_from_url == null ){
			if ( isset( $this->settings['translentor-subdirectory-default-lang'] ) && $this->settings['translentor-subdirectory-default-lang'] == 'yes' && isset( $this->settings['translentor_publish-lang'][0] ) ) {
                $needed_language = $this->settings['translentor_publish-lang'][0];
			}else{
				$needed_language = $this->settings['translentor-default-language'];
			}
		}else{
			$needed_language = $lang_from_url;
		}
		return apply_filters( 'translentor_needed_language', $needed_language, $lang_from_url, $this->settings, $translentor );
    }

	/**
	 * Redirects to language stored in global $translentor_NEEDED_LANGUAGE
	 */
	public function redirect_to_correct_language(){

        if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX  ) || is_customize_preview() )
            return;

        global $translentor_NEEDED_LANGUAGE;

        if ( ! $this->lang_url ){
            $translentor = translentor_Translentor::get_translentor_instance();
            $this->lang_url = $translentor->get_translentorelements( 'lang_url' );
        }

        if ( $this->lang_url->is_sitemap_path() )
            return;

        $link_to_redirect = apply_filters( 'translentor_link_to_redirect_to', $this->lang_url->get_url_for_language( $translentor_NEEDED_LANGUAGE, null, '' ), $translentor_NEEDED_LANGUAGE );

        if( isset( $this->settings['translentor-subdirectory-default-lang'] ) && $this->settings['translentor-subdirectory-default-lang'] === 'yes' && isset( $this->settings['translentor-default-language'] ) && $this->settings['translentor-default-language'] === $translentor_NEEDED_LANGUAGE )
            wp_redirect( $link_to_redirect, 301 );
        else
            wp_redirect( $link_to_redirect );

        exit;

    }

	
	public function language_switcher( $atts ){
		ob_start();

		global $translentor_LANGUAGE;

		$shortcode_attributes = shortcode_atts( array(
			'display' => 0,
		), $atts );

		if ( ! $this->translentor_languages ){
			$translentor = translentor_Translentor::get_translentor_instance();
			$this->translentor_languages = $translentor->get_translentorelements( 'languages' );
		}
		if ( current_user_can(apply_filters( 'translentor_translating_capability', 'manage_options' )) ){
        $languages_to_display = get_option('translentor_settings_elementor')['translentor_lang'];
    }else{
        $languages_to_display = $this->settings['translentor_publish-lang'];
    }
		$published_languages = $this->translentor_languages->get_language_names( $languages_to_display );

		$current_language = array();
		$other_languages = array();

		foreach( $published_languages as $code => $name ) {
			if( $code == $translentor_LANGUAGE ) {
				$current_language['code'] = $code;
				$current_language['name'] = $name;
			} else {
				$other_languages[$code] = $name;
			}
		}
		$current_language = apply_filters('translentor_ls_shortcode_current_language', $current_language, $published_languages, $translentor_LANGUAGE, $this->settings);
		$other_languages = apply_filters('translentor_ls_shortcode_other_languages', $other_languages, $published_languages, $translentor_LANGUAGE, $this->settings);

		if( ! $this->translentor_settings_object ) {
			$translentor = translentor_Translentor::get_translentor_instance();
			$this->translentor_settings_object = get_option('translentor_settings_elementor');
		}
		
		return ob_get_clean();
	}


 

  

}
