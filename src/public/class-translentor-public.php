<?php
namespace Translentor\Public;

use Elementor\Plugin;

class PublicPlugin {
    public function init() {
        add_action('elementor/elements/categories_registered', [$this, 'register_category']);
    }

    public function register_category() {
        $elementsManager = Plugin::instance()->elements_manager;
        $elementsManager->add_category(
            'translentor-category',
            [
                'title' => 'Translator',
                'icon'  => 'fa fa-plug',
            ]
        );
    }
}
