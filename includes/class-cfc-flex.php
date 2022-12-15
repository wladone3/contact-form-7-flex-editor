<?php
final class CFC_PlDugin {
    private static $_instance = null;

    public $widgets = [];

    public $categories = [];

    public $widgets_with_categories = [];

    /**
     * @var CFC_Controller
     */
    public $controller = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        $this->init();

        $this->register_categories();
        $this->set_widgets();
        $this->set_widgets_category();
        $this->actions();
    }

    public function init() {
        require FCF_DIR . 'includes/controller-class.php';

        $this->controller = new CFC_Controller();
    }

    public function actions() {
        add_action( 'admin_enqueue_scripts', [$this, 'admin_enqueue_scripts_action'] );
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_scripts_action'] );
        add_filter('wpcf7_editor_panels', [$this,'fcf_wpcf7_editor_panels'] );
        add_action('wpcf7_after_save', [$this, 'save_widgets_data']);
    }

    public function set_widgets() {
        require FCF_DIR . 'widgets/container.php';
        require FCF_DIR . 'widgets/form-tags.php';
        require FCF_DIR . 'widgets/space.php';
        require FCF_DIR . 'widgets/label.php';
        require FCF_DIR . 'widgets/title.php';
        require FCF_DIR . 'widgets/desc.php';

        // todo когда подключаем редактор не отображаются иконки
//        require FCF_DIR . 'widgets/WYSIWYG.php';
        require FCF_DIR . 'widgets/code.php';

        $this->widgets[] = new CFC_Flex_Container;
        $this->widgets[] = new CFC_Tag_Generator;
        $this->widgets[] = new CFC_Space;
        $this->widgets[] = new CFC_Label;
        $this->widgets[] = new CFC_Title;
        $this->widgets[] = new CFC_Description;
//        $this->widgets[] = new CFC_WYSIWYG;
        $this->widgets[] = new CFC_Code;
    }

    public function register_categories() {
        $this->categories = [
            'layout'  => 'Разметка',
            'form'    => 'Форма',
            'text'    => 'Текст',
            'default' => 'Другое',
        ];
    }


    public function set_widgets_category() {
        $widgets_with_categories = [];

        foreach ($this->widgets as $widget) {
            $is_category_isset = key_exists( $widget->get_category(), $this->categories );

            if ( ! $is_category_isset ) {
                trigger_error('Виджет ' .get_class($widget) . ' использует не заригестрированую категорию ' . $widget->get_category() );
                continue;
            }

            $widgets_with_categories[$widget->get_category()][] = $widget;
        }

        $this->widgets_with_categories = $widgets_with_categories;
    }

    public function get_widgets() {
        return $this->widgets;
    }

    public function get_widgets_with_category() {
        return $this->widgets_with_categories;
    }

    public function get_category_label($category_id) {
        return $this->categories[$category_id];
    }

    public function admin_enqueue_scripts_action( $hook_suffix ){
        if ( false === strpos( $hook_suffix, 'wpcf7' ) ) {
            return;
        }

        //drag-n-drop
        wp_enqueue_style('dragula',FCF_ASSETS . 'assets/libs/dracula/dragula.min.css', [],  );
        wp_enqueue_script('dragula', FCF_ASSETS . 'assets/libs/dracula/dragula.min.js', [], FCF_VERSION, true);

        //main styles
        wp_enqueue_style('fcf-front',FCF_ASSETS . 'assets/css/front.css', [] );
        wp_enqueue_style('fcf',FCF_ASSETS . 'assets/css/style.css', [] );
        wp_enqueue_script('fcf', FCF_ASSETS . 'assets/js/main.js', ['wpcf7-admin-taggenerator'], FCF_VERSION, true);

        wp_add_inline_script( 'fcf', 'const CFCWidgetsData = ' . json_encode( $this->get_data() ), 'before' );
    }

    public function enqueue_scripts_action() {
        wp_enqueue_style('fcf',FCF_ASSETS . 'assets/css/front.css', [] );
    }

    public function fcf_wpcf7_editor_panels($panels) {
        $panels['form-panel']['callback'] = [$this, 'fcf_get_edit_template'];
        return $panels;
    }

    public function fcf_get_edit_template($post) {
        usp_core_get_template('templates/admin-edit.php', [
            'post' => $post,
        ]);
    }

    public function get_data() {
        $widgets = $this->get_widgets();

        $data = [];

        foreach ($widgets as $widget) {
            $widget_data = [
                'name'              => $widget->get_name(),
                'title'             => $widget->get_title(),
                'controls'          => $this->controller->get_controllers($widget->get_settings()),
                'template'          => $widget->get_template(),
                'controls_default'  => $widget->get_defaults(),
            ];

            $data[$widget->get_name()] = $widget_data;
        }

        return $data;
    }

    public function save_widgets_data($form) {
        update_post_meta( $form->id, 'cfc_widgets_data', esc_html( $_POST['cfc-widgets-settings'] ) );
    }
}

if ( ! function_exists('CFC_PlDugin_ws') ) {
    function CFC_PlDugin_ws() {
        return CFC_PlDugin::instance();
    }
}