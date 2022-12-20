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
 * Requires at least: 7.2
 *
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Version:     0.2.3
*/
define ('FCF_DIR',         plugin_dir_path(__FILE__ ));    //for require php file
define ('FCF_ASSETS',      plugin_dir_url(__FILE__));      //directory to assets files
define ('FCF_VERSION',      '0.2.3');

add_action( 'plugins_loaded', 'cffe_onload' );
function cffe_onload() {
    load_plugin_textdomain( 'cffe', false, dirname( plugin_basename( __FILE__ ) ) . '/i18n/' );
}

require FCF_DIR . 'includes/abstract-widget-class.php';
require FCF_DIR . 'includes/class-cfc-flex.php';
require FCF_DIR . 'includes/inc.php';

add_action('init', 'CFFE');

