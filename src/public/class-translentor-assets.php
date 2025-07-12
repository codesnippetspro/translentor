<?php
namespace Translentor\Public;

class Assets {
    public static function register() {
        add_action('wp_enqueue_scripts', [self::class, 'enqueue']);
    }
    public static function enqueue() {
        wp_enqueue_style('translentor-css', TRANSLENTOR_URL . 'translentor/assets/css/translentor-css.min.css', [], TRANSLENTOR_VERSION);
        wp_enqueue_script('translentor-js', TRANSLENTOR_URL . 'translentor/assets/js/translentor-js.js', ['jquery'], TRANSLENTOR_VERSION, true);
    }
}
