<?php
/**
 * Widget class
 *
 * @class CFC_Title
 * @since 0.2
 * */
final class CFC_Title extends CFC_Abstract_Widget {

    /**
     * Uniq id for widget
     *
     * @return string
     * */
    public function get_name() {
        return 'cfc-title';
    }

    /**
     * Set title for widget
     *
     * @return string
     * */
    public function get_title() {
        return __('Title', 'cffe');
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
        $this->set_setting('textarea', 'text', __('Title', 'cffe'),
            [
                'default'   => __('Enter title', 'cffe')
            ]
        );

        $this->set_setting('select', 'tag', __('Tag', 'cffe'),
            [
                'options' => [
                    'h1' => 'h1',
                    'h2' => 'h2',
                    'h3' => 'h3',
                    'h4' => 'h4',
                    'h5' => 'h5',
                    'h6' => 'h6',
                ],
                'default' => 'h2',
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