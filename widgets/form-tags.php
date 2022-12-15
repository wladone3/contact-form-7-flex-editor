<?php
final class CFC_Tag_Generator extends CFC_Abstract_Widget {

    public function get_name() {
        return 'cfc-tags';
    }

    public function get_title() {
        return 'Генератор тега формы';
    }

    public function get_category(){
        return 'form';
    }

    public function settings() {
        $this->set_setting(
            'tag_generator',
            [
                'type' => 'tag-generator',
                'title' => 'Выбирите тег',
            ]
        );

        $this->set_setting(
            'tag_content',
            [
                'type' => 'textarea',
                'title' => 'Контент тега',
                'default' => 'Выбирите тег из списка'
            ]
        );
    }

    public function render() {
        ?>
        {{tag_content}}
        <?php
    }
}