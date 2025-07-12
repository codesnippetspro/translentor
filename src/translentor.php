<?php
/**
 * Plugin Name: Translentor
 * Plugin URI: https://translentor.com
 * Description: This plugin adds a language translator widget to the Elementor Page Builder.
 * Version: 1.6.2
 * Author: Code Snippets Pro
 * Author URI: https://translentor.com
 * Domain Path: translentor
 * @package Translentor
 */

if (!defined('ABSPATH')) exit;

define('TRANSLENTOR_DIR', plugin_dir_path(__FILE__));
define('TRANSLENTOR_URL', plugin_dir_url(__FILE__));
define('TRANSLENTOR_VERSION', '1.6.2');
define('TRANSLENTOR_SLUG', 'translentor');

autoload_translentor_classes();

function autoload_translentor_classes() {
    spl_autoload_register(function ($class) {
        $prefix = 'Translentor\\';
        $base_dir = __DIR__ . '/';
        if (strpos($class, $prefix) !== 0) {
            return;
        }
        $relative_class = str_replace($prefix, '', $class);
        $file = $base_dir . str_replace('\\', '/', strtolower($relative_class)) . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    });
}

register_activation_hook(__FILE__, ['Translentor\Includes\Activator', 'activate']);
register_deactivation_hook(__FILE__, ['Translentor\Includes\Deactivator', 'deactivate']);

function run_translentor() {
    $plugin = new Translentor\Includes\Loader();
    $plugin->run();
}
run_translentor();
