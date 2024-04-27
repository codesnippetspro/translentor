<?php

if (!defined('ABSPATH'))
    die('No direct access allowed');

//keeps current user data
final class wmc_storage {

    public $type = 'cookie'; //session, transient, woo_session, cookie
    private $user_ip = null;
    private $transient_key = null;

    public function __construct($type = '') {
        $this->type=$type;
    }

    public function set_val($key, $value) {

        $value = sanitize_text_field(esc_html($value));
        //***

        switch ($this->type) {

            case 'cookie':
                //setcookie($key, $value, time() + 1 * 24 * 3600); //1 day
                // wc_setcookie( $key, $value, time() + 1 * 24 * 3600 );
                break;

            default:
                break;
        }
    }

    public function get_val($key) {
        $value = NULL;

        switch ($this->type) {
           
            case 'cookie':
                if ($this->is_isset($key)) {
                    $value = $_COOKIE[$key];
                }
                break;

            default:
                break;
        }

        return sanitize_text_field(esc_html($value));
    }

    public function is_isset($key) {
        $isset = false;
        switch ($this->type) {
         
            case 'cookie':
                $isset = isset($_COOKIE[$key]);
                break;
        }

        return $isset;
    }

}

