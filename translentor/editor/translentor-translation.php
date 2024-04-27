<?php


class translentor_String_Translation {
    protected $settings;
    /* @var translentor_Translation_Manager */
    protected $translation_manager;

    // flat structure of string_types_config
    protected $string_types = array();

    // actual classes that may get retrieved from elsewhere through get_string_type_API()
    protected $string_type_apis = array();
    /**
     * @var array
     */
    protected $gettext_domains;

    public function __construct( $settings, $loader ) {
        $this->settings = $settings;
        $this->loader   = $loader;


    }


    public function get_string_types() {
        return $this->string_types;
    }

    public function get_string_type_API( $string_type ) {
        return $this->string_type_apis[ $string_type ];
    }

    /**
     * Start String Translation Editor.
     *
     * Hooked to template_include.
     *
     * @param string $page_template Current page template.
     * @return string                       Template for translation Editor.
     */
    public function string_translation_editor( $page_template ) {
        if ( !$this->is_string_translation_editor() ) {
            return $page_template;
        }
        return translentor_DIR . 'translentor/editor/translentor-translation-editor.php';
    }

    /**
     * Return true if we are on String translation page.
     *
     * Also wp_die and show 'Cheating' message if we are on translation page but user does not have capabilities to view it
     *
     * @return bool
     */
    public function is_string_translation_editor() {
        if ( isset( $_REQUEST['translentor-string-translation'] ) && sanitize_text_field( $_REQUEST['translentor-string-translation'] ) === 'true' ) {
            if ( current_user_can( apply_filters( 'translentor_translating_capability', 'manage_options' ) ) && !is_admin() ) {
                return true;
            } else {
                wp_die(
                    '<h1>' . esc_html__( 'Cheatin&#8217; uh?' ) . '</h1>' . //phpcs:ignore
                    '<p>' . esc_html__( 'Sorry, you are not allowed to access this page.' ) . '</p>', //phpcs:ignore
                    403
                );
            }
        }
        return false;
    }

    /**
     * Enqueue script and styles for String Translation Editor page
     *
     * Hooked to translentor_string_translation_editor_footer
     */
    public function enqueue_scripts_and_styles() {
        $translentor = translentor_Translentor::get_translentor_instance();
        if ( !$this->translation_manager ) {
            $this->translation_manager = $translentor->get_translentorelements( 'translation_manager' );
        }


        wp_enqueue_style( 'translentor-editor-style', translentor_URL . 'translentor/assets/css/translentor-editor.min.css', array( 'dashicons', 'buttons' ), translentor_VERSION );
        wp_enqueue_script( 'translentor-string-translation-editor', translentor_URL . 'translentor/assets/js/translentor-string-translation-editor.min.js', array(), translentor_VERSION );

        wp_localize_script( 'translentor-string-translation-editor', 'translentor_editor_data', $this->translation_manager->get_translentor_editor_data() );
        wp_localize_script( 'translentor-string-translation-editor', 'translentor_string_translation_data', $this->get_string_translation_data() );


        // Show upload media dialog in default language
        switch_to_locale( $this->settings['translentor-default-language'] );
        // Necessary for add media button
        wp_enqueue_media();

        // Necessary for add media button
        wp_print_media_templates();
        restore_current_locale();

        // Necessary for translate-dom-changes to have a nonce as the same user as the Editor.
        // The Preview iframe (which loads translate-dom-changes script) can load as logged out which sets an different nonce

        $scripts_to_print = apply_filters( 'translentor-scripts-for-editor', array( 'jquery', 'jquery-ui-core', 'jquery-effects-core', 'translentor-string-translation-editor' ) );
        $styles_to_print  = apply_filters( 'translentor-styles-for-editor', array( 'dashicons', 'translentor-editor-style', 'media-views', 'imgareaselect', 'common', 'forms', 'list-tables', 'buttons' ) );
        wp_print_scripts( $scripts_to_print );
        wp_print_styles( $styles_to_print );

        // Necessary for add media button
        print_footer_scripts();

    }

    public function get_string_translation_data() {
        $string_translation_data = array(
            'string_types_config'        => $this->string_types_config(),
            'st_editor_strings'          => $this->get_st_editor_strings(),
            'translation_status_filters' => $this->get_translation_status_filters(),
            'default_actions'            => $this->get_default_actions(),
            'config'                     => $this->get_configuration_options()
        );
        return apply_filters( 'translentor_string_translation_data', $string_translation_data );
    }

    public function get_translation_status_filters() {
        $filters = array(
            'translation_status' => array(
                'human_reviewed'     => __( 'Human reviewed', 'translentor' ),
                'machine_translated' => __( 'Automatically translated', 'translentor' ),
                'not_translated'     => __( 'Not translated', 'translentor' )
            )

        );
        return apply_filters( 'translentor_st_default_filters', $filters );
    }

    public function get_default_actions() {
        $actions = array(
            'bulk_actions' => array(
                'translentor_default' => array( 'name' => __( 'Bulk Actions', 'translentor' ) ),
                'delete'      => array(
                    'name'  => __( 'Delete entries', 'translentor' ),
                    'nonce' => wp_create_nonce( 'string_translation_save_strings_delete' )
                ),
            ),
            'actions'      => array(
                'edit'   => __( 'Edit', 'translentor' )
            )
        );
        return apply_filters( 'translentor_st_default_actions', $actions );
    }

    public function get_gettext_domains() {
        if ( !$this->gettext_domains ) {
            $translentor          = translentor_Translentor::get_translentor_instance();
            $lang_query    = $translentor->get_translentorelements( 'query' );
            $translentor_settings = get_option('translentor_settings_elementor');
            $settings     = get_option('translentor_settings_elementor');

            global $wpdb;
//            $query = 'SELECT DISTINCT domain FROM ' . $lang_query->get_gettext_table_name( $settings['translentor-default-language'] );
            $query = '';
            foreach ( $settings['translentor_lang'] as $language ) {
                $query .= 'SELECT domain FROM ' . $lang_query->get_gettext_table_name( $language ) . ' UNION ';
            }
            $query = rtrim( $query, ' UNION ' ) . ' ';
            $query .= ' ORDER BY domain ASC ';

            $this->gettext_domains = $wpdb->get_results( $query, OBJECT_K );
            foreach ( $this->gettext_domains as $domain => $value ) {
                $this->gettext_domains[ $domain ] = $domain;
            }
        }

        return $this->gettext_domains;
    }

    public function get_st_editor_strings() {
        $st_editor_strings = array(
            'translation_status'     => __( 'Translation Status', 'translentor' ),
            'filter'                 => __( 'Filter', 'translentor' ),
            'filter_by_language'     => __( 'Filter by language', 'translentor' ),
            'add_new'                => __( 'Add New', 'translentor' ),
            'importexport'           => __( 'Import / Export', 'translentor' ),
            'items'                  => __( 'items', 'translentor' ),
            'of'                     => _x( 'of', 'page 1 of 3', 'translentor' ),
            'see_more'               => __( 'See More', 'translentor' ),
            'see_less'               => __( 'See Less', 'translentor' ),
            'apply'                  => __( 'Apply', 'translentor' ),
            'no_strings_match_query' => __( 'No strings match your query.', 'translentor' ),
            'request_error'          => __( 'An error occurred while loading results. Most likely you were logged out. Reload page?', 'translentor' ),

            'select_all'               => __( 'Select All', 'translentor' ),
            'select_visible'           => __( 'Select Visible', 'translentor' ),
            'select_all_warning'       => __( 'You are about to perform this action on all the strings matching your filter, not just the visibly checked. To perform the action only to the visible strings click "Select Visible" from the table header dropdown.', 'translentor' ),
            'select_visible_warning'   => __( 'You are about to perform this action only on the visible strings. To perform the action on all the strings matching the filter click "Select All" from the table header dropdown.', 'translentor' ),
            'type_a_word_for_security' => __( 'To continue please type the word:', 'translentor' ),
            'incorect_word_typed'      => __( 'The word typed was incorrect. Action was cancelled.', 'translentor' ),

            'in'                         => _x( 'in', 'Untranslated in this language', 'translentor' ),

            // specific bulk actions
            'delete_warning'             => __( 'Warning: This action cannot be undone. Deleting a string will remove its current translation. The original string will appear again in this interface after translentor detects it. This action is NOT equivalent to excluding the string from being translated again.' , 'translentor' ),

            // tooltips
            'next_page'                  => __( 'Navigate to next page', 'translentor' ),
            'previous_page'              => __( 'Navigate to previous page', 'translentor' ),
            'first_page'                 => __( 'Navigate to first page', 'translentor' ),
            'last_page'                  => __( 'Navigate to last page', 'translentor' ),
            'navigate_to_page'           => __( 'Type a page number to navigate to', 'translentor' ),
            'wrong_page'                 => __( 'Incorrect page number. Type a page number between 1 and total number of pages', 'translentor' ),
            'search_tooltip'             => __( 'Search original strings containing typed keywords while also matching selected filters', 'translentor' ),
            'filter_tooltip'             => __( 'Filter strings according to selected translation status, filters and keywords and selected filters', 'translentor' ),
            'select_all_tooltip'         => __( 'See options for selecting all strings', 'translentor' ),
            'sort_by_column'             => __( 'Click to sort strings by this column', 'translentor' ),
            'filter_by_language_tooltip' => __( 'Language in which the translation status filter applies. Leave unselected for the translation status to apply to ANY language', 'translentor' ),
        );
        return apply_filters( 'translentor_st_editor_strings', $st_editor_strings );
    }

    /**
     * @return mixed
     */
    public function string_types_config() {
        $string_types_config = array();
        return apply_filters( 'translentor_st_string_types_config', $string_types_config, $this );
    }

    public function get_nonces_for_type( $type ) {
        $nonces = array(
            'get_strings'  => wp_create_nonce( 'string_translation_get_strings_' . $type ),
            'save_strings' => wp_create_nonce( 'string_translation_save_strings_' . $type )
        );
        return apply_filters( 'translentor_string_translation_nonces', $nonces, $type );
    }

    public function get_configuration_options() {
        $config = array(
            'items_per_page'      => 20,
            'see_more_max_length' => 150
        );
        return apply_filters( 'translentor_string_translation_config', $config );
    }

    public function register_string_types( $registered_string_types ) {
        foreach ( $this->string_types as $string_type => $value ) {
            if ( !in_array( $string_type, $registered_string_types ) ) {
                $registered_string_types[] = $string_type;
            }
        }

        return $registered_string_types;
    }

    /*
     * hooked to translentor_editor_nonces
     */
    public function add_nonces_for_saving_translation( $nonces ) {
        foreach ( $this->string_types as $string_type => $string_config ) {
            if ( !isset( $nonces[ 'savetranslationsnonce' . $string_type ] ) ) {
                $nonces[ 'savetranslationsnonce' . $string_type ] = $string_config['nonces']['save_strings'];
            }
        }
        return $nonces;
    }
}