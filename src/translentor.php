<?php

/**
 * Plugin Name: Translentor
 * Plugin URI: https://translentor.com
 * Description: This plugin adds a language translator widget to the Elementor Page Builder.
 * Version: 1.6.6
 * Author: Code Snippets Pro
 * Author URI: https://translentor.com
 * Domain Path: translentor
 * @package Translentor
 */

use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Minimal PHP requirement (adjust if needed)
if ( version_compare( PHP_VERSION, '7.4.0', '<' ) ) {
    add_action( 'admin_notices', function () {
        ?><div class="notice notice-error"><p><strong>Translentor:</strong> requires PHP 7.4+. Your server is running PHP <?php echo esc_html( PHP_VERSION ); ?>. Please upgrade PHP.</p></div><?php
    } );
    return;
}

// Register activation hook: set an option to trigger a redirect safely on next admin page load
function translentor_activate() {
    // flag used to redirect once after activation
    update_option( Translentor::SLUG . '_do_activation_redirect', 1 );
}

register_activation_hook( __FILE__, 'translentor_activate' );

// On admin init, perform a safe redirect if the flag is present, then delete it.
function translentor_maybe_do_activation_redirect() {
    if ( ! is_admin() ) {
        return;
    }

    $flag = get_option( Translentor::SLUG . '_do_activation_redirect' );
    if ( $flag ) {
        delete_option( Translentor::SLUG . '_do_activation_redirect' );
        // Only redirect users who can manage options (admins)
        if ( current_user_can( 'manage_options' ) ) {
            wp_safe_redirect( admin_url( 'admin.php?page=translentor-module' ) );
            exit;
        }
    }
}

add_action( 'admin_init', 'translentor_maybe_do_activation_redirect' );

// Show admin notice if Elementor isn't active.
function translentor_admin_notice_elementor_missing() {
    if ( is_admin() && ! class_exists( 'Elementor\\Plugin' ) ) {
        ?><div class="notice notice-warning is-dismissible"><p><strong>Translentor:</strong> requires Elementor to be active. Please install and activate Elementor.</p></div><?php
    }
}

add_action( 'admin_notices', 'translentor_admin_notice_elementor_missing' );

// Initialize plugin only when Elementor is available.
add_action( 'plugins_loaded', function () {
    if ( ! class_exists( 'Elementor\\Plugin' ) ) {
        return; // Elementor not present
    }

    add_action( 'elementor/elements/categories_registered', function () {
        $elementsManager = Plugin::instance()->elements_manager;
        if ( is_object( $elementsManager ) ) {
            $elementsManager->add_category( 'translentor-category', [
                'title' => Translentor::CATEGORY,
                'icon'  => Translentor::CATEGORY_ICON,
            ] );
        }
    } );

    $widgets_index = Translentor::widgets_index_path();
    if ( file_exists( $widgets_index ) ) {
        require_once $widgets_index;
    }
} );

if ( class_exists( 'Translentor' ) ) {
  return;
}

class Translentor {
  public const DIR  = __DIR__ . DIRECTORY_SEPARATOR;
  public const VERSION = '1.6.6';
  public const SLUG    = 'translentor';
  public const CATEGORY_ICON = 'fa fa-plug';
  public const CATEGORY      = 'Translator';
  
  public static function widgets_index_path() {
    return self::DIR . 'widgets' . DIRECTORY_SEPARATOR . 'index.php';
  }

  public static function url() {
    return plugin_dir_url( __FILE__ );
  }
}