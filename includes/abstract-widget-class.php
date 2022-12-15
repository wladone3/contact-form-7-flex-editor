<?php

/*
 * Abstract widget class
 *
 * @since 0.2
 * */
abstract class CFC_Abstract_Widget {

    /**
     * List of all settings
     *
     * @since 0.2
     * */
    public $settings = [];

    /**
     * list of default values
     *
     * @since 0.2
     */
    public $defaults = [];

    /**
     * Set widget category
     *
     * @since 0.2
     * @return string
     * */
    public function get_category() {
        return 'default';
    }

    /**
     * Register widget settings
     *
     * @since 0.2
     * @return string
     * */
    public function settings() {}

    /**
     * Element template
     *
     * @since 0.2
     * */
    public function render() {
        //if empty render method
        trigger_error(
            sprintf(
                __('The child class does not use the %s method. Widget output cannot be empty', 'cffe'),
            __METHOD__
            )
        );
    }

    /**
     * Main constructor
     * */
    public function __construct() {
        $this->settings();
    }

    /**
     * Set widget setting
     *
     * @since 0.2
     * @param $id string - widget key
     * @param $params array - settings
     * */
    public function set_setting( $id, $params ) {
        $this->settings[$id] = $params;
        $this->defaults[$id] = key_exists('default', $params) ? $params['default'] : '';
    }

    /**
     * Get all registered settings
     *
     * @since 0.2
     * @return array
     * */
    public function get_settings() {
        return $this->settings;
    }

    /**
     * Get all default values of registered settings
     *
     * @since 0.2
     * @return array
     * */
    public function get_defaults() {
        return $this->defaults;
    }

    /**
     * Get html template as string
     *
     * @since 0.2
     * @return string - html code
     * */
    public function get_template() {
        ob_start();
        $this->render();
        return ob_get_clean();
    }
}