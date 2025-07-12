<?php
namespace Translentor\Admin;

class Admin {
    public function init() {
        add_action('admin_notices', [$this, 'admin_notices']);
    }

    public function admin_notices() {
        if (!class_exists('Elementor\Plugin')) {
            echo '<div class="notice notice-warning is-dismissible"><p><strong>Warning</strong>: Translentor works with Elementor Plugin. Please Activate Elementor Plugin</p></div>';
        }
    }
}
