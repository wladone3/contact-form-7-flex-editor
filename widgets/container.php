<?php
final class CFC_Flex_Container extends CFC_Abstract_Widget {

    public function get_name() {
        return 'flex-container';
    }

    public function get_title() {
        return 'Контейнер';
    }

    public function get_category() {
        return 'layout';
    }

    public function settings() {
        $this->set_setting(
            'direction',
            [
                'type' => 'radio',
                'title' => 'Направление',
                'options' => [
                    'row'    => 'Горизонтально',
                    'column' => 'Вертикально',
                    'row-reverse' => 'Горизонтально в обратном порядке',
                    'column-reverse' => 'Вертикально в обратном порядке',
                ],
                'control_class' => 'column',
            ]
        );

        $this->set_setting(
            'width',
            [
                'type' => 'range',
                'title' => 'Ширина контейнера',
                'min' => 0,
                'max' => 100,
                'default' => 100,
            ]
        );

        $this->set_setting(
            'width_unit',
            [
                'type' => 'radio',
                'title' => 'Единица изменрения ширины контейнера',
                'options' => [
                    '%'     => '%',
                    'px'    => 'px',
                ],
                'default' => '%',
            ]
        );

        $this->set_setting(
            'justify_content',
            [
                'type' => 'radio',
                'title' => 'Распределение',
                'options' => [
                    'j-start'     => 'Старт',
                    'j-center'    => 'Центр',
                    'j-end'       => 'Конец',
                    'j-space-between' => 'Между елементами',
                    'j-space-around' => 'Равномерное',
                    'j-space-evenly' => 'Одинаковое',
                ],
                'control_class' => 'column',
            ]
        );

        $this->set_setting(
            'align_items',
            [
                'type' => 'radio',
                'title' => 'Выравнивание',
                'options' => [
                    'a-start'     => 'Старт',
                    'a-center'    => 'Центр',
                    'a-end'       => 'Конец',
                    'a-stretch' => 'Между елементами',
                ],
                'control_class' => 'column',
            ]
        );

        $this->set_setting(
            'text_align',
            [
                'type' => 'radio',
                'title' => 'Выравнивание текста',
                'options' => [
                    't-left'     => 'Лево',
                    't-center'    => 'Центр',
                    't-right'       => 'Право',
                ],
                'control_class' => 'column',
            ]
        );


        $this->set_setting(
            'gap',
            [
                'type' => 'range',
                'title' => 'Растояние между виджетами',
                'min' => 0,
                'max' => 50,
                'default' => 15
            ]
        );

        $this->set_setting(
            'mob_adaptive',
            [
                'type' => 'checkbox',
                'title' => 'Переносить в строки на моб расширении (768px)',
                'return' => 'adaptive',
                'default' => 'adaptive',
            ]
        );

        $this->set_setting(
            'mob_reverse',
            [
                'type' => 'checkbox',
                'title' => 'Реверс строк на моб версии',
                'return' => 'mob-reverse',
                'default' => '',
            ]
        );
    }

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