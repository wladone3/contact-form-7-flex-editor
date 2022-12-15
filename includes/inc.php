<?php
if ( ! function_exists('cffe_get_template')) {
    /**
     * Get template
     *
     * @sicne 0.2
     * @param string $template_name path to template from plugin
     * @param array $args all additional params
     * @param bool $echo is print or return template as string
     * */
    function cffe_get_template($template_name, $args = [], $echo = true) {
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
