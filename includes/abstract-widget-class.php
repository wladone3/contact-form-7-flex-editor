<?php
abstract class CFC_Abstract_Widget {

    public $settings = [];

    public $defaults = [];

    public function get_category() {
        return 'default';
    }

    public function settings() {}

    public function render() {
        trigger_error('Дочерний класс не использует метод ' . __METHOD__ . ' Вывод виджета не может быть пустым');
    }

    public function __construct() {
        $this->settings();
    }

    public function set_setting( $id, $params ) {
        $this->settings[$id] = $params;
        $this->defaults[$id] = key_exists('default', $params) ? $params['default'] : '';
    }

    public function get_settings() {
        return $this->settings;
    }

    public function get_defaults() {
        return $this->defaults;
    }

    public function get_template() {
        ob_start();
        $this->render();
        return ob_get_clean();
    }
}