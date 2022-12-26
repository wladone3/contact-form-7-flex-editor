<?php
/*
 * Plugin Name: Flex editor for Contact Form 7
 * Description: A plugin designed to create a contact form layout of any complexity by dragging and dropping elements.
 * Plugin URI:  https://github.com/wladone3/flex-editor-for-contact-form-7
 * Author:      wladone3
 *
 * Text Domain: cffe
 * Domain Path: /i18n
 *
 * Requires PHP: 7.4
 * Requires at least: 5
 *
 * Version:     0.2.4
 */

define ('CFFE_DIR',         plugin_dir_path(__FILE__ ));    //for require php file
define ('CFFE_ASSETS',      plugin_dir_url(__FILE__));      //directory to assets files
define ('CFFE_VERSION',      '0.2.4');

define( 'CFFE_REQUIRED_WP_VERSION', '6.0' );
define( 'CFFE_REQUIRED_WPCF7_VERSION', '5.7.1' );

add_action( 'plugins_loaded', 'cffe_onload' );
function cffe_onload() {
    load_plugin_textdomain( 'cffe', false, CFFE_DIR . 'i18n/' );
}

//common functions
require CFFE_DIR . 'includes/inc.php';

add_action('admin_notices', 'cffe_admin_notice');

require CFFE_DIR . 'includes/abstract-widget-class.php';
require CFFE_DIR . 'includes/class-cfc-flex.php';

add_action('init', 'CFFE');

