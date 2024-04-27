<?php

use Elementor\Plugin;
class translentor_Translentor{
    protected $loader;
    protected $settings;
    protected $translation_render;
    protected $query;
    protected $language_switcher;
    protected $translation_manager;
    protected $editor_api_regular_strings;
    protected $editor_api_gettext_strings;
    protected $machine_translator;
    protected $lang_url;
    protected $languages;
    protected $slug_manager;
    protected $plugin_updater;
    protected $translation_memory;
    protected $string_translation;
    protected $search;
    protected $rewrite_rules;
    protected $check_invalid_text;
    public static $Translentor = null;

    public static function get_translentor_instance(){
        if ( self::$Translentor == null ){
            self::$Translentor = new translentor_Translentor();
        }

        return self::$Translentor;
    }

    
    public function __construct() {
       
        define( 'translentor_PLUGIN_BASE', plugin_basename( __DIR__ . '/translentor.php' ) );
   

        
        if(empty(get_option('translentor_settings_elementor')))
        {
        $default = 'en';
        if ( empty( $default ) ){
            $default = 'en';
        }
        $default_settings = array(
            'translentor-default-language'                     => $default,
            'translentor_lang'                => array( $default ),
            'translentor_publish-lang'        => array( $default ),
            'translentor-lang-native-name'    => 'english_name',
            'translentor-lang-slugs'          => array( 'en' => 'en', '' ),
            'translentor-subdirectory-default-lang'=>'no',
        );
        update_option('translentor_settings_elementor',$default_settings);
    }
   
        $this->load_dependencies();
        $this->initialize_components();
        $this->define_admin_hooks();
        $this->define_frontend_hooks();

        $this->register_modules();
        
        $this->load_styles();
		$this->load_scripts();
    
     
        if(count(get_option('translentor_settings_elementor')['translentor_lang'])===1){

            require_once( ABSPATH . 'wp-includes/load.php' );
                              
                                foreach(get_option('translentor_settings_elementor')['translentor_lang'] as $lang_code)
                                {
                                    if ( get_option('translentor_settings_elementor')['translentor-default-language'] == $lang_code ) {
                                        $this->query ->check_table( get_option('translentor_settings_elementor')['translentor-default-language'], $lang_code );
                                 }
                                 $this->query ->check_gettext_table( $lang_code );
                                }
                                    
                                    
                                $this->query ->check_original_table();
                                $this->query ->check_original_meta_table();
    
            // // regenerate permalinks in case something changed
            flush_rewrite_rules();
           }
       // }
    
    }

  
    public function get_translentorelements( $elements ){
        return $this->$elements;
    }

    protected function load_dependencies() {
   
        require_once translentor_DIR . 'translentor/classes/translentor-manager.php';
        require_once translentor_DIR . 'translentor/classes/translentor-normal-strings.php';
        require_once translentor_DIR . 'translentor/classes/translentor-gettextstrings.php';
        require_once translentor_DIR . 'translentor/classes/translentor-hooks.php';
        require_once translentor_DIR . 'translentor/classes/translentor-lang.php';
        require_once translentor_DIR . 'translentor/classes/translentor-render.php';
        require_once translentor_DIR . 'translentor/classes/translentor-switcher.php';
        require_once translentor_DIR . 'translentor/classes/translentor-query.php';
        require_once translentor_DIR . 'translentor/classes/translentor-url.php';
        require_once translentor_DIR . 'translentor/classes/translentor-uri.php';
        require_once translentor_DIR . 'translentor/classes/translentor-compatibility.php';
        require_once translentor_DIR . 'translentor/classes/translentor-database.php';
        require_once translentor_DIR . 'translentor/classes/translentor-external-functions.php';
        require_once translentor_DIR . 'translentor/classes/translentor-functions.php';
        require_once translentor_DIR . 'translentor/lib/simplehtmldom/simple_html_dom.php';
        require_once translentor_DIR . 'translentor/classes/translentor-shortcodes.php';
        require_once translentor_DIR . 'translentor/editor/translentor-translation.php';
        require_once translentor_DIR . 'translentor/editor/translentor-translation-helper.php';
        require_once translentor_DIR . 'translentor/classes/translentor-search.php';
        require_once translentor_DIR . 'translentor/classes/translentor-rewrite.php';
        require_once translentor_DIR . 'translentor/classes/translentor-validate-text.php';
        require_once translentor_DIR . 'translentor/classes/translentormachine.php';
         
    }

    /**
     * Instantiates components.
     */
    protected function initialize_components() {
        
   
        $this->loader                     = new translentor_Hooks_Loader();
        $this->languages                  = new translentor_Languages();
  
        $this->translation_render         = new translentor_Translation_Render( get_option('translentor_settings_elementor') );
        $this->lang_url              = new translentor_Lang_Url( get_option('translentor_settings_elementor') );
        $this->language_switcher          = new translentor_Language_Switcher( get_option('translentor_settings_elementor'), $this );
        $this->query                      = new Lang_Query( get_option('translentor_settings_elementor') );
        $this->translation_manager        = new translentor_Translation_Manager( get_option('translentor_settings_elementor') );
        $this->editor_api_regular_strings = new translentor_Editor_Api_Regular_Strings( get_option('translentor_settings_elementor') );
        $this->editor_api_gettext_strings = new translentor_Editor_Api_Gettext_Strings( get_option('translentor_settings_elementor') );
        $this->translation_memory         = new translentor_Translation_Memory( get_option('translentor_settings_elementor') );
      
        $this->string_translation         = new translentor_String_Translation( get_option('translentor_settings_elementor'), $this->loader );
        $this->search                     = new translentor_Search( get_option('translentor_settings_elementor') );
        $this->rewrite_rules              = new translentor_Rewrite_Rules( get_option('translentor_settings_elementor') );
        $this->check_invalid_text         = new translentor_Check_Invalid_Text( );

        
        
    }

  

    /**
     * Hooks methods used in admin area.
     */
    protected function define_admin_hooks() {


        $this->loader->add_action( 'wp_ajax_nopriv_translentor_get_translations_regular', $this->editor_api_regular_strings, 'get_translations' );

	    $this->loader->add_action( 'wp_ajax_translentor_get_translations_regular', $this->editor_api_regular_strings, 'get_translations' );
        $this->loader->add_action( 'wp_ajax_translentor_save_translations_regular', $this->editor_api_regular_strings, 'save_translations' );
        $this->loader->add_action( 'wp_ajax_translentor_split_translation_block', $this->editor_api_regular_strings, 'split_translation_block' );
        $this->loader->add_action( 'wp_ajax_translentor_create_translation_block', $this->editor_api_regular_strings, 'create_translation_block' );
        //$this->editor_api_gettext_strings->gettext_get_translations();
	    $this->loader->add_action( 'wp_ajax_translentor_get_translations_gettext', $this->editor_api_gettext_strings, 'gettext_get_translations' );
	    $this->loader->add_action( 'wp_ajax_translentor_save_translations_gettext', $this->editor_api_gettext_strings, 'translentor_save_translations' );

        $this->loader->add_action( 'wp_ajax_translentor_get_similar_string_translation', $this->translation_memory, 'ajax_get_similar_string_translation' );

	    $this->loader->add_filter( 'translentor_get_existing_translations', $this->translation_manager, 'display_possible_db_errors', 20, 3 );
        $this->loader->add_action( 'wp_ajax_translentor_save_editor_user_meta', $this->translation_manager, 'save_editor_user_meta', 10 );


        $this->loader->add_action( 'wp_ajax_translentor_process_js_strings_in_translation_editor', $this->translation_render, 'process_js_strings_in_translation_editor' );
        $this->loader->add_filter( 'translentor_skip_selectors_from_dynamic_translation', $this->translation_render, 'skip_base_attributes_from_dynamic_translation', 10, 1 );


        $this->loader->add_filter( 'mod_rewrite_rules', $this->rewrite_rules, 'translentor_remove_language_param', 100 );
          if(get_option('manual_translation')=='yes' || get_option('deepl_translation')=='yes')
        {
        add_action( 'elementor/editor/before_enqueue_scripts', [$this, 'translentor_enqueue_scripts'] );
        
        add_action('wp_enqueue_scripts', [$this, 'translentor_enqueue_styles']);
        }
        					
    }

 
    protected function define_frontend_hooks(){

      
        if( isset( $_REQUEST['doing_wp_cron'] ) )
            return;

        $this->loader->add_action( 'init', $this->translation_render, 'start_output_buffer', apply_filters( 'translentor_start_output_buffer_priority', 0 ) );
        $this->loader->add_action( 'wp_enqueue_scripts', $this->translation_render, 'enqueue_scripts', 10 );
        $this->loader->add_action( 'wp_enqueue_scripts', $this->translation_render, 'enqueue_dynamic_translation', 1 );
        $this->loader->add_filter( 'wp_redirect', $this->translation_render, 'translentor_force_preview_on_url_redirect', 99, 2 );
        $this->loader->add_filter( 'wp_redirect', $this->translation_render, 'translentor_force_language_on_form_url_redirect', 99, 2 );
        $this->loader->add_filter( 'translentor_before_translate_content', $this->translation_render, 'force_preview_on_url_in_ajax', 10 );
        $this->loader->add_filter( 'translentor_before_translate_content', $this->translation_render, 'force_form_language_on_url_in_ajax', 20 );
        /* String Replacement from string */
        $this->loader->add_filter( "translentor_before_translate_content", $this->translation_render, 'handle_cdata', 1000 );
        $this->loader->add_action( "translentor_set_translation_for_attribute", $this->translation_render, 'translate_image_srcset_attributes', 10, 3 );
        $this->loader->add_filter( "translentor_allow_machine_translation_for_string", $this->translation_render, 'allow_machine_translation_for_string', 10, 4 );
        $this->loader->add_filter( "translentor_allow_machine_translation_for_string", $this->translation_render, 'skip_automatic_translation_for_no_auto_translation_selector', 10, 5 );
        $this->loader->add_action( "init", $this->translation_render, 'add_callbacks_for_translating_rest_api', 10, 4 );
        $this->loader->add_filter( "oembed_response_data", $this->translation_render, 'oembed_response_data', 10, 4 );

        /* add custom containers for post content and pots title so we can identify string that are part of them */
        $this->loader->add_filter( "the_content", $this->translation_render, 'wrap_with_post_id', 1000 );
        $this->loader->add_filter( "the_title", $this->translation_render, 'wrap_with_post_id', 1000, 2 );

        $this->loader->add_action( 'translentor_translation_manager_footer', $this->translation_manager, 'enqueue_scripts_and_styles' );
        $this->loader->add_filter( 'template_include', $this->translation_manager, 'translation_editor', 99999 );
        $this->loader->add_filter( 'option_date_format', $this->translation_manager, 'filter_the_date' );

        
        $this->loader->add_action( 'admin_head', $this->translation_manager, 'add_styling_to_admin_bar_button', 10 );
        $this->loader->add_filter( 'show_admin_bar', $this->translation_manager, 'hide_admin_bar_when_in_editor', 90 );

        $this->loader->add_filter( 'template_include', $this->string_translation, 'string_translation_editor', 99999 );
        $this->loader->add_filter( 'translentor_string_types', $this->string_translation, 'register_string_types', 10, 1 );
        $this->loader->add_filter( 'translentor_editor_nonces', $this->string_translation, 'add_nonces_for_saving_translation', 10, 1 );
        $this->loader->add_action( 'translentor_string_translation_editor_footer', $this->string_translation, 'enqueue_scripts_and_styles' );


        $this->loader->add_filter( 'home_url', $this->lang_url, 'add_language_to_home_url', 1, 4 );
        $this->loader->add_action( 'wp_head', $this->lang_url, 'add_hreflang_to_head' );
        $this->loader->add_filter( 'language_attributes', $this->lang_url, 'change_lang_attr_in_html_tag', 10, 1 );
        $this->loader->add_filter('translentor_is_file', $this->lang_url, 'does_url_contains_array', 10, 2);


        $this->loader->add_filter( 'widget_text', null, 'do_shortcode', 11 );
        $this->loader->add_filter( 'widget_text', null, 'shortcode_unautop', 11 );

        /* handle dynamic texts with gettext */
        $this->loader->add_filter( 'locale', $this->languages, 'change_locale', 99999 );
        $this->loader->add_filter( 'plugin_locale', $this->languages, 'change_locale', 99999 );

        $this->loader->add_action( 'init', $this->translation_manager, 'create_gettext_translated_global' );
        $this->loader->add_action( 'init', $this->translation_manager, 'initialize_gettext_processing' );
        $this->loader->add_action( 'translentor_call_gettext_filters', $this->translation_manager, 'verify_locale_of_loaded_textdomain' );
        if(get_option('deepl_translation')=='yes')
        {
        $this->loader->add_action( 'plugins_loaded', $this, 'init_machine_translation', 2 );
        }

        /* we need to treat the date_i18n function differently so we remove the gettext wraps */
        $this->loader->add_filter( 'date_i18n', $this->translation_manager, 'handle_date_i18n_function_for_gettext', 1, 4 );
	    /* strip esc_url() from gettext wraps */
	    $this->loader->add_filter( 'clean_url', $this->translation_manager, 'translentor_strip_gettext_tags_from_esc_url', 1, 3 );
	    /* strip sanitize_title() from gettext wraps and apply custom translentor_remove_accents */
	    $this->loader->add_filter( 'sanitize_title', $this->translation_manager, 'translentor_sanitize_title', 1, 3 );
        $this->loader->add_filter( 'translentor_language_name', $this->languages, 'beautify_language_name', 10, 4 );
        $this->loader->add_filter( 'translentor_languages', $this->languages, 'reorder_languages', 10, 2 );

        /* set up wp_mail hooks */
        $this->loader->add_filter( 'wp_mail', $this->translation_render, 'wp_mail_filter', 1 );

        /* hide php ors and notice when we are storing strings in db */
        $this->loader->add_action( 'init', $this->translation_render, 'translentor_debug_mode_off', 0 );

        /* fix wptexturize to always replace with the default translated strings */
        $this->loader->add_action( 'gettext_with_context', $this->translation_render, 'fix_wptexturize_characters', 999, 4 );

        $this->loader->add_filter( "option_rewrite_rules", $this->lang_url, 'woocommerce_filter_permalinks_on_other_languages' );
        $this->loader->add_filter( "option_woocommerce_permalinks", $this->lang_url, 'woocommerce_filter_permalink_option' );
        $this->loader->add_filter( "pre_update_option_woocommerce_permalinks", $this->lang_url, 'prevent_permalink_update_on_other_languages', 10, 2 );
        $this->loader->add_filter( "pre_update_option_rewrite_rules", $this->lang_url, 'prevent_permalink_update_on_other_languages', 10, 2 );

        /* add to the body class the current language */
        $this->loader->add_filter( "body_class", $this->translation_manager, 'add_language_to_body_class' );

  

    

        //search
        $this->loader->add_filter( 'pre_get_posts', $this->search, 'translentor_search_filter', 99999999 );
        $this->loader->add_filter( 'get_search_query', $this->search, 'translentor_search_query', 10 );

      
        
        

    }
  
        public function register_modules()
    	{
    	    add_action( 'elementor/widgets/widgets_registered', function() 
            {
				//find our module directory
                require translentor_DIR . 'translentor/website-translator/widget.php';
                
            });
    	}
        public function load_scripts()
        {
            add_action( 'elementor/frontend/after_register_scripts', array( $this, 'widget_js' ) );
            
        }
        
        public function widget_js()
        {
            if(get_option('google_translation')=='yes')
            {
                wp_enqueue_script( 'translentor-website-translator', translentor_URL . 'translentor/assets/js/translentor-js.min.js',
            array( 'jquery' ),
            translentor_VERSION,true);
            }
            if(get_option('manual_translation')=='yes' || get_option('deepl_translation')=='yes'){
        	wp_enqueue_script( 'translentor-website-translator', translentor_URL . 'translentor/assets/js/translentor-translentor-js.min.js',
            array( 'jquery' ),
            translentor_VERSION,true);
            }


            wp_enqueue_script( 'translentor-website-translator-toast', translentor_URL . 'translentor/assets/js/jquery.toast.min.js',
            array( 'jquery' ),
            translentor_VERSION,true);
            


        }
        
        public function load_styles() 
        {
        	// Register Widget Styles
        	add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'widget_styles' ) );
            
        }
        
        public function widget_styles() 
        {
        	if(get_option('google_translation')=='yes')
            {
                wp_enqueue_style( 'translentor-website-translator', translentor_URL . 'translentor/assets/css/translentor-css.min.css',
            array(),
            translentor_VERSION);
            }
            if(get_option('manual_translation')=='yes' || get_option('deepl_translation')=='yes'){
        	wp_enqueue_style( 'translentor-website-translator', translentor_URL . 'translentor/assets/css/translentor-translentor-css.min.css',
            array(),
            translentor_VERSION);
            }
			wp_enqueue_style( 'translentor-website-toast', translentor_URL . 'translentor/assets/css/jquery.toast.min.css',
            array(),
            translentor_VERSION );
//Bottom Sheet...
          
        }
    
    public function translentor_enqueue_scripts(){
       
        if ( Plugin::$instance->editor->is_edit_mode() ) {
            $current_url = get_permalink( get_the_ID() );
        
if( is_category() ) $current_url = get_category_link( get_query_var( 'cat' ) );

        } else {
           // not edit mode
       }
       wp_register_script( 'translentor-website-translatorsection_template-js', translentor_URL . 'translentor/assets/js/translentor-section_template.min.js', array( 'jquery' ), translentor_VERSION, true );
        wp_localize_script('translentor-website-translatorsection_template-js','localize',[
            'url' => $current_url."?translentor-editor=true",
            
        ]);
        wp_enqueue_script('translentor-website-translatorsection_template-js');
        
       
       

    }
    public function translentor_enqueue_styles(){
     
             wp_enqueue_style(
            'translentor-website-translatorsection_template-css',
            translentor_URL . 'translentor/assets/css/translentor-section_template.min.css',
            translentor_VERSION
        );
        
    }
   
    public function run() {
        
    
     
            
        
    	$run_translentor = apply_filters( 'translentor_allow_translentor_to_run', true );
    	if ( $run_translentor ) {
		    $this->loader->run();
	   
    }
    }

    public function init_machine_translation(){
        
         $this->machine_translator = $this->get_active_engine();
     }
     public function get_active_engine( ){
        // This $default is just a fail safe. Should never be used. The real default is set in translentor_Settings->set_options function
        //$default = 'translentor_Google_Translate_V2_Machine_Translator';

            $deepl_class_name = class_exists('translentor_IN_Deepl_Machine_Translator' ) ? 'translentor_IN_Deepl_Machine_Translator' : 'translentor_Deepl_Machine_Translator';
            $existing_engines = apply_filters('translentor_automatic_translation_engines_classes', array(
              
                'deepl'               => $deepl_class_name
            ));

            $value = 'translentor_IN_Deepl_Machine_Translator';

            // if( !class_exists( $value ) ) {
            //     $value = $default; //something is wrong if it reaches this
            // }
      

        return new $value( get_option('translentor_settings_elementor') );
    }
    
}
