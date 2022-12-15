<?php
final class CFC_WYSIWYG extends CFC_Abstract_Widget {

    public function get_name() {
        return 'WYSIWYG';
    }

    public function get_title() {
        return 'Rich text';
    }

    public function get_category() {
        return 'text';
    }

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

    public function render() {
        ?>
        <div class="content">{{text}}</div>
        <?php
    }
}