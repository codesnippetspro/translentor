<?php
namespace Translentor\Includes;

class Loader {
    public function run() {
        // Load admin and public hooks
        if (function_exists('is_admin') && is_admin()) {
            require_once dirname(__DIR__) . '/admin/class-translentor-admin.php';
            (new \Translentor\Admin\Admin())->init();
        } else {
            require_once dirname(__DIR__) . '/public/class-translentor-public.php';
            require_once dirname(__DIR__) . '/public/class-translentor-assets.php';
            \Translentor\Public\Assets::register();
            (new \Translentor\Public\PublicPlugin())->init();
        }
        // Register widget
        if (class_exists('Elementor\Plugin')) {
            require_once dirname(__DIR__) . '/widgets/class-translentor-widget.php';
            add_action('elementor/widgets/register', function($widgets_manager) {
                $widgets_manager->register(new \Translentor\Widgets\Translentor_Widget());
            });
        }
    }
}
