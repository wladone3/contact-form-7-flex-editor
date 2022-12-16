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
        /*
         * Use this filter for change default category id
         * */
        return apply_filters('cffe_widget_default_category', 'default');
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
     * @param $type    string type of controller
     * @param $id      string setting key
     * @param $label   string Setting label
     * @param $options array  options
     * @since 0.2.1
     */
    public function set_setting( $type, $id, $label = '', $options = []) {
        $this->settings[$id] = array_merge([
            'type' => $type,
            'id'    => $id,
            'label' => $label,
        ], $options);

        $this->defaults[$id] = key_exists('default', $options) ? $options['default'] : '';
    }

    /**
     * Get all registered settings
     *
     * @since 0.2
     * @return array
     * */
    public function get_settings() {
        /*
         * Use this filter for change widget setting
         * */
        return apply_filters('cffe_get_widget_settings', $this->settings, $this );
    }

    /**
     * Get all default values of registered settings
     *
     * @since 0.2
     * @return array
     * */
    public function get_defaults() {
        /*
        * Use this filter for change widget defaults options
        * */
        return apply_filters('cffe_get_widget_defaults', $this->defaults, $this );
    }

    /**
     * Get html template as string
     *
     * @since 0.2
     * @return string - html code
     * */
    public function get_template() {
        ob_start();

        do_action('cffe_before_widget_template', $this);

        $this->render();

        do_action('cffe_after_widget_template', $this);

        return ob_get_clean();
    }
}