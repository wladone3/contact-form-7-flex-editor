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
        require CFFE_DIR . $template_name;

        if ( $echo ) {
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}

if ( ! function_exists('cffe_is_cf_active') ) {
    /**
     * Check is contact form 7 is active
     *
     * @return bool
     * */
    function cffe_is_contact_form_active() {
        return defined('WPCF7_VERSION');
    }
}

if ( ! function_exists('cffe_admin_notice') ) {
    /**
     * Admin notice
     * @hooked admin_notices
     * */
    function cffe_admin_notice() {
        if ( ! cffe_is_contact_form_active() ) {
            ?>
            <div class="cffe-admin-notice notice notice-warning is-dismissible" >
                <p>
                    <?php echo sprintf(
                        '<strong>Flex editor for Contact Form 7</strong> %s <a target="_blank" href="%s">Contact Form 7</a>',
                            esc_html__('depends on Contact Form 7. Please install', 'cffe'),
                            esc_url(get_site_url() . '/wp-admin/plugin-install.php?s=Contact%2520Form%25207&tab=search&type=term'),
                    ) ?>
                </p>
            </div>
            <?php
        }
    }
}
