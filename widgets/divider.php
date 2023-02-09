<?php
/**
 * Widget class
 *
 * @class CFC_Description
 * @since 0.2
 * */
final class CFC_Divider extends CFC_Abstract_Widget {

    /**
     * Uniq id for widget
     *
     * @return string
     * */
    public function get_name() {
        return 'cfc-divider';
    }

    /**
     * Set title for widget
     *
     * @return string
     * */
    public function get_title() {
        return __('Divider', 'cffe');
    }

    /**
     * Set widget category
     *
     * @return string
     * */
    public function get_category() {
        return 'layout';
    }

    /**
     * Widget settings
     * */
    public function settings() {
        $this->set_setting('range','gap', __('Gap', 'cffe'),
            [
                'min' => 0,
                'max' => 100,
                'default' => 15,
            ]
        );

        $this->set_setting('radio', 'gap_unit', __('Unit for changing the gap', 'cffe'),
            [
                'options' => [
                    '%'     => '%',
                    'px'    => 'px',
                ],
                'default' => 'px',
            ]
        );

        $this->set_setting('range','width', __('Width', 'cffe'),
            [
                'min' => 0,
                'max' => 100,
                'default' => 100,
            ]
        );

        $this->set_setting('radio', 'width_unit', __('Unit for changing the width of line', 'cffe'),
            [
                'options' => [
                    '%'     => '%',
                    'px'    => 'px',
                ],
                'default' => '%',
            ]
        );

        $this->set_setting('radio', 'align', __('Align divider', 'cffe'),
            [
                'options' => [
                    'flex-start'     => __('Left', 'cffe'),
                    'center'   => __('Center', 'cffe'),
                    'flex-end'    => __('Right', 'cffe'),
                ],
                'default' => 'center',
            ]
        );

        $this->set_setting('color', 'color', __('Color', 'cffe'),
            [
                'default' => '#D2D2D2',
            ]
        );

        $this->set_setting('range','opacity', __('Opacity', 'cffe'),
            [
                'min' => 0,
                'max' => 1,
                'default' => 1,
                'step' => 0.1
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
        <div
                class="divider"
                style="padding: {{gap}}{{gap_unit}} 0; justify-content: {{align}}"
        >
            <span style="max-width: {{width}}{{width_unit}}; background: {{color}}; opacity: {{opacity}}"></span>
        </div>
        <?php
    }
}