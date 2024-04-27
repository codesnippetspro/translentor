<?php

/**
 * Class translentor_Rewrite_Rules
 *
 * Filters the .htaccess file to prevent language slug in URL
 *
 */
class translentor_Rewrite_Rules{

    protected $settings;

    public function __construct( $settings ){
        $this->settings = $settings;
    }

    /**
     * Remove language parameter from .htaccess in certain cases.
     *
     * Hooked to 'mod_rewrite_rules'
     *
     * @param string $htaccess_string
     *
     * @return string
     */
    public function translentor_remove_language_param( $htaccess_string ) {

        $url_slugs = $this->settings['translentor-lang-slugs'];

        foreach ( $url_slugs as $key => $value ) {
            if( $this->settings['translentor-subdirectory-default-lang'] == 'no' && $key == $this->settings['translentor-default-language'] ){
                continue;
            }
            foreach ( array( '', 'translentor.php' ) as $base ) {
                $htaccess_string = str_replace(
                    '/' . $value . '/' . $base,
                    '/' . $base,
                    $htaccess_string
                );
            }
        }

        return $htaccess_string;
    }

}
