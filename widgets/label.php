<?php
final class CFC_Label extends CFC_Abstract_Widget {

    public function get_name() {
        return 'cfc-label';
    }

    public function get_title() {
        return 'Название поля (label)';
    }

    public function get_category(){
        return 'form';
    }

    public function settings() {
        $this->set_setting(
            'name',
            [
                'type' => 'textarea',
                'title' => 'Название поля',
                'default' => 'Название поля'
            ]
        );

        $this->set_setting(
            'for',
            [
                'type' => 'text',
                'title' => 'Для',
            ]
        );
    }

    public function render() {
        ?>
        <label for="{{for}}">{{name}}</label>
        <?php
    }
}