<?php
final class CFC_Description extends CFC_Abstract_Widget {

    public function get_name() {
        return 'cfc-desc';
    }

    public function get_title() {
        return 'Описание';
    }

    public function get_category() {
        return 'text';
    }

    public function settings() {
        $this->set_setting(
            'text',
            [
                'type' => 'textarea',
                'title' => 'Описание',
                'default' => 'Введите описание'
            ]
        );

        $this->set_setting('tag', [
            'title' => 'Тег',
            'type'  => 'select',
            'default' => 'p',
            'options' => [
                'p' => 'p',
                'span' => 'span',
                'div' => 'div',
                'b' => 'b',
                'i' => 'i'
            ]
        ]);
    }

    public function render() {
        ?>
        <{{tag}}>{{text}}</{{tag}}>
        <?php
    }
}