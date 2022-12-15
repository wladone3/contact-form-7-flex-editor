<?php
if ( ! function_exists('usp_core_get_template')) {
    function usp_core_get_template($template_name, $args = [], $echo = true) {
        extract($args);

        if ( ! preg_match('/\.php/', $template_name) ) {
            $template_name = $template_name . '.php';
        }

        ob_start();
        require FCF_DIR . $template_name;

        if ( $echo ) {
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
