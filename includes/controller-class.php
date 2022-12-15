<?php

/**
 * Controllers
 *
 * @since 0.2
 * @class CFFE_Controller
 * */
final class CFFE_Controller {

    /**
     * List of all controllers
     *
     * @since 0.2
     * */
    public $controllers = [];

    /**
     * main construct
     * */
    public function __construct() {
        $this->register_controllers();
    }

    /**
     * Register all defaults controllers
     *
     * type => callback
     * @sicne 0.2
     * */
    public function register_controllers() {
        $this->controllers = [
            'textarea'      => [$this, 'textarea'],
            'select'        => [$this, 'select'],
            'tag-generator' => [$this, 'tag_generator'],
            'radio'         => [$this, 'radio'],
            'range'         => [$this, 'range'],
            'text'          => [$this, 'text'],
            'WYSIWYG'       => [$this, 'wysiwyg'],
            'textarea_code' => [$this, 'textarea_code'],
            'checkbox'      => [$this, 'checkbox'],
        ];

        /**
         * Use this filter for add your controller
         */
        $this->controllers = apply_filters('cffe_register_controllers', $this->controllers);
    }

    /**
     * Render all controllers
     *
     * @sicne 0.2
     * @param $settings array list settings for render
     * @return string html controllers
     * */
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

    /**
     * Render controller
     *
     * @sicne 0.2
     * @param $type string type of controller
     * @param $args array controller setting
     */
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

    /**
     * Controller text
     *
     * @sicne 0.2
     * @param $args array controller setting
     * */
    public function text($args) { ?>
        <input
                type="text"
                class="cfc-control"
                data-setting-id="<?php echo $args['setting_id'] ?>"
                name="<?php echo $args['setting_id'] ?>"
        >
        <?php
    }

    /**
     * Controller textarea
     *
     * @sicne 0.2
     * @param $args array controller setting
     * */
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

    /**
     * Controller select
     *
     * @sicne 0.2
     * @param $args array controller setting
     * */
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

    /**
     * Controller tag generator
     *
     * @sicne 0.2
     * @param $args array controller setting
     * */
    public function tag_generator($args) { ?>
        <fieldset>
            <?php
            $tag_generator = WPCF7_TagGenerator::get_instance();
            $tag_generator->print_buttons();
            ?>
        </fieldset>
        <?php
    }

    /**
     * Controller radio input
     *
     * @sicne 0.2
     * @param $args array controller setting
     * */
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

    /**
     * Controller range input
     *
     * @sicne 0.2
     * @param $args array controller setting
     * */
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

    /**
     * Controller wysiwyg - tynymce
     *
     * @sicne 0.2
     * @param $args array controller setting
     * */
    public function wysiwyg($args) {
        wp_editor('', 'cfcwysiwyg', [
            'textarea_name' => 'cfcwysiwyg',
            'drag_drop_upload' => true,
            'textarea_rows' => 10,
            'dfw' => true,
        ]);
    }

    /**
     * Controller textarea
     *
     * @sicne 0.2
     * @param $args array controller setting
     * */
    public function textarea_code($args) { ?>
        <textarea
                class="cfc-control cfc-control-keyup textarea-control text-area-code"
                data-setting-id="<?php echo $args['setting_id'] ?>"
                name="<?php echo $args['setting_id'] ?>"
                rows="20"
        >
        </textarea>
    <?php }

    /**
     * Controller checkbox
     *
     * @sicne 0.2
     * @param $args array controller setting
     * */
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