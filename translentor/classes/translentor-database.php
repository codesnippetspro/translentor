<?php

class translentor_Translation_Memory {
    protected $db;
    protected $settings;
    /* @var Lang_Query */
    protected $lang_query;

    const MIN_NUMBER_OF_CHARS_FOR_FULLTEXT = 20;

    /**
     * translentor_Translation_Memory constructor.
     * @param $settings
     */
    public function __construct( $settings ){
        global $wpdb;
        $this->db = $wpdb;
        $this->settings = $settings;
    }

    /**
     * Finding similar strings in the database and returning an array with possible translations.
     *
     *
     * @param string    $string         The original string we're searching a similar one.
     * @param string    $table_name          The table where we should look for similar strings in. Default dictionary.
     * @param int       $number         The number of similar strings we want to return.
     * @return array                    Array with (original => translated ) pairs based on the number of strings we should account for. Empty array if nothing is found.
     */
    public function get_similar_string_translation( $string, $number, $table_name ){
        if( empty($table_name) ){
            return array();
        }

        $translentor = translentor_Translentor::get_translentor_instance();
        if ( ! $this->lang_query ) {
            $this->lang_query = $translentor->get_translentorelements( 'query' );
        }

        $query = '';
        $query .= "SELECT original,translated, status FROM `"
                 . sanitize_text_field( $table_name )
                 . "` WHERE status != " . Lang_Query::NOT_TRANSLATED . " AND `original` != '%s' AND MATCH(original) AGAINST ('%s' IN NATURAL LANGUAGE MODE ) LIMIT " . $number;

        $query = $this->db->prepare( $query, array($string, $string) );
        $result = $this->db->get_results( $query, ARRAY_A );

        return $result;
    }

    
    public function ajax_get_similar_string_translation(){
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            if (isset($_POST['action']) && $_POST['action'] === 'translentor_get_similar_string_translation' && !empty($_POST['original_string']) && !empty($_POST['language']) && !empty($_POST['selector']) && in_array($_POST['language'], get_option('translentor_settings_elementor')['translentor_lang']) )
            {
                global $translentor_LANGUAGE;
                check_ajax_referer('getsimilarstring', 'security');
                $string = ( isset($_POST['original_string']) ) ? $_POST['original_string'] : '';
                $language_code = ( isset($_POST['language']) ) ? sanitize_text_field( $_POST['language'] ) : $translentor_LANGUAGE;
                $selector = ( isset($_POST['selector']) ) ? sanitize_text_field( $_POST['selector'] ) : '';
                $number = ( isset($_POST['number']) ) ? (int) $_POST['number'] : 3;

                $translentor = translentor_Translentor::get_translentor_instance();
                if ( ! $this->lang_query ) {
                    $this->lang_query = $translentor->get_translentorelements( 'query' );
                }

                $table_name = null;

                
                if ( $language_code !== $this->settings['translentor-default-language'] ) {
                    
                    $table_name = $this->lang_query->get_table_name( $language_code );
                }

                if( strpos($selector, "data-translentorgettextoriginal" ) !== false ){
                    $table_name = $this->lang_query->get_gettext_table_name( $language_code );
                }

                if ( $table_name === null ) {
                    $dictionary = array();
                }else{
                    $dictionary = $this->get_similar_string_translation( $string, $number, $table_name );
                }
                echo json_encode($dictionary);
                wp_die();
            }
        }
        echo json_encode(array());
        wp_die();
    }
}