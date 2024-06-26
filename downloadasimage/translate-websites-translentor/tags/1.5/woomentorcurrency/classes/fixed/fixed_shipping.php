<?php

if (!defined('ABSPATH'))
    die('No direct access allowed');

class translentor_currency_FIXED_SHIPPING extends translentor_currency_FIXED_AMOUNT {

    protected $key = "";

    public function __construct() {
        $this->key = "_shipping_";
        add_filter('woocommerce_shipping_instance_form_fields_flat_rate', array($this, 'add_fixed_flat_rate'), 9999, 1);
        add_filter('woocommerce_shipping_flat_rate_instance_settings_values', array($this, 'save_fixed_flate_rate'), 9999, 2);
    }

    public function add_fixed_flat_rate($fields) {

        global $translentor_currency;
        $currencies = $translentor_currency->get_currencies();
        $default_currency = $translentor_currency->default_currency;
        $is_fixed_enabled = $translentor_currency->is_fixed_shipping;

        foreach ($currencies as $code => $data) {
            if ($code == $default_currency) {
                continue;
            }
            $fields['translentor_currency_fixed' . $this->key . $code] = array(
                'title' => sprintf(esc_html__('Fixed cost %s', 'woomentor-currency'), $code),
                'type' => 'text',
                'placeholder' => esc_html__("auto", 'woomentor-currency'),
                'description' => $code,
                'default' => '',
                'desc_tip' => true
            );
        }
        return $fields;
    }

    public function save_fixed_flate_rate($options, $method) {
        return $options;
    }

    public function get_value($method_id, $code, $type) {

        $method = explode(":", $method_id, 2);
        if (!isset($method[1])) {
            return -1;
        }
        $option_string = 'woocommerce_' . $method[0] . '_' . $method[1] . '_settings';
        $settings = get_option($option_string, null);
        if ($settings == null OR ! is_array($settings)) {
            return -1;
        }
        $array_key = sprintf('translentor_currency_fixed%s%s%s', $type, $this->key, $code);
        if (!isset($settings[$array_key])) {
            return -1;
        }
        return $this->prepare_float_val($settings[$array_key]);
    }

}
