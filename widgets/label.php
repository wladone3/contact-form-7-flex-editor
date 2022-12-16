<?php
/**
 * Widget class
 *
 * @class CFC_Label
 * @since 0.2
 * */
final class CFC_Label extends CFC_Abstract_Widget {

    /**
     * Uniq id for widget
     *
     * @return string
     * */
    public function get_name() {
        return 'cfc-label';
    }

    /**
     * Set title for widget
     *
     * @return string
     * */
    public function get_title() {
        return __('Label for input', 'cffe');
    }

    /**
     * Set widget category
     *
     * @return string
     * */
    public function get_category(){
        return 'form';
    }

    /**
     * Widget settings
     * */
    public function settings() {
        $this->set_setting('textarea', 'name', __('Field title', 'cffe'),
            [
                'default'   => __('Field title', 'cffe')
            ]
        );

        $this->set_setting( 'text', 'for', __('For', 'cffe') );
    }

    /**
     * Render template
     *
     * {{setting_id}} - The value will be replaced by the corresponding setting
     * */
    public function render() {
        ?>
        <label for="{{for}}">{{name}}</label>
        <?php
    }
}