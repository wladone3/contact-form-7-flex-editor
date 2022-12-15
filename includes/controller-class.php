<?php
final class CFC_Controller {

    public $controllers = [];


    public function __construct() {
        $this->registerControllers();
    }

    public function registerControllers() {
        $this->controllers = [
            'textarea'      => [$this, 'textarea'],
            'select'        => [$this, 'select'],
            'tag-generator' => [$this, 'tag_generator'],
            'radio'         => [$this, 'radio'],
            'range'         => [$this, 'range'],
            'text'         => [$this, 'text'],
            'WYSIWYG'         => [$this, 'wysiwyg'],
            'textarea_code'         => [$this, 'textarea_code'],
            'checkbox'         => [$this, 'checkbox'],
        ];

    }

    public function registerController($controller_type, $callback) {
        $this->controllers[$controller_type] = $callback;
    }

    public function get_controllers($settings) {
        $controllers = '';

        foreach ($settings as $setting_id => $options) {
            $data = [];
            $data['setting_id'] = $setting_id;
            $data = array_merge($data, $options);
            $controllers .= $this->render_controller($options['type'], $data);
        }

        return $controllers;
    }

    public function render_controller($type, $args) {
        $classes = $args['setting_id'] . ' ' . $type;

        if ( isset( $args['control_class'] ) ) {
            $classes .= ' ' .  $args['control_class'];
        }

        ob_start();  ?>

        <div class="cfc-control-field  <?php echo $classes ?>" >
            <?php if ( $args['title'] ): ?>
                <h3 class="cfc-control__name"><?php echo $args['title'] ?></h3>
            <?php endif; ?>

            <div class="cfc-control__content">
                <?php call_user_func($this->controllers[$type], $args) ?>
            </div>
        </div>

        <?php
        return ob_get_clean();
    }

    public function text($args) { ?>
        <input
                type="text"
                class="cfc-control"
                data-setting-id="<?php echo $args['setting_id'] ?>"
                name="<?php echo $args['setting_id'] ?>"
        >
        <?php
    }

    public function textarea($args) { ?>
        <textarea
            class="cfc-control cfc-control-keyup textarea-control"
            data-setting-id="<?php echo $args['setting_id'] ?>"
            name="<?php echo $args['setting_id'] ?>"
            rows="5"
                >
        </textarea>
    <?php
    }

    public function select($args) { ?>
        <select
                name="<?php echo $args['setting_id'] ?>"
                class="cfc-control cfc-control-change"
                data-setting-id="<?php echo $args['setting_id'] ?>"
        >
            <?php foreach ($args['options'] as $val => $label): ?>
                <option value="<?php echo $val ?>">
                    <?php echo $label ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php
    }

    public function tag_generator($args) { ?>
        <fieldset>
            <?php
            $tag_generator = WPCF7_TagGenerator::get_instance();
            $tag_generator->print_buttons();
            ?>
        </fieldset>
        <?php
    }

    public function radio($args) { ?>
        <?php foreach ($args['options'] as $val => $label): ?>
            <label>
                <input
                        type="radio"
                        name="<?php echo $args['setting_id'] ?>"
                        value="<?php echo $val ?>"
                        data-setting-id="<?php echo $args['setting_id'] ?>"
                        class="cfc-control cfc-control-change"
                >
                <?php echo $label ?>
            </label>
        <?php endforeach; ?>
        <?php
    }

    public function range($args) {
        $range = ['min', 'max', 'step'];
        $range_attrs = '';

        foreach ($range as $item) {
            if ( ! key_exists($item,$args) ) continue;
            $range_attrs .= ' ' . $item . '="'. $args[$item] .'"';
        }

        ?>
        <input
                type="range"
                <?php echo $range_attrs ?>
        >

        <input
                type="number"
                class="cfc-control"
                data-setting-id="<?php echo $args['setting_id'] ?>"
                name="<?php echo $args['setting_id'] ?>"
        >
    <?php }

    public function wysiwyg($args) {
        wp_editor('', 'cfcwysiwyg', [
            'textarea_name' => 'cfcwysiwyg',
            'drag_drop_upload' => true,
            'textarea_rows' => 10,
            'dfw' => true,
        ]);
    }

    public function textarea_code($args) { ?>
        <textarea
                class="cfc-control cfc-control-keyup textarea-control text-area-code"
                data-setting-id="<?php echo $args['setting_id'] ?>"
                name="<?php echo $args['setting_id'] ?>"
                rows="20"
        >
        </textarea>
    <?php }

    public function checkbox($args) {
        ?>
        <input
                type="checkbox"
                class="cfc-control"
                data-setting-id="<?php echo $args['setting_id'] ?>"
                value="<?php echo $args['return'] ?>"
                name="<?php echo $args['setting_id'] ?>"
        >
    <?php }
}