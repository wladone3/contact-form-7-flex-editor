<?php
/*
* Plugin Name:  flex cf7
*/
define ('FCF_DIR',         plugin_dir_path(__FILE__ ));    //for require php file
define ('FCF_ASSETS',      plugin_dir_url(__FILE__));      //directory to assets files
define ('FCF_VERSION',      '0.1');


require FCF_DIR . 'includes/abstract-widget-class.php';
require FCF_DIR . 'includes/class-cfc-flex.php';
require FCF_DIR . 'includes/inc.php';

CFC_PlDugin_ws();

