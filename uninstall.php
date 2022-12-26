<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

if ( ! defined( 'CFFE_VERSION' ) ) {
    cffe_delete_plugin();
}

function cffe_delete_plugin() {
    global $wpdb;

    $wpdb->query( sprintf(
        "DELETE * FROM %s WHERE `meta_key` LIKE 'cffe_widgets_data'",
        $wpdb->post_meta
    ) );
}


