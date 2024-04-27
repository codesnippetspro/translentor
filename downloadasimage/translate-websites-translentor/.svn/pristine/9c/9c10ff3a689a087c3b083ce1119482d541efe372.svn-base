<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (isset($_GET['woocommerce_gpf'])) {
    return false;
}
//disable rest api request
if (isset($_SERVER['SCRIPT_URI'])) {
    $uri = parse_url(trim(esc_url_raw($_SERVER['SCRIPT_URI'])));
    $uri = explode('/', trim(esc_url_raw($uri['path']), ' /'));
    if ($uri[0] === 'wp-json') {

        $show_legacy1 = in_array('widget-types', $uri); //tmp for wp 5.8
        $show_legacy2 = in_array('sidebars', $uri); //tmp for wp 5.8

        if (!$show_legacy1 && !$show_legacy2) {
            $allow = ['translentor_currency'];
            if (isset($uri[1]) AND!in_array($uri[1], $allow)) {
                return; //!!it is important for different reports to exclude translentor_currency influence
            }
        }
    }
}


if (defined('DOING_AJAX')) {

    if (isset($_REQUEST['action'])) {
        //do not recalculate refund amounts when we are in order backend
        if ($_REQUEST['action'] == 'woocommerce_refund_line_items') {
            if (!class_exists('WooCommerce_PDF_IPS_Pro') && !class_exists('WC_Smart_Coupons')) {
                return;
            }
        }

        if (isset($_REQUEST['order_id']) AND $_REQUEST['action'] == 'woocommerce_load_order_items') {
            return;
        }
    }
}
define('translentor_currency_VERSION', uniqid('translentor_currency-'));
define('translentor_currency_MIN_WOOCOMMERCE', '3.6');
define('translentor_currency_PATH', plugin_dir_path(__FILE__));
define('translentor_currency_LINK', plugin_dir_url(__FILE__));


//classes
include_once translentor_currency_PATH . 'classes/storage.php';
include_once translentor_currency_PATH . 'classes/fixed/fixed_amount.php';
include_once translentor_currency_PATH . 'classes/fixed/fixed_price.php';
include_once translentor_currency_PATH . 'classes/statistic.php';
include_once translentor_currency_PATH . 'classes/reports.php';
include_once translentor_currency_PATH . 'classes/dashboard_stat.php';
include_once translentor_currency_PATH . 'classes/profiles.php';

//18-01-2022
class translentor_currency_STARTER {

    private $default_translentor_currency_version = 1.6; 
    private $actualized = 0.0;
    private $version_key = "translentor_currency_currency_version";
    private $_translentor_currency = null;
    public $disable_plugin = array(); // add a slug of the  page  to  disble  the plugin. Example: 'account','cart'
    public $reverse_disable_plugin = 0; // set: true - to activate the plugin  on exact  pages

    public function __construct() {
        $this->actualized = floatval(get_option($this->version_key, $this->default_translentor_currency_version));
        $apl = get_option('translentor_currency_activate_page_list', '');
        if ($apl) {
            $this->disable_plugin = array_map('trim', explode(',', $apl));
        } else {
            $this->disable_plugin = [];
        }
        $this->reverse_disable_plugin = get_option('translentor_currency_activate_page_list_reverse', 1);
    }

    // public function update_version() {
    //     if (defined('WOOCOMMERCE_VERSION') AND ( $this->actualized !== floatval(WOOCOMMERCE_VERSION))) {
    //         update_option('translentor_currency_currency_version', WOOCOMMERCE_VERSION);
    //     }
    // }

    public function get_actual_obj() {

        if (count($this->disable_plugin) AND!is_admin() AND isset($_SERVER['SCRIPT_URI'])) {
            $exclude = false;
            $url = esc_url_raw($_SERVER['SCRIPT_URI']);
            if (!$url) {
                $url = explode('?', esc_url_raw($_SERVER['REQUEST_URI']));
                $url = $url[0];
            }
            if (preg_match("/\/([-a-zA-Z0-9_]+)[\/]$/", $url, $matches)) {

                $exclude = in_array($matches[1], $this->disable_plugin);
            } elseif (in_array("", $this->disable_plugin)) {
                $exclude = true;
            }

            if ($this->reverse_disable_plugin) {
                $exclude = !$exclude;
            }

            if ($exclude) {
                return false;
            }
        }

        if ($this->_translentor_currency != null) {
            return $this->_translentor_currency;
        }


        include_once translentor_currency_PATH . 'classes/translentor_currency.php'; //translentor_currency_after_33.php
        include_once translentor_currency_PATH . 'classes/fixed/fixed_coupon.php';
        include_once translentor_currency_PATH . 'classes/fixed/fixed_shipping.php';
        include_once translentor_currency_PATH . 'classes/fixed/fixed_shipping_free.php';
        include_once translentor_currency_PATH . 'classes/fixed/fixed_user_role.php';


        $this->_translentor_currency = new translentor_currency();
        return $this->_translentor_currency;
    }

}

//+++
if (isset($_GET['P3_NOCACHE'])) {
    //stupid trick for that who believes in P3
    return;
}

//+++
//fix: because of long id which prevent js script working
function translentor_currency_short_id($smth) {
    return substr(md5($smth), 1, 7);
}

//+++
$translentor_currency_STARTER = new translentor_currency_STARTER();

$translentor_currency = $translentor_currency_STARTER->get_actual_obj();
if ($translentor_currency) {
    $GLOBALS['translentor_currency'] = $translentor_currency;
    add_action('init', array($translentor_currency, 'init'), 1);
}

//****
//rate + interes
add_filter('translentor_currency_currency_data_manipulation', function ($currencies) {
    foreach ($currencies as $key => $value) {
        if (isset($value['rate_plus'])) {
            $interes = 0;
            if (!strpos($value['rate_plus'], '%')) {
                $interes = floatval($value['rate_plus']);
            } else {
                //example: 20%
                $interes = floatval(floatval($value['rate']) / 100) * intval($value['rate_plus']);
            }
            $currencies[$key]['rate'] = floatval($value['rate']) + $interes;
        }
    }

    return $currencies;
}, 1, 1);


function translentor_currency_is_bot(&$botname = '') {
    $bots = array(
        'rambler', 'googlebot', 'aport', 'yahoo', 'msnbot', 'turtle', 'mail.ru', 'omsktele',
        'yetibot', 'picsearch', 'sape.bot', 'sape_context', 'gigabot', 'snapbot', 'alexa.com',
        'megadownload.net', 'askpeter.info', 'igde.ru', 'ask.com', 'qwartabot', 'yanga.co.uk',
        'scoutjet', 'similarpages', 'oozbot', 'shrinktheweb.com', 'aboutusbot', 'followsite.com',
        'dataparksearch', 'google-sitemaps', 'appEngine-google', 'feedfetcher-google',
        'liveinternet.ru', 'xml-sitemaps.com', 'agama', 'metadatalabs.com', 'h1.hrn.ru',
        'googlealert.com', 'seo-rus.com', 'yaDirectBot', 'yandeG', 'yandex',
        'yandexSomething', 'Copyscape.com', 'AdsBot-Google', 'domaintools.com',
        'Nigma.ru', 'bing.com', 'dotnetdotcom'
    );

    $HTTP_USER_AGENT = "";
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $HTTP_USER_AGENT =esc_url_raw($_SERVER['HTTP_USER_AGENT']);
    }
    foreach ($bots as $bot) {
        if (stripos($HTTP_USER_AGENT, $bot) !== false) {
            $botname = $bot;
            return true;
        }
    }

    return false;
}

add_action('wp_head', function () {
    if (translentor_currency_is_bot()) {
        if (class_exists('translentor_currency')) {
            global $translentor_currency;
            $translentor_currency->reset_currency();
        }
    }
}, 1);

//for separators
add_filter('option_woocommerce_price_thousand_sep', function ($value) {
    global $translentor_currency;

    if (is_object($translentor_currency)) {
        $current_currency = $translentor_currency->get_woocommerce_currency();
        $value = $translentor_currency->get_thousand_sep($current_currency, $value);
    }

    return $value;
});

//for separators
add_filter('option_woocommerce_price_decimal_sep', function ($value) {
    global $translentor_currency;

    if (is_object($translentor_currency)) {
        $current_currency = $translentor_currency->get_woocommerce_currency();
        $value = $translentor_currency->get_decimal_sep($current_currency, $value);
    }

    return $value;
});
