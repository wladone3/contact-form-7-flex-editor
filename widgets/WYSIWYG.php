<?php
/**
 * Widget class
 *
 * @class CFC_Label
 * @since 0.2
 * */
final class CFC_WYSIWYG extends CFC_Abstract_Widget {

    /**
     * Uniq id for widget
     *
     * @return string
     * */
    public function get_name() {
        return 'WYSIWYG';
    }

    /**
     * Set title for widget
     *
     * @return string
     * */
    public function get_title() {
        return 'Rich text';
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
        $this->set_setting(
            'text',
            [
                'type' => 'WYSIWYG',
                'title' => 'Текст',
                'default' => 'Введите текст'
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
        <div class="content">{{text}}</div>
        <?php
    }
}