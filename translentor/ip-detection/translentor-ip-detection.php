<?php

class translentor_IN_Automatic_Language_Detection {

	protected $settings;
	protected $loader;
	/* @var translentor_Url_Converter */
	protected $url_converter;

	/* @var translentor_Languages */
	protected $translentor_languages;
	
	/**
	 * translentor_Automatic_Language_Detection constructor.
	 *
	 * Defines constants, adds hooks and deals with license page.
	 */
	public function __construct() {

		define( 'translentor_IN_ALD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		define( 'translentor_IN_ALD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

		
		require_once( translentor_IN_ALD_PLUGIN_DIR . 'includes/translentor-language.php' );

		
		$translentor                 = translentor_Translentor::get_translentor_instance();
        $this->loader        = $translentor->get_translentorelements( 'loader' );
		
		
		$this->loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_cookie_adding' );

		

		$this->loader->add_action('wp_footer', $this, 'activate_popup');
      


        
        $this->loader->add_filter( 'translentor_register_advanced_settings', $this, 'eliminate_no_border_from_setting_array', 10000, 1);
    }

  

    public function eliminate_no_border_from_setting_array($settings_array){
        foreach ($settings_array as $item => $value){
            unset($settings_array[$item]['no-border']);
        }

        return $settings_array;
    }

	/**
	 * Enqueue script on all front-end pages
	 */
	public function enqueue_cookie_adding() {

		$translentor_language_cookie_data = $this->get_language_cookie_data();
        if ( apply_filters( 'translentor_translentor_enqueue_redirecting_script', true ) ) {
            wp_enqueue_script( 'translentor-language-cookie', translentor_IN_ALD_PLUGIN_URL . 'assets/js/translentor-language-cookie.min.js', array( 'jquery' ), translentor_IN_ALD_PLUGIN_VERSION );
            wp_localize_script( 'translentor-language-cookie', 'translentor_language_cookie_data', $translentor_language_cookie_data );
        }

        $translentor_settings = get_option('translentor_settings_elementor');
        if($translentor_settings['popup_option'] == 'popup') {
            wp_register_style( 'translentor-popup-style', translentor_IN_ALD_PLUGIN_URL . 'assets/css/translentor-popup.min.css' );
            wp_enqueue_style( 'translentor-popup-style' );
        }
	}


	/**
	 * Returns site data useful for determining language from url
	 *
	 * @return array
	 */
	public function get_language_cookie_data() {
		$translentor = translentor_Translentor::get_translentor_instance();
		if ( ! $this->url_converter ) {
			$this->url_converter = $translentor->get_translentorelements( 'lang_url' );
		}
		if ( ! $this->settings ) {
			
			$this->settings = get_option('translentor_settings_elementor');
		}
		if ( ! $this->translentor_languages ) {
			$this->translentor_languages = $translentor->get_translentorelements( 'languages' );
		}
		

        $language_urls = array();
		$is_google='no';
		global $wp;
		if(get_option('manual_translation')=='yes' || get_option('deepl_translation')=='yes'){
			foreach( get_option('translentor_settings_elementor')['translentor_lang'] as $language ){
				$language_urls[ $language ] = esc_url( $this->url_converter->get_url_for_language( $language, null, '' ) );
			   
			}
		}
		if(get_option('google_translation')=='yes'){
			$is_google='yes';
			foreach( get_option('translentor_settings_elementor')['translentor_lang'] as $language ){
			   $language_urls[ $language ]= esc_url(home_url($wp->request).'/#googtrans(en|'.$language.')');
			}
		}
       

		$data = array(
			'abs_home'          => $this->url_converter->get_abs_home(),
			'url_slugs'         => $this->settings['translentor-lang-slugs'],
			'cookie_name'       => 'translentor',
			'cookie_age'        => '30',
			'cookie_path'       => COOKIEPATH,
			'default_language'  => $this->settings['translentor-default-language'] ,
			'publish_languages' => $this->settings['translentor_lang'],
			'translentor_translentor_ajax_url'  => apply_filters( 'translentor_translentor_ajax_url', translentor_IN_ALD_PLUGIN_URL . 'includes/translentor-ip-ajax.php' ),
			'detection_method'  => $this->settings['detection_method'],
			'popup_option'      => $this->settings['popup_option'],
            'popup_type'        => $this->settings['popup_type'],
            'popup_textarea'    => $this->settings['popup_textarea'],
            'popup_textarea_change_button' => $this->settings['popup_textarea_button'],
            'popup_textarea_close_button' =>$this->settings['popup_textarea_close_button'],
			'iso_codes'         => $this->settings['translentor-lang-slugs'],
            'language_urls'     => $language_urls,
            'english_name'      => $this->translentor_languages->get_language_names($this->settings['translentor_lang']),
            'is_google'         => $is_google
		);
	
		 
		return apply_filters( 'translentor_language_cookie_data', $data );
	}

	public function activate_popup(){
	    require_once(translentor_IN_ALD_PLUGIN_DIR .'partials/translentor-ip-popup.php');
    }

    
}
