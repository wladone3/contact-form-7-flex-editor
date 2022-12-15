<?php
/*
* Plugin Name: Contact Form 7 Flex editor
 * Description: A plugin designed to create a contact form layout of any complexity by dragging and dropping elements.
 * Plugin URI:  flex-editor.groswebdev.com/
 * Author URI:  groswebdev.com
 * Author:      wladone3
 *
 * Text Domain: cffe
 * Domain Path: /i18n
 *
 * Requires PHP: 7.4
 * Requires at least: 5.4
 *
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Network:     true
 * Version:     0.2
*/
define ('FCF_DIR',         plugin_dir_path(__FILE__ ));    //for require php file
define ('FCF_ASSETS',      plugin_dir_url(__FILE__));      //directory to assets files
define ('FCF_VERSION',      '0.2');

add_action( 'plugins_loaded', 'cffe_onload' );
function cffe_onload() {
    load_plugin_textdomain( 'cffe', false, dirname( plugin_basename( __FILE__ ) ) . '/i18n/' );
}

require FCF_DIR . 'includes/abstract-widget-class.php';
require FCF_DIR . 'includes/class-cfc-flex.php';
require FCF_DIR . 'includes/inc.php';

CFFE();

