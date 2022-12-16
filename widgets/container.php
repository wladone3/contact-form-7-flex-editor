<?php
/**
 * Widget class
 *
 * @class CFC_Flex_Container
 * @since 0.2
 * */
final class CFC_Flex_Container extends CFC_Abstract_Widget {

    /**
     * Uniq id for widget
     *
     * @return string
     * */
    public function get_name() {
        return 'flex-container';
    }

    /**
     * Set title for widget
     *
     * @return string
     * */
    public function get_title() {
        return __('Container', 'cffe');
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
        $this->set_setting('radio', 'direction', __('Direction', 'cffe'),
            [
                'options' => [
                    'row'               => __('Horizontally', 'cffe'),
                    'column'            => __('Vertically', 'cffe'),
                    'row-reverse'       => __('Horizontally in reverse order', 'cffe'),
                    'column-reverse'    => __('Vertically in reverse order', 'cffe'),
                ],
                'control_class' => 'column',
            ]
        );

        $this->set_setting('range','width', __('Container width', 'cffe'),
            [
                'min' => 0,
                'max' => 100,
                'default' => 100,
            ]
        );

        $this->set_setting('radio', 'width_unit', __('Unit for changing the width of the container', 'cffe'),
            [
                'options' => [
                    '%'     => '%',
                    'px'    => 'px',
                ],
                'default' => '%',
            ]
        );

        $this->set_setting('radio', 'justify_content',  __('Justify content', 'cffe'),
            [
                'options' => [
                    'j-start'     => __('Start', 'cffe'),
                    'j-center'    => __('Center', 'cffe'),
                    'j-end'       => __('End', 'cffe'),
                    'j-space-between'   => __('Between elements', 'cffe'),
                    'j-space-around'    => __('Uniform distance', 'cffe'),
                    'j-space-evenly'    => __('Same distance', 'cffe'),
                ],
                'control_class' => 'column',
            ]
        );

        $this->set_setting('radio', 'align_items', __('Align items', 'cffe'),
            [
                'options' => [
                    'a-start'     => __('Start', 'cffe'),
                    'a-center'    => __('Center', 'cffe'),
                    'a-end'       => __('End', 'cffe'),
                    'a-stretch'   => __('Between elements', 'cffe'),
                ],
                'control_class' => 'column',
            ]
        );

        $this->set_setting('radio', 'text_align', __('Text align', 'cffe'),
            [
                'options' => [
                    't-left'     => __('Left', 'cffe'),
                    't-center'   => __('Center', 'cffe'),
                    't-right'    => __('Right', 'cffe'),
                ],
                'control_class' => 'column',
            ]
        );


        $this->set_setting('range', 'gap', __('Distance between widgets', 'cffe'),
            [
                'min'       => 0,
                'max'       => 50,
                'default'   => 15
            ]
        );

        $this->set_setting('checkbox', 'mob_adaptive', __('Move to lines at the mod extension (768px)', 'cffe'),
            [
                'return'    => 'adaptive',
                'default'   => 'adaptive',
            ]
        );

        $this->set_setting('checkbox', 'mob_reverse', __('Reverse the lines on the mobile version', 'cffe'),
            [
                'return'    => 'mob-reverse',
                'default'   => '',
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
        <div class="
        flex-container
        {{direction}}
        {{justify_content}}
        {{align_items}}
        {{mob_adaptive}}
        {{text_align}}
        {{mob_reverse}}" style="gap:{{gap}}px; width:{{width}}{{width_unit}}"></div>
        <?php
    }
}