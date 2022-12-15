<?php
final class CFC_Code extends CFC_Abstract_Widget {

    public function get_name() {
        return 'cfc-code';
    }

    public function get_title() {
        return 'Код';
    }

    public function settings() {
        $this->set_setting(
            'code',
            [
                'type' => 'textarea_code',
                'title' => 'Код',
                'default' => '<div class="main-code"><b>Just past your custom code</b></div>'
            ]
        );
    }

    public function render() {
        ?>
        {{code}}
        <?php
    }
}