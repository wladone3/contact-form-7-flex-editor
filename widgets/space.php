<?php
final class CFC_Space extends CFC_Abstract_Widget {

    public function get_name() {
        return 'cfc-space';
    }

    public function get_title() {
        return 'Интервал';
    }

    public function get_category(){
        return 'layout';
    }

    public function settings() {
        $this->set_setting(
            'space',
            [
                'type' => 'range',
                'title' => 'Растояние',
                'min' => 1,
                'max' => 30,
                'default' => 10
            ]
        );
    }

    public function render() {
        ?>
        <div class="cfc-space" style="height: {{space}}px"></div>
        <?php
    }
}