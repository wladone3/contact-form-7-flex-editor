<?php
/**
 * Widget class
 *
 * @class CFC_Space
 * @since 0.2
 * */
final class CFC_Space extends CFC_Abstract_Widget {

    /**
     * Uniq id for widget
     *
     * @return string
     * */
    public function get_name() {
        return 'cfc-space';
    }

    /**
     * Set title for widget
     *
     * @return string
     * */
    public function get_title() {
        return __('Space', 'cffe');
    }

    /**
     * Set widget category
     *
     * @return string
     * */
    public function get_category(){
        return 'layout';
    }

    /**
     * Widget settings
     * */
    public function settings() {
        $this->set_setting(
            'space',
            [
                'type' => 'range',
                'title' => __('Distance', 'cffe'),
                'min' => 1,
                'max' => 30,
                'default' => 10
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
        <div class="cfc-space" style="height: {{space}}px"></div>
        <?php
    }
}