<?php
/**
 * Widget class
 *
 * @class CFC_Code
 * @since 0.2
 * */
final class CFC_Code extends CFC_Abstract_Widget {

    /**
     * Uniq id for widget
     *
     * @return string
     * */
    public function get_name() {
        return 'cfc-code';
    }

    /**
     * Set title for widget
     *
     * @return string
     * */
    public function get_title() {
        return __('Code', 'cffe');
    }

    /**
     * Widget settings
     * */
    public function settings() {
        $this->set_setting('textarea_code', 'code', __('Code', 'cffe'),
            [
                'default' => '<div class="main-code"><b>'. __('Just past your custom code', 'cffe') .'</b></div>'
            ]
        );
    }

    /**
     * Render template
     *
     * {{setting_id}} - The value will be replaced by the corresponding setting
     * */
    public function render() {
        ?>
        {{code}}
        <?php
    }
}