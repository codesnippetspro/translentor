<?php
namespace Translentor\Widgets;

use Elementor\Widget_Base;

class Translentor_Widget extends Widget_Base {
    public function get_name() {
        return 'translentor_widget';
    }
    public function get_title() {
        return __('Translentor Widget', 'translentor');
    }
    public function get_icon() {
        return 'fa fa-language';
    }
    public function get_categories() {
        return ['translentor-category'];
    }
    protected function render() {
        // Output widget HTML
        echo '<div id="translentor-widget">Translator Widget Output</div>';
    }
}
