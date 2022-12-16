<?php
/**
 * Widget class
 *
 * @class CFC_Description
 * @since 0.2
 * */
final class CFC_Description extends CFC_Abstract_Widget {

    /**
     * Uniq id for widget
     *
     * @return string
     * */
    public function get_name() {
        return 'cfc-desc';
    }

    /**
     * Set title for widget
     *
     * @return string
     * */
    public function get_title() {
        return __('Description', 'cffe');
    }

    /**
     * Set widget category
     *
     * @return string
     * */
    public function get_category() {
        return 'text';
    }

    /**
     * Widget settings
     * */
    public function settings() {
        $this->set_setting('textarea', 'text', __('Description', 'cffe'),
            [
                'default'   => __('Enter description', 'cffe'),
            ]
        );

        $this->set_setting( 'select', 'tag',__('Tag', 'cffe'),
            [
                'options'   => [
                    'p'     => 'p',
                    'span'  => 'span',
                    'div'   => 'div',
                    'b'     => 'b',
                    'i'     => 'i'
                ],
                'default'   => 'p',
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
        <{{tag}}>{{text}}</{{tag}}>
        <?php
    }
}