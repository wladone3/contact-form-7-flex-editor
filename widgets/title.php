<?php
final class CFC_Title extends CFC_Abstract_Widget {

    public function get_name() {
        return 'cfc-title';
    }

    public function get_title() {
        return 'Заголовок';
    }

    public function get_category() {
        return 'text';
    }

    public function settings() {
        $this->set_setting(
            'text',
            [
                'type' => 'textarea',
                'title' => 'Заголовок',
                'default' => 'Введите залоговок'
            ]
        );

        $this->set_setting('tag', [
            'title' => 'Тег',
            'type'  => 'select',
            'default' => 'h2',
            'options' => [
                'h1' => 'h1',
                'h2' => 'h2',
                'h3' => 'h3',
                'h4' => 'h4',
                'h5' => 'h5',
                'h6' => 'h6',
            ]
        ]);
    }

    public function render() {
        ?>
        <{{tag}}>{{text}}</{{tag}}>
        <?php
    }
}