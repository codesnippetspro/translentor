<?php
if (!defined('ABSPATH')) {
    exit;
}

class translentor_currency_reports {

    public function __construct() {
        add_filter('woocommerce_reports_get_order_report_data', array($this, 'adapt_data'), 10, 2);
        add_filter('woocommerce_reports_get_order_report_query', array($this, 'adapt_query'));
        add_action('admin_footer', array($this, 'show_switcher'));
    }

    public function adapt_data($result, $args) {
        if (isset($_GET['currency']) AND $_GET['currency']) {
            global $translentor_currency;
            $translentor_currency->set_currency($_GET['currency']);
        }
        if (is_array($result) AND isset($result[0]->total_sales)) {
            global $wpdb;
            global $translentor_currency;
            $range = '7day';
            if (isset($_GET['range'])) {
                $range = sanitize_text_field($_GET['range']);
            }
            $start_date = '';
            $end_date = date('Y-m-d 23:59:59');
            switch ($range) {
                case 'custom':
                    $start_date = sanitize_text_field($_GET['start_date']);
                    break;
                case '7day':
                    $start_date = date('Y-m-d 00:00:00', time() - 7 * DAY_IN_SECONDS);
                    break;
                case 'month':
                    $start_date = date('Y-m-01 00:00:00');
                    break;
                case 'year':
                    $start_date = date('Y-01-01 00:00:00');
                    break;

                default:
                    $start_date = date('Y-m-d 00:00:00', time() - 7 * DAY_IN_SECONDS);
                    break;
            }
            //  $order_status = "wc-" . implode('","wc-', $args['order_status']);
            $order_status = array('completed', 'processing', 'on-hold');
            $order_status = apply_filters('woocommerce_reports_order_statuses', $order_status);
            $order_status = "wc-" . implode('","wc-', $order_status);
            //***
            $sql = $wpdb->prepare('SELECT ID FROM ' . $wpdb->posts . ' WHERE post_type=%s AND post_status IN("' . $order_status . '") AND post_date >= %s AND post_date < %s', 'shop_order', $start_date, $end_date);
            $tmp = $wpdb->get_results($sql, ARRAY_N);
            $orders = array();
            $result = array();
            if (!empty($tmp)) {
                foreach ($tmp as $v) {
                    $orders[] = $v[0];
                }

                $result = array();
                $currencies = $translentor_currency->get_currencies();
                foreach ($orders as $order_id) {
                    $tmp = array();
                    $order = new WC_Order($order_id);

                    $_order_currency = get_post_meta($order_id, '_order_currency', true);
                    $order_rate = get_post_meta($order_id, '_translentor_currency_order_rate', true);
                    if (!$order_rate) {
                        if (isset($currencies[$_order_currency])) {
                            $order_rate = $currencies[$_order_currency]['rate'];
                        } else {
                            continue;
                        }
                    }

                    if ($_order_currency != $translentor_currency->default_currency) {
                        $tmp['total_sales'] = $translentor_currency->back_convert(get_post_meta($order_id, '_order_total', true), $order_rate, 4);
                        $tmp['total_shipping'] = $translentor_currency->back_convert(get_post_meta($order_id, '_order_shipping', true), $order_rate, 4);
                        $tmp['total_tax'] = $translentor_currency->back_convert(get_post_meta($order_id, '_order_tax', true), $order_rate, 4);
                        $tmp['total_shipping_tax'] = $translentor_currency->back_convert(get_post_meta($order_id, '_order_shipping_tax', true), $order_rate, 4);
                    } else {
                        $tmp['total_sales'] = get_post_meta($order_id, '_order_total', true);
                        $tmp['total_shipping'] = get_post_meta($order_id, '_order_shipping', true);
                        $tmp['total_tax'] = get_post_meta($order_id, '_order_tax', true);
                        $tmp['total_shipping_tax'] = get_post_meta($order_id, '_order_shipping_tax', true);
                    }
                    if (isset($_GET['currency']) AND $_GET['currency']) {
                        if ($_GET['currency'] != $translentor_currency->default_currency) {
                            $currencies = $translentor_currency->get_currencies();
                            if (isset($currencies[$_GET['currency']])) {
                                $rate = $currencies[sanitize_text_field($_GET['currency'])]['rate'];
                                $tmp['total_sales'] = $tmp['total_sales'] * $rate;
                                $tmp['total_shipping'] = $tmp['total_shipping'] * $rate;
                                $tmp['total_tax'] = $tmp['total_tax'] * $rate;
                                $tmp['total_shipping_tax'] = $tmp['total_shipping_tax'] * $rate;
                                $translentor_currency->set_currency($_GET['currency']);
                            }
                        }
                    }

                    //$tmp['post_date'] = $order->order_date;
                    $tmp['post_date'] = $order->get_date_created();

                    $result[] = (object) $tmp;
                }
            }
        }

        return $result;
    }

    public function adapt_query($query) {
        if (isset($_GET['currency']) AND $_GET['currency']) {
            $query[] = ' /*' .  sanitize_text_field($_GET['currency']) . '*/';
        }
        return $query;
    }

    public function show_switcher() {
        global $translentor_currency;
        $currency = $translentor_currency->default_currency;
        if (isset($_GET['currency'])) {
            $currency =  sanitize_text_field($_GET['currency']);
        }
        $currencies = $translentor_currency->get_currencies();
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        if (isset($_GET['page']) AND $_GET['page'] == 'wc-reports') {
            ?>
            <li class="translentor_currency_report_currency_switcher custom">
                <select onChange="window.location.href = this.value">
                    <?php
                    foreach ($currencies as $key => $item) {
                        $selected = "";
                        if ($key == $currency) {
                            $selected = "selected='selected'";
                        }
                        ?>
                        <option <?php echo $selected ?> value="<?php echo esc_html($actual_link) . "&currency=" . esc_html($key) ?>"><?php echo esc_html($key) ?></option>
                    <?php } ?>

                </select>
            </li>
            <?php echo html_entity_decode('&lt;script&gt;'); ?>
            jQuery('.translentor_currency_report_currency_switcher').appendTo(jQuery('.stats_range ul'));
            <?php echo html_entity_decode('&lt;/script&gt;'); ?>
            <?php
        }
    }

}
