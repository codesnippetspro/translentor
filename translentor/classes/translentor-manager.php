<?php

/**
 * Class translentor_Translation_Manager
 *
 * Handles Front-end Translation Editor, including Ajax requests.
 */
use Elementor\Plugin;
class translentor_Translation_Manager
{
    protected $settings;
    /** @var translentor_Translation_Render */
    protected $translation_render;
    /** @var Lang_Query */
    protected $lang_query;
    protected $machine_translator;
    protected $slug_manager;
    protected $lang_url;
    protected $translentor_languages;
    protected $is_admin_request = null;

    /**
     * translentor_Translation_Manager constructor.
     *
     * @param array $settings Settings option.
     */
    public function __construct($settings)
    {
        $this->settings = $settings;
    }

    // mode == true, mode == preview

    /**
     * Returns boolean whether current page is part of the Translation Editor.
     *
     * @param string $mode 'true' | 'preview'
     * @return bool                 Whether current page is part of the Translation Editor.
     */
    protected function conditions_met($mode = 'true')
    {
        if (isset($_REQUEST['translentor-editor']) && sanitize_text_field($_REQUEST['translentor-editor']) == $mode) {
            if (current_user_can(apply_filters('translentor_translating_capability', 'manage_options')) && !is_admin()) {
                return true;
            } elseif (sanitize_text_field($_REQUEST['translentor-editor']) == "preview") {
                return true;
            } else {
                wp_die(
                    '<h1>' . esc_html__('Cheatin&#8217; uh?') . '</h1>' . //phpcs:ignore  WordPress.WP.I18n.MissingArgDomain
                    '<p>' . esc_html__('Sorry, you are not allowed to access this page.') . '</p>', //phpcs:ignore  WordPress.WP.I18n.MissingArgDomain
                    403
                );
            }
        }
        return false;
    }

    /**
     * Start Translation Editor.
     *
     * Hooked to template_include.
     *
     * @param string $page_template Current page template.
     * @return string                       Template for translation Editor.
     */
    public function translation_editor($page_template)
    {
        if (!$this->conditions_met()) {
            return $page_template;
        }

        return translentor_DIR . 'translentor/manager/translation-manager.php';
    }

    public function get_merge_rules()
    {
        $localized_text = $this->string_groups();

        $merge_rules = array(
            'top_parents' => array('p', 'div', 'li', 'ol', 'ul', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'h7', 'body', 'footer', 'article', 'main', 'iframe', 'section', 'figure', 'figcaption', 'blockquote', 'cite', 'tr', 'td', 'th', 'table', 'tbody', 'thead', 'tfoot', 'form'),
            'self_object_type' => array('translentor-element'),
            'incompatible_siblings' => array('[data-translentorgettextoriginal]', '[data-translentor-node-group="' . $localized_text['dynamicstrings'] . '"]')
        );

        return apply_filters('translentor_merge_rules', $merge_rules);
    }

    public function localized_text()
    {


        return $this->string_groups() + array(
                // attribute names
                
                'text' => esc_html__('Text', 'translentor'),

                'saved' => esc_html__('Saved', 'translentor'),
                'save_translation' => esc_html__('Save', 'translentor'),
                'saving_translation' => esc_html__('Saving', 'translentor'),
                'unsaved_changes' => esc_html__('Unsaved', 'translentor'),
                'discard' => esc_html__('Cancel', 'translentor'),
                'discard_all' => esc_html__('Discard All', 'translentor'),
            
                'close' => esc_attr__('Close', 'translentor'),
                'from' => esc_html__('Default:', 'translentor'),
                'to' => esc_html__('Other:', 'translentor'),
                'other_lang' => esc_html__('More', 'translentor'),
             
                // title attributes
                'edit' => esc_attr__('Edit', 'translentor'),
                'merge' => esc_attr__('Merge', 'translentor'),
                'split' => esc_attr__('Split', 'translentor'),
                
                
                
               
                'discard_individual_changes_title_attribute' => esc_attr__('Discard changes to this text box. To discard changes to all text boxes use shortcut: CTRL(⌘) + ALT + Z', 'translentor'),
             
               

                'split_confirmation' => esc_js(__('Are you sure you want to split this phrase into smaller parts?', 'translentor')),
                'translation_not_loaded_yet' => wp_kses(__('This string is not ready for translation yet. <br>Try again in a moment...', 'translentor'), array('br' => array()))

            
              
            );
    }

   

    public function get_default_editor_user_meta()
    {
        return apply_filters('translentor_default_editor_user_meta', array(
            'helpPanelOpened' => false,
            'dismissTooltipSave' => false,
            'dismissTooltipNext' => false,
            'dismissTooltipPrevious' => false,
            'dismissTooltipDismissAll' => false,
        ));
    }

    public function get_editor_user_meta()
    {
        $user_meta = get_user_meta(get_current_user_id(), 'translentor_editor_user_meta', true);
        $user_meta = wp_parse_args($user_meta, $this->get_default_editor_user_meta());
        return apply_filters('translentor_editor_user_meta', $user_meta);
    }

    public function save_editor_user_meta()
    {
        if (defined('DOING_AJAX') && DOING_AJAX && current_user_can(apply_filters('translentor_translating_capability', 'manage_options'))) {
            check_ajax_referer('translentor_editor_user_meta', 'security');
            if (isset($_POST['action']) && $_POST['action'] === 'translentor_save_editor_user_meta' && !empty($_POST['user_meta'])) {
                $submitted_user_meta = json_decode(stripslashes($_POST['user_meta']), true); /* phpcs:ignore */ /* sanitized bellow */
                $existing_user_meta = $this->get_editor_user_meta();
                foreach ($existing_user_meta as $key => $existing) {
                    if (isset($submitted_user_meta[$key])) {
                        $existing_user_meta[$key] = (bool)$submitted_user_meta[$key];
                    }
                }
                update_user_meta(get_current_user_id(), 'translentor_editor_user_meta', $existing_user_meta);
            }
        }
        echo translentor_safe_json_encode(array());//phpcs:ignore
        die();
    }

    public function string_groups()
    {
        $string_groups = array(
            'slugs' => esc_html__('Slugs', 'translentor'),
            'metainformation' => esc_html__('Meta Information', 'translentor'),
            'stringlist' => esc_html__('String List', 'translentor'),
            'gettextstrings' => esc_html__('Gettext Strings', 'translentor'),
            'images' => esc_html__('Images', 'translentor'),
            'dynamicstrings' => esc_html__('Dynamically Added Strings', 'translentor'),
        );
        return apply_filters('translentor_string_groups', $string_groups);
    }

    public function editor_nonces()
    {
        $nonces = array(
            'gettranslationsnonceregular' => wp_create_nonce('get_translations'),
            'savetranslationsnonceregular' => wp_create_nonce('save_translations'),
            'gettranslationsnoncegettext' => wp_create_nonce('gettext_get_translations'),
            'savetranslationsnoncegettext' => wp_create_nonce('translentor_save_translations'),
            'gettranslationsnoncepostslug' => wp_create_nonce('postslug_get_translations'),
            'savetranslationsnoncepostslug' => wp_create_nonce('postslug_save_translations'),
            'splittbnonce' => wp_create_nonce('split_translation_block'),
            'mergetbnonce' => wp_create_nonce('merge_translation_block'),
            'logged_out' => wp_create_nonce('translentor_view_aslogged_out' . get_current_user_id()),
            'getsimilarstring' => wp_create_nonce('getsimilarstring'),
            'translentor_editor_user_meta' => wp_create_nonce('translentor_editor_user_meta')
        );

        return apply_filters('translentor_editor_nonces', $nonces);
    }

    /**
     * Navigation tabs for Website editing, Url Slugs, String Translation
     *
     * @return array
     */
    public function get_editors_navigation()
    {
        return apply_filters('translentor_editors_navigation', array(
            'show' => false,
            'tabs' => array(
                array(
                    'handle' => 'visualeditor',
                    'label' => __('Visual Editor', 'translentor'),
                    'path' => add_query_arg('translentor-editor', 'true', home_url()),
                    'tooltip' => 'Edit translations by visually selecting them on each site page'
                ),
                array(
                    'handle' => 'stringtranslation',
                    'label' => __('String Translation', 'translentor'),
                    'path' => add_query_arg('translentor-string-translation', 'true', home_url()) . '#/slugs/',
                    'tooltip' => 'Edit url slug translations'
                )
            )
        ));
    }

    /**
     * Enqueue scripts and styles for translation Editor parent window.
     *
     * hooked to translentor_translation_manager_footer
     */
    public function enqueue_scripts_and_styles()
    {
        wp_enqueue_style('translentor-editor-style', translentor_URL . 'translentor/assets/css/translentor-editor.min.css', array('dashicons', 'buttons'), translentor_VERSION);
        wp_enqueue_script('translentor-editor', translentor_URL . 'translentor/assets/js/translentor-editor.min.js', array(), translentor_VERSION);

        wp_localize_script('translentor-editor', 'translentor_editor_data', $this->get_translentor_editor_data());


        // Show upload media dialog in default language
        switch_to_locale($this->settings['translentor-default-language']);
        // Necessary for add media button
        wp_enqueue_media();

        // Necessary for add media button
        wp_print_media_templates();
        restore_current_locale();

        // Necessary for translate-dom-changes to have a nonce as the same user as the Editor.
        // The Preview iframe (which loads translate-dom-changes script) can load as logged out which sets an different nonce
        $nonces = $this->editor_nonces();
        wp_add_inline_script('translentor-editor', 'var translentor_dynamic_nonce = "' . $nonces['gettranslationsnonceregular'] . '";');

        $scripts_to_print = apply_filters('translentor-scripts-for-editor', array('jquery', 'jquery-ui-core', 'jquery-effects-core',  'translentor-editor'));
        $styles_to_print = apply_filters('translentor-styles-for-editor', array('dashicons', 'translentor-editor-style', 'media-views', 'imgareaselect', 'buttons'));
        wp_print_scripts($scripts_to_print);
        wp_print_styles($styles_to_print);

        // Necessary for add media button
        print_footer_scripts();

    }

    /**
     * Localize all the data needed by the translation editor
     *
     * @return array
     */
    public function get_translentor_editor_data()
    {
        global $translentor_LANGUAGE;
        $translentor = translentor_Translentor::get_translentor_instance();
        $translentor_languages = $translentor->get_translentorelements('languages');
        $translation_render = $translentor->get_translentorelements('translation_render');
        $lang_url = $translentor->get_translentorelements('lang_url');

        $language_names = $translentor_languages->get_language_names(get_option('translentor_settings_elementor')['translentor_lang']);

        // move the current language to the beginning of the array
        $translation_languages = get_option('translentor_settings_elementor')['translentor_lang'];
        if ($translentor_LANGUAGE != $this->settings['translentor-default-language']) {
            $current_language_key = array_search($translentor_LANGUAGE, get_option('translentor_settings_elementor')['translentor_lang']);
            unset($translation_languages[$current_language_key]);
            $translation_languages = array_merge(array($translentor_LANGUAGE), array_values($translation_languages));
        }
        $default_language_key = array_search($this->settings['translentor-default-language'], $translation_languages);
        unset($translation_languages[$default_language_key]);
        $ordered_secondary_languages = array_values($translation_languages);

        $current_language_published = (in_array($translentor_LANGUAGE, $this->settings['translentor_publish-lang']));
        $current_url = $lang_url->cur_page_url();

        $selectors = $translation_render->get_accessors_array('-'); // suffix selectors such as array( '-alt', '-src', '-title', '-content', '-value', '-placeholder', '-href', '-outertext', '-innertext' )
        $selectors[] = '';                                              // empty string suffix added for using just the base attribute data-translentor-translate-id  (instead of data-translentor-translate-id-alt)
        $data_attributes = $translation_render->get_base_attribute_selectors();

        

       
        $string_groups = apply_filters('translentor_string_group_order', array_values($this->string_groups()));


        $editors_navigation = $this->get_editors_navigation();
        $string_types = array('regular', 'gettext', 'postslug');


        $translentor_editor_data = array(
            'translentor_localized_strings' => $this->localized_text(),
            'translentor_settings' => $this->settings,
            'language_names' => $language_names,
            'ordered_secondary_languages' => $ordered_secondary_languages,
            'current_language' => $translentor_LANGUAGE,
            'on_screen_language' => (isset($ordered_secondary_languages[0])) ? $ordered_secondary_languages[0] : '',
            'url_to_load' => add_query_arg('translentor-editor', 'preview', $current_url),
            'string_selectors' => $selectors,
            'data_attributes' => $data_attributes,
            'editor_nonces' => $this->editor_nonces(),
            'ajax_url' => apply_filters('translentor_wp_ajax_url', admin_url('admin-ajax.php')),
            'string_types' => apply_filters('translentor_string_types', $string_types),
            'string_group_order' => $string_groups,
            'merge_rules' => $this->get_merge_rules(),
            'editors_navigation' => $editors_navigation,
            'user_meta' => $this->get_editor_user_meta(),
        );

        return apply_filters('translentor_editor_data', $translentor_editor_data);
    }

  

   
    public function add_styling_to_admin_bar_button()
    {
        echo "<style type='text/css'> #wpadminbar #wp-admin-bar-translentor_edit_translation .ab-icon:before {    content: '\\f326';    top: 3px;}
		#wpadminbar #wp-admin-bar-translentor_edit_translation > .ab-item {
			text-indent: 0;
		}

		#wpadminbar li#wp-admin-bar-translentor_edit_translation {
			display: block;
		}</style>";
    }


    /**
     * Function to hide admin bar when in editor preview mode.
     *
     * Hooked to show_admin_bar.
     *
     * @param bool $show_admin_bar TRUE | FALSE
     * @return bool
     */
    public function hide_admin_bar_when_in_editor($show_admin_bar)
    {

        if ($this->conditions_met('preview')) {
            return false;
        }

        return $show_admin_bar;

    }

    /**
     * Create a global with the gettext strings that exist in the database
     */
    public function create_gettext_translated_global()
    {


        global $translentor_translated_gettext_texts, $translentor_translated_gettext_texts_language;
        if ( $this->processing_gettext_is_needed() ){
            $language = get_locale();

            if ( in_array( $language, get_option('translentor_settings_elementor')['translentor_lang'] ) ) {
                $translentor_translated_gettext_texts_language = $language;
                $translentor = translentor_Translentor::get_translentor_instance();
                if ( !$this->lang_query ) {
                    $this->lang_query = $translentor->get_translentorelements( 'query' );
                }

                $strings = $this->lang_query->get_all_gettext_strings( $language );
                if ( !empty( $strings ) ) {
                    $translentor_translated_gettext_texts = $strings;

                    foreach ( $translentor_translated_gettext_texts as $key => $value ) {
                        $translentor_strings[ $value['domain'] . '::' . $value['original'] ] = $value;
                    }
                    $translentor_translated_gettext_texts = $translentor_strings;
                }
            }
        }
    }

    /**
     * function that applies the gettext filter on frontend on different hooks depending on what we need
     */
    public function initialize_gettext_processing()
    {
        $is_ajax_on_frontend = $this::is_ajax_on_frontend();

        /* on ajax hooks from frontend that have the init hook ( we found WooCommerce has it ) apply it earlier */
        if ($is_ajax_on_frontend || apply_filters( 'translentor_apply_gettext_early', false ) ) {
            add_action('wp_loaded', array($this, 'apply_gettext_filter'));
        } else {//otherwise start from the wp_head hook
            add_action('wp_head', array($this, 'apply_gettext_filter'), 100);
        }

        //if we have woocommerce installed and it is not an ajax request add a gettext hook starting from wp_loaded and remove it on wp_head
        if (class_exists('WooCommerce') && !$is_ajax_on_frontend && !apply_filters( 'translentor_apply_gettext_early', false ) ) {
            // WooCommerce launches some ajax calls before wp_head, so we need to apply_gettext_filter earlier to catch them
            add_action('wp_loaded', array($this, 'apply_woocommerce_gettext_filter'), 19);
        }
    }

    /* apply the gettext filter here */
    public function apply_gettext_filter()
    {

        //if we have wocommerce installed remove te hook that was added on wp_loaded
        if (class_exists('WooCommerce')) {
            // WooCommerce launches some ajax calls before wp_head, so we need to apply_gettext_filter earlier to catch them
            remove_action('wp_loaded', array($this, 'apply_woocommerce_gettext_filter'), 19);
        }

        $this->call_gettext_filters();

    }

    public function apply_woocommerce_gettext_filter()
    {
        $this->call_gettext_filters('woocommerce_');
    }

    public function processing_gettext_is_needed(){
        global $pagenow;

        if (!$this->lang_url) {
            $translentor = translentor_Translentor::get_translentor_instance();
            $this->lang_url = $translentor->get_translentorelements('lang_url');
        }
        if ($this->is_admin_request === null) {
            $this->is_admin_request = $this->lang_url->is_admin_request();
        }

        // Do not process gettext strings on wp-login pages. Do not process strings in admin area except for when when is_ajax_on_frontend. Do not process gettext strings when is rest api from admin url referer. Do not process gettext on xmlrpc.pho
        return (($pagenow != 'wp-login.php') && (!is_admin() || $this::is_ajax_on_frontend()) && !$this->is_admin_request && $pagenow != 'xmlrpc.php');
    }

    public function call_gettext_filters($prefix = '') {
        if ( $this->processing_gettext_is_needed() ){
            add_filter('gettext', array($this, $prefix . 'process_gettext_strings'), 100, 3);
            add_filter('gettext_with_context', array($this, $prefix . 'process_gettext_strings_with_context'), 100, 4);
            add_filter('ngettext', array($this, $prefix . 'process_ngettext_strings'), 100, 5);
            add_filter('ngettext_with_context', array($this, $prefix . 'process_ngettext_strings_with_context'), 100, 6);

            do_action('translentor_call_gettext_filters');
        }
    }

    public function is_domain_loaded_in_locale( $domain, $locale ){
        $localemo = $locale . '.mo';
        $length = strlen( $localemo );

        global $l10n;

        if ( isset( $l10n[$domain] ) && is_object( $l10n[$domain] ) && method_exists( $l10n[ $domain ], 'get_filename' ) ) {
            $mo_filename = $l10n[ $domain ]->get_filename();

            if ( is_string($mo_filename) ) {
                
                // $mo_filename does not end with string $locale
                if ( substr( strtolower( $mo_filename ), -$length ) == strtolower( $localemo ) ) {
                    return true;
                } else {
                    return false;
                }
            }
            return true;
        }

        // if something is not as expected, return true so that we do not interfere
        return true;
    }

    public function verify_locale_of_loaded_textdomain(){
        global $l10n;
        if ( !empty( $l10n) && is_array( $l10n ) ){

            $reload_domains = array();
            $locale = get_locale();


            foreach($l10n as $domain => $item ){
                if ( !$this->is_domain_loaded_in_locale( $domain, $locale ) ) {
                    $reload_domains[] = $domain;
                }
            }

            foreach($reload_domains as $domain ){
                if ( isset( $l10n[$domain] ) && is_object( $l10n[$domain] ) ) {
                    $path     = $l10n[ $domain ]->get_filename();
                    $new_path = preg_replace( '/' . $domain . '-(.*).mo$/i', $domain . '-' . $locale . '.mo', $path );
                    if ( $new_path !== $path ) {
                        unset( $l10n[ $domain ] );
                        load_textdomain( $domain, $new_path );
                    }
                }
            }
        }

        // do this function only once per execution. The init hook can be called more than once
        remove_action( 'translentor_call_gettext_filters', array( $this, 'verify_locale_of_loaded_textdomain' ) );
    }

    /**
     * Function that determines if an ajax request came from the frontend
     * @return bool
     */
    static function is_ajax_on_frontend()
    {

        /* for our own actions return false */
        if (isset($_REQUEST['action']) && strpos( sanitize_text_field( $_REQUEST['action'] ), 'translentor_') === 0)
            return false;

        $translentor = translentor_Translentor::get_translentor_instance();
        $lang_url = $translentor->get_translentorelements("lang_url");

        //check here for wp ajax or woocommerce ajax
        if ((defined('DOING_AJAX') && DOING_AJAX) || (defined('WC_DOING_AJAX') && WC_DOING_AJAX)) {
            $referer = '';
            if (!empty($_REQUEST['_wp_http_referer'])) {

                $referer_uri = wp_unslash(esc_url_raw($_REQUEST['_wp_http_referer']));
                $req_uri = $referer_uri;

                $home_path = trim(parse_url($lang_url->get_abs_home(), PHP_URL_PATH), '/');
                $home_path_regex = sprintf('|^%s|i', preg_quote($home_path, '|'));

                // Trim path info from the end and the leading home path from the front.
                $req_uri = ltrim($req_uri, '/');
                $req_uri = preg_replace($home_path_regex, '', $req_uri);
                $req_uri = trim($lang_url->get_abs_home(), '/') . '/' . ltrim($req_uri, '/');

                $referer = $req_uri;

            } elseif (!empty($_SERVER['HTTP_REFERER'])) {
                // this one is an actual URL that the browser sets.
                $referer = wp_unslash(esc_url_raw($_SERVER['HTTP_REFERER']));

            }

            //if the request did not come from the admin set propper variables for the request (being processed in ajax they got lost) and return true
            if ((strpos($referer, admin_url()) === false)) {
                translentor_Translation_Manager::set_vars_in_frontend_ajax_request($referer);
                return true;
            }
        }

        return false;
    }

    /**
     * Function that sets the needed vars in the ajax request. Beeing ajax the globals got reset and also the REQUEST globals
     * @param $referer
     */
    static function set_vars_in_frontend_ajax_request($referer)
    {

        /* for our own actions don't do nothing */
        if ( isset($_REQUEST['action']) && strpos( sanitize_text_field( $_REQUEST['action'] ), 'translentor_') === 0 )
            return;

        /* if the request came from preview mode make sure to keep it */
        if (strpos($referer, 'translentor-editor=preview') !== false && !isset($_REQUEST['translentor-editor'])) {
            $_REQUEST['translentor-editor'] = 'preview';
        }

      

        global $translentor_LANGUAGE;
        $translentor = translentor_Translentor::get_translentor_instance();
        $lang_url = $translentor->get_translentorelements('lang_url');
        $translentor_LANGUAGE = $lang_url->get_lang_from_url_string($referer);
        if (empty($translentor_LANGUAGE)) {
            // $settings_obj = new translentor_settings();
            $settings =get_option('translentor_settings_elementor');
            $translentor_LANGUAGE = $settings["translentor-default-language"];
        }
    }


    /**
     * Function that replaces the translations with the ones in the database if they are differnt, wrapps the texts in the html and
     * builds a global for machine translation with the strings that are not translated
     * @param $translation
     * @param $text
     * @param $domain
     * @return string
     */
    public function process_gettext_strings($translation, $text, $domain)
    {
        // if we have nested gettexts strip previous ones, and consider only the outermost
        $text = translentor_Translation_Manager::strip_gettext_tags($text);
        $translation = translentor_Translation_Manager::strip_gettext_tags($translation);

        //try here to exclude some strings that do not require translation
        $excluded_gettext_strings = array('', ' ', '&hellip;', '&nbsp;', '&raquo;');
        if (in_array(translentor_full_trim($text), $excluded_gettext_strings))
            return $translation;

        //set a global so we remember the last string we processed and if it is the same with the current one return a result immediately for performance reasons ( this could happen in loops )
        global $tp_last_gettext_processed;
        if (isset($tp_last_gettext_processed[$text . '::' . $domain]))
            return $tp_last_gettext_processed[$text . '::' . $domain];

        global $translentor_LANGUAGE;

        if ((isset($_REQUEST['translentor-editor']) && $_REQUEST['translentor-editor'] == 'true') || $domain == 'translentor')
            return $translation;

        /* for our own actions don't do nothing */
        if (isset($_REQUEST['action']) && strpos( sanitize_text_field( $_REQUEST['action'] ), 'translentor_') === 0)
            return $translation;

       
        $current_locale = get_locale();
        global $translentor_translated_gettext_texts_language;
        if ( !in_array($current_locale, get_option('translentor_settings_elementor')['translentor_lang'] ) || empty( $translentor_translated_gettext_texts_language) || $translentor_translated_gettext_texts_language !== $current_locale ) {
            return $translation;
        }

        if (apply_filters('translentor_skip_gettext_processing', false, $translation, $text, $domain))
            return $translation;

        //use a global for is_ajax_on_frontend() so we don't execute it multiple times
        global $tp_gettext_is_ajax_on_frontend;
        if (!isset($tp_gettext_is_ajax_on_frontend))
            $tp_gettext_is_ajax_on_frontend = $this::is_ajax_on_frontend();

        if (!defined('DOING_AJAX') || $tp_gettext_is_ajax_on_frontend) {
            if ( !$this->is_domain_loaded_in_locale($domain, $current_locale) ){
                $translation = $text;
            }

            $db_id = '';
            $skip_gettext_querying = apply_filters('translentor_skip_gettext_querying', false, $translation, $text, $domain);
            if (!$skip_gettext_querying) {
                global $translentor_translated_gettext_texts, $translentor_all_gettext_texts;

                $found_in_db = false;

                /* initiate translentor query object */
                if (!$this->lang_query) {
                    $translentor = translentor_Translentor::get_translentor_instance();
                    $this->lang_query = $translentor->get_translentorelements('query');
                }

                if (!isset($translentor_all_gettext_texts)) {
                    $translentor_all_gettext_texts = array();
                }

                if (!empty($translentor_translated_gettext_texts)) {
                    if (isset($translentor_translated_gettext_texts[$domain . '::' . $text])) {
                        $translentor_translated_gettext_text = $translentor_translated_gettext_texts[$domain . '::' . $text];

                        if (!empty($translentor_translated_gettext_text['translated']) && $translation != $translentor_translated_gettext_text['translated']) {
                            $translation = str_replace(trim($text), translentor_sanitize_string($translentor_translated_gettext_text['translated']), $text);
                        }
                        $db_id = $translentor_translated_gettext_text['id'];
                        $found_in_db = true;
                        // update the db if a translation appeared in the po file later
                        if (empty($translentor_translated_gettext_text['translated']) && $translation != $text) {
                            $this->lang_query->update_gettext_strings(array(
                                array(
                                    'id' => $db_id,
                                    'original' => $text,
                                    'translated' => $translation,
                                    'domain' => $domain,
                                    'status' => $this->lang_query->get_constant_human_reviewed()
                                )
                            ), $current_locale);
                        }
                    }
                }

                if (!$found_in_db) {
                    if (!in_array(array(
                        'original' => $text,
                        'translated' => $translation,
                        'domain' => $domain
                    ), $translentor_all_gettext_texts)
                    ) {
                        $translentor_all_gettext_texts[] = array(
                            'original' => $text,
                            'translated' => $translation,
                            'domain' => $domain
                        );
                        $db_id = $this->lang_query->insert_gettext_strings(array(
                            array(
                                'original' => $text,
                                'translated' => $translation,
                                'domain' => $domain
                            )
                        ), $current_locale);
                        /* insert it in the global of translated because now it is in the database */
                        $translentor_translated_gettext_texts[$domain . '::' . $text] = array(
                            'id' => $db_id,
                            'original' => $text,
                            'translated' => ($translation != $text) ? $translation : '',
                            'domain' => $domain
                        );
                    }
                }
                if(get_option('deepl_translation')=='yes')
                {
                $translentor = translentor_Translentor::get_translentor_instance();
                if (!$this->machine_translator) {
                    $this->machine_translator = $translentor->get_translentorelements('machine_translator');
                }
                if (!$this->translentor_languages) {
                    $this->translentor_languages = $translentor->get_translentorelements('languages');
                }
                $machine_translation_codes = get_option('translentor_settings_elementor')['translentor-lang-slugs'];
               
                /* We assume Gettext strings are in English so don't automatically translate into English */
                if ($machine_translation_codes[$translentor_LANGUAGE] != 'en'&& $this->machine_translator->is_available(array($translentor_LANGUAGE))) {
                
                    global $translentor_gettext_strings_for_machine_translation;
                    
                    if ($text == $translation) {
                        
                        foreach ($translentor_translated_gettext_texts as $translentor_translated_gettext_text) {
                            if ($translentor_translated_gettext_text['id'] == $db_id) {
                                if ($translentor_translated_gettext_text['translated'] == '' && !isset($translentor_gettext_strings_for_machine_translation[$db_id])) {
                                    $translentor_gettext_strings_for_machine_translation[$db_id] = array(
                                        'id' => $db_id,
                                        'original' => $text,
                                        'translated' => '',
                                        'domain' => $domain,
                                        'status' => $this->lang_query->get_constant_machine_translated()
                                    );
                                }
                                break;
                            }
                        }
                    }
                }
            }
            }

            $blacklist_functions = apply_filters('translentor_gettext_blacklist_functions', array(
                'wp_enqueue_script',
                'wp_enqueue_scripts',
                'wp_editor',
                'wp_enqueue_media',
                'wp_register_script',
                'wp_print_scripts',
                'wp_localize_script',
                'wp_print_media_templates',
                'get_bloginfo',
                'wp_get_document_title',
                'wp_title',
                'wp_trim_words',
                'sanitize_title',
                'sanitize_title_with_dashes',
                'esc_url',
                'wc_get_permalink_structure' // make sure we don't touch the woocommerce permalink rewrite slugs that are translated
            ), $text, $translation, $domain);

            if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
                $callstack_functions = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 15);//set a limit if it is supported to improve performance
            } else {
                $callstack_functions = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            }
            if (!empty($callstack_functions)) {
                foreach ($callstack_functions as $callstack_function) {
                    if (in_array($callstack_function['function'], $blacklist_functions)) {
                        $tp_last_gettext_processed = array($text . '::' . $domain => $translation);
                        return $translation;
                    }

                    /* make sure we don't touch the woocommerce process_payment function in WC_Gateway_Stripe. It does a wp_remote_post() call to stripe with localized parameters */
                    if ($callstack_function['function'] == 'process_payment' && $callstack_function['class'] == 'WC_Gateway_Stripe') {
                        $tp_last_gettext_processed = array($text . '::' . $domain => $translation);
                        return $translation;
                    }

                }
            }
            unset($callstack_functions);//maybe free up some memory
            global $translentor_output_buffer_started;
            if (did_action('init') && isset($translentor_output_buffer_started) && $translentor_output_buffer_started) {//check here for our global $translentor_output_buffer_started, don't wrap the gettexts if they are not processed by our cleanup callbacks for the buffers
                if ((!empty($translentor_LANGUAGE) && $this->settings["translentor-default-language"] != $translentor_LANGUAGE) || (isset($_REQUEST['translentor-editor']) && $_REQUEST['translentor-editor'] == 'preview')) {
                    //add special start and end tags so that it does not influence html in any way. we will replace them with < and > at the start of the translate function
                    $translation = apply_filters('translentor_process_gettext_tags', '#!translentorst#translentor-gettext data-translentorgettextoriginal=' . $db_id . '#!translentoren#' . $translation . '#!translentorst#/translentor-gettext#!translentoren#', $translation, $skip_gettext_querying, $text, $domain);
                }
            }
        }
        $tp_last_gettext_processed = array($text . '::' . $domain => $translation);
        return $translation;
    }

    /**
     * caller for woocommerce domain texts
     * @param $translation
     * @param $text
     * @param $domain
     * @return string
     */
    function woocommerce_process_gettext_strings($translation, $text, $domain)
    {
        if ($domain === 'woocommerce') {
            $translation = $this->process_gettext_strings($translation, $text, $domain);
        }
        return $translation;
    }

    /**
     * Function that filters gettext strings with context _x
     * @param $translation
     * @param $text
     * @param $context
     * @param $domain
     * @return string
     */
    function process_gettext_strings_with_context($translation, $text, $context, $domain)
    {
        $translation = $this->process_gettext_strings($translation, $text, $domain);
        return $translation;
    }

    /**
     * caller for woocommerce domain texts with context
     */
    function woocommerce_process_gettext_strings_with_context($translation, $text, $context, $domain)
    {
        if ($domain === 'woocommerce') {
            $translation = $this->process_gettext_strings_with_context($translation, $text, $context, $domain);
        }
        return $translation;
    }

    /**
     * function that filters the _n translations
     * @param $translation
     * @param $single
     * @param $plural
     * @param $number
     * @param $domain
     * @return string
     */
    function process_ngettext_strings($translation, $single, $plural, $number, $domain)
    {
        if ($number == 1)
            $translation = $this->process_gettext_strings($translation, $single, $domain);
        else
            $translation = $this->process_gettext_strings($translation, $plural, $domain);

        return $translation;
    }

    /**
     * caller for woocommerce domain numeric texts
     */
    function woocommerce_process_ngettext_strings($translation, $single, $plural, $number, $domain)
    {
        if ($domain === 'woocommerce') {
            $translation = $this->process_ngettext_strings($translation, $single, $plural, $number, $domain);
        }

        return $translation;
    }

    /**
     * function that filters the _nx translations
     * @param $translation
     * @param $single
     * @param $plural
     * @param $number
     * @param $context
     * @param $domain
     * @return string
     */
    function process_ngettext_strings_with_context($translation, $single, $plural, $number, $context, $domain)
    {
        $translation = $this->process_ngettext_strings($translation, $single, $plural, $number, $domain);
        return $translation;
    }

    /**
     * caller for woocommerce domain numeric texts with context
     */
    function woocommerce_process_ngettext_strings_with_context($translation, $single, $plural, $number, $context, $domain)
    {
        if ($domain === 'woocommerce') {
            $translation = $this->process_ngettext_strings_with_context($translation, $single, $plural, $number, $context, $domain);
        }
        return $translation;
    }

   

    /**
     * make sure we remove the translentor-gettext wrap from the format the date_i18n receives
     * ideally if in the gettext filter we would know 100% that a string is a valid date format then we would not wrap it but it seems that it is not easy to determine that ( explore further in the future $d = DateTime::createFromFormat('Y', date('y a') method); )
     */
    function handle_date_i18n_function_for_gettext($j, $dateformatstring, $unixtimestamp, $gmt)
    {

        /* remove translentor-gettext wrap */
        $dateformatstring = preg_replace('/#!translentorst#translentor-gettext (.*?)#!translentoren#/i', '', $dateformatstring);
        $dateformatstring = preg_replace('/#!translentorst#(.?)\/translentor-gettext#!translentoren#/i', '', $dateformatstring);


        global $wp_locale;
        $i = $unixtimestamp;

        if (false === $i) {
            $i = current_time('timestamp', $gmt);
        }

        if ((!empty($wp_locale->month)) && (!empty($wp_locale->weekday))) {
            $datemonth = $wp_locale->get_month(date('m', $i));
            $datemonth_abbrev = $wp_locale->get_month_abbrev($datemonth);
            $dateweekday = $wp_locale->get_weekday(date('w', $i));
            $dateweekday_abbrev = $wp_locale->get_weekday_abbrev($dateweekday);
            $datemeridiem = $wp_locale->get_meridiem(date('a', $i));
            $datemeridiem_capital = $wp_locale->get_meridiem(date('A', $i));
            $dateformatstring = ' ' . $dateformatstring;
            $dateformatstring = preg_replace("/([^\\\])D/", "\\1" . backslashit($dateweekday_abbrev), $dateformatstring);
            $dateformatstring = preg_replace("/([^\\\])F/", "\\1" . backslashit($datemonth), $dateformatstring);
            $dateformatstring = preg_replace("/([^\\\])l/", "\\1" . backslashit($dateweekday), $dateformatstring);
            $dateformatstring = preg_replace("/([^\\\])M/", "\\1" . backslashit($datemonth_abbrev), $dateformatstring);
            $dateformatstring = preg_replace("/([^\\\])a/", "\\1" . backslashit($datemeridiem), $dateformatstring);
            $dateformatstring = preg_replace("/([^\\\])A/", "\\1" . backslashit($datemeridiem_capital), $dateformatstring);

            $dateformatstring = substr($dateformatstring, 1, strlen($dateformatstring) - 1);
        }
        $timezone_formats = array('P', 'I', 'O', 'T', 'Z', 'e');
        $timezone_formats_re = implode('|', $timezone_formats);
        if (preg_match("/$timezone_formats_re/", $dateformatstring)) {
            $timezone_string = get_option('timezone_string');
            if ($timezone_string) {
                $timezone_object = timezone_open($timezone_string);
                $date_object = date_create(null, $timezone_object);
                foreach ($timezone_formats as $timezone_format) {
                    if (false !== strpos($dateformatstring, $timezone_format)) {
                        $formatted = date_format($date_object, $timezone_format);
                        $dateformatstring = ' ' . $dateformatstring;
                        $dateformatstring = preg_replace("/([^\\\])$timezone_format/", "\\1" . backslashit($formatted), $dateformatstring);
                        $dateformatstring = substr($dateformatstring, 1, strlen($dateformatstring) - 1);
                    }
                }
            }
        }
        $j = @date($dateformatstring, $i);

        return $j;

    }

    /**
     * Strip gettext tags from urls that were parsed by esc_url
     *
     * Esc_url() replaces spaces with %20. This is why it is not automatically stripped like the rest of the urls.
     *
     * @param $good_protocol_url
     * @param $original_url
     * @param $_context
     *
     * @return mixed
     * @since 1.3.8
     *
     */
    function translentor_strip_gettext_tags_from_esc_url($good_protocol_url, $original_url, $_context)
    {
        if (strpos($good_protocol_url, '%20data-translentorgettextoriginal=') !== false) {
            // first replace %20 with space  so that gettext tags can be stripped.
            $good_protocol_url = str_replace('%20data-translentorgettextoriginal=', ' data-translentorgettextoriginal=', $good_protocol_url);
            $good_protocol_url = translentor_Translation_Manager::strip_gettext_tags($good_protocol_url);
        }

        return $good_protocol_url;
    }

    /**
     * Filter sanitize_title() to use our own remove_accents() function so it's based on the default language, not current locale.
     *
     * Also removes translentor gettext tags before running the filter because it strip # and ! and / making it impossible to strip the #translentorst later
     *
     * @param string $title
     * @param string $raw_title
     * @param string $context
     * @return string
     * @since 1.3.1
     *
     */
    public function translentor_sanitize_title($title, $raw_title, $context)
    {
        // remove translentor_tags before sanitization, because otherwise some characters (#,!,/, spaces ) are stripped later, and it becomes impossible to strip translentor-gettext later
        $raw_title = translentor_Translation_Manager::strip_gettext_tags($raw_title);

        if ('save' == $context)
            $title = translentor_remove_accents($raw_title);

        remove_filter('sanitize_title', array($this, 'translentor_sanitize_title'), 1);
        $title = apply_filters('sanitize_title', $title, $raw_title, $context);
        add_filter('sanitize_title', array($this, 'translentor_sanitize_title'), 1, 3);

        return $title;
    }


    /**
     * function that strips the gettext tags from a string
     * @param $string
     * @return mixed
     */
    static function strip_gettext_tags($string)
    {
        if (is_string($string) && strpos($string, 'data-translentorgettextoriginal=') !== false) {
            // final 'i' is for case insensitive. same for the 'i' in  str_ireplace
            $string = preg_replace('/ data-translentorgettextoriginal=\d+#!translentoren#/i', '', $string);
            $string = preg_replace('/data-translentorgettextoriginal=\d+#!translentoren#/i', '', $string);//sometimes it can be without space
            $string = str_ireplace('#!translentorst#translentor-gettext', '', $string);
            $string = str_ireplace('#!translentorst#/translentor-gettext', '', $string);
            $string = str_ireplace('#!translentorst#\/translentor-gettext', '', $string);
            $string = str_ireplace('#!translentoren#', '', $string);
        }


        return $string;
    }

    /**
     * Add the current language as a class to the body
     * @param $classes
     * @return array
     */
    public function add_language_to_body_class($classes)
    {
        global $translentor_LANGUAGE;
        if (!empty($translentor_LANGUAGE)) {
            $classes[] = 'translentor-' . $translentor_LANGUAGE;
        }
        return $classes;
    }

   
    public function has_bad_characters($string)
    {
        $regex = '/
					(
						(?: [\x00-\x7F]                  # single-byte sequences   0xxxxxxx
						|   [\xC2-\xDF][\x80-\xBF]       # double-byte sequences   110xxxxx 10xxxxxx
						|   \xE0[\xA0-\xBF][\x80-\xBF]   # triple-byte sequences   1110xxxx 10xxxxxx * 2
						|   [\xE1-\xEC][\x80-\xBF]{2}
						|   \xED[\x80-\x9F][\x80-\xBF]
						|   [\xEE-\xEF][\x80-\xBF]{2}';

        $regex .= '
						|    \xF0[\x90-\xBF][\x80-\xBF]{2} # four-byte sequences   11110xxx 10xxxxxx * 3
						|    [\xF1-\xF3][\x80-\xBF]{3}
						|    \xF4[\x80-\x8F][\x80-\xBF]{2}
					';


        $regex .= '){1,40}                          # ...one or more times
					)
					| .                                  # anything else
					/x';
        $stripped_string = preg_replace($regex, '$1', $string);

        if ($stripped_string === $string) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Records a series of strings which may have encoding issues
     *
     * Does not alter dictionary.
     *
     * @param $dictionary
     * @param $prepared_query
     * @param $strings_array
     *
     * @return mixed
     */
    public function display_possible_db_errors($dictionary, $prepared_query, $strings_array)
    {
        global $translentor_editor_notices;
        if (translentor_is_translation_editor('preview') && is_array($dictionary) && count($dictionary) === 0) {
            if ($this->has_bad_characters($prepared_query)) {
                $html = "<div class='translentor-notice translentor-notice-warning'><p class='translentor-bad-encoded-strings'>" . __('<strong>Warning:</strong> Some strings have possibly incorrectly encoded characters. This may result in breaking the queries, rendering the page untranslated in live mode. Consider revising the following strings or their method of outputting.', 'translentor') . "</p>";
                $html .= "<ul class='translentor-bad-encoded-strings-list'>";
                foreach ($strings_array as $string) {
                    if ($this->has_bad_characters($string)) {
                        $html .= "<li>" . $string . "</li>";
                    }
                }
                $html .= "</ul></div>";

                $translentor_editor_notices .= $html;
            }
        }

        // no modifications to the dictionary
        return $dictionary;
    }

	/**
	 * Receives and returns the date format in which a date (eg publish date) is presented on the frontend
	 * The format is saved in the advanced settings tab for each language except the default one
	 *
	 * @param $date_format
	 *
	 * @return mixed
	 */
    public function filter_the_date( $date_format)
    {
        global $translentor_LANGUAGE;

        if (!empty($translentor_LANGUAGE) && $this->settings["translentor-default-language"] === $translentor_LANGUAGE) {
            return $date_format;
        } else {
            if (isset ($this->settings["translentor_advanced_settings"]["language_date_format"][$translentor_LANGUAGE]) && !empty ($this->settings["translentor_advanced_settings"]["language_date_format"][$translentor_LANGUAGE]))
            {
                return $this->settings["translentor_advanced_settings"]["language_date_format"][$translentor_LANGUAGE];
            } else {
                return $date_format;
            }
        }
    }

    

}
