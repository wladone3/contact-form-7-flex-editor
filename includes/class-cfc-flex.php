<?php
/**
 * Main CFFE_Plugin Class.
 *
 * @since 0.2
 * @class CFFE_Plugin
 */
final class CFFE_Plugin {

    /**
     * The single instance of the class.
     *
     * @var CFFE_Plugin
     * @since 0.2
     */
    private static $_instance = null;

    /**
     * All widget classes
     *
     * @since 0.2
     */
    private $widgets = [];

    /**
     * Categories of widgets
     *
     * @since 0.2
     */
    private $categories = [];

    /**
     * Sort categories of widgets
     *
     * @since 0.2
     */
    private $widgets_with_categories = [];

    /**
     * Controllers Class
     *
     * @var CFFE_Controller
     * @since 0.2
     */
    private $controller = null;

    /**
     * Main CFFE_Plugin Instance.
     *
     * Ensures only one instance of CFFE_Plugin is loaded or can be loaded.
     *
     * @since 0.2
     * @static
     * @see CFFE()
     * @return CFFE_Plugin - Main instance.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * CFFE_Plugin construct
     * */
    private function __construct() {
        if ( is_admin() ) {
            $this->init();

            $this->register_categories();
            $this->register_widgets();
            $this->set_widgets_category();
            $this->actions();
        } else {
            $this->front_actions();
        }
    }

    /**
     * Include and init files
     *
     * @since 0.2
     * */
    private function init() {
        require CFFE_DIR . 'includes/controller-class.php';

        $this->controller = new CFFE_Controller();
    }

    /**
     * Hook and actions for admin
     *
     * @since 0.2
     * */
    private function actions() {
        add_action( 'admin_enqueue_scripts', [$this, 'admin_enqueue_scripts_action'] );
        add_filter( 'wpcf7_editor_panels', [$this,'fcf_wpcf7_editor_panels'] );
        add_action( 'wpcf7_save_contact_form', [$this, 'save_widgets_data'] );

        add_filter('wpcf7_pre_construct_contact_form_properties', [$this, 'cffe_pre_construct_contact_form_properties']);
        add_filter('wpcf7_default_template', [$this, 'cffe_default_template'], 10, 2);
    }

    /**
     * Hook and actions for front only
     *
     * @since 0.2
     * */
    private function front_actions() {
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_scripts_action'] );
        add_filter( 'wpcf7_autop_or_not', '__return_false');
    }

    /**
     * Register widgets
     *
     * @since 0.2
     * */
    private function register_widgets() {
        require CFFE_DIR . 'widgets/container.php';
        require CFFE_DIR . 'widgets/space.php';
        require CFFE_DIR . 'widgets/divider.php';
        require CFFE_DIR . 'widgets/form-tags.php';
        require CFFE_DIR . 'widgets/label.php';
        require CFFE_DIR . 'widgets/title.php';
        require CFFE_DIR . 'widgets/desc.php';
        require CFFE_DIR . 'widgets/code.php';

        $this->widgets[] = new CFC_Flex_Container;
        $this->widgets[] = new CFC_Space;
        $this->widgets[] = new CFC_Divider;
        $this->widgets[] = new CFC_Tag_Generator;
        $this->widgets[] = new CFC_Label;
        $this->widgets[] = new CFC_Title;
        $this->widgets[] = new CFC_Description;
        $this->widgets[] = new CFC_Code;

        // todo когда подключаем редактор не отображаются иконки
        //require CFFE_DIR . 'widgets/WYSIWYG.php';
        //$this->widgets[] = new CFC_WYSIWYG;

        /**
         * Use this filter for add your widget
         * */
        $this->widgets = apply_filters('cffe_register_widgets', $this->widgets);
    }

    /**
     * Register widget categories
     *
     * Can`t be overdrive exist category
     * @since 0.2
     * */
    private function register_categories() {
        $default_cats = [
            'layout'  => __('Layout', 'cffe'),
            'form'    => __('Form', 'cffe'),
            'text'    => __('Text', 'cffe'),
            'default' => __('Other', 'cffe'),
        ];

        /**
         * Use this filter for add your categories
         * */
        $this->categories = apply_filters('cffe_register_categories', $default_cats);
    }


    /**
     * Links widget and category for convenient output
     *
     * @since 0.2
     * */
    private function set_widgets_category() {
        $widgets_with_categories = [];

        foreach ($this->widgets as $widget) {
            $is_category_isset = key_exists( $widget->get_category(), $this->categories );

            if ( ! $is_category_isset ) {

                //category does not exist
                trigger_error(
                    sprintf(
                        __('The %s widget uses a category %s that is not registered', 'cffe'),
                        get_class($widget),
                        $widget->get_category()
                    )
                );
                continue;
            }

            $widgets_with_categories[$widget->get_category()][] = $widget;
        }

        $this->widgets_with_categories = $widgets_with_categories;
    }

    /**
     * Get widgets list
     *
     * @return array
     * @sicne 0.2
     * */
    public function get_widgets() {
        return $this->widgets;
    }

    /**
     * Get a list of categories and their corresponding widgets
     *
     * @return array
     * @sicne 0.2
     * */
    public function get_widgets_with_category() {
        return $this->widgets_with_categories;
    }

    /**
     * Get category name
     *
     * @var $category_id int
     * @return string
     * @sicne 0.2
     * */
    public function get_category_label($category_id) {
        return $this->categories[$category_id];
    }

    /**
     * Admin register scripts and styles
     *
     * @sicne 0.2
     * */
    public function admin_enqueue_scripts_action( $hook_suffix ){
        if ( false === strpos( $hook_suffix, 'wpcf7' ) ) {
            return;
        }

        //drag-n-drop
        wp_enqueue_style('dragula',CFFE_ASSETS . 'assets/libs/dracula/dragula.min.css', [],  );
        wp_enqueue_script('dragula', CFFE_ASSETS . 'assets/libs/dracula/dragula.min.js', [], CFFE_VERSION, true);

        //main styles
        wp_enqueue_style('fcf-front',CFFE_ASSETS . 'assets/css/front.css', [] );
        wp_enqueue_style('fcf',CFFE_ASSETS . 'assets/css/style.css', [] );
        wp_enqueue_script('fcf', CFFE_ASSETS . 'assets/js/main.js', ['wpcf7-admin-taggenerator'], CFFE_VERSION, true);

        wp_add_inline_script( 'fcf', 'const CFCWidgetsData = ' . json_encode( $this->get_front_data() ), 'before' );
    }

    /**
     * Front-end register scripts and styles
     *
     * @sicne 0.2
     * */
    public function enqueue_scripts_action() {
        wp_enqueue_style('fcf',CFFE_ASSETS . 'assets/css/front.css', [] );
    }

    /**
     * Replace default admin template
     *
     * @sicne 0.2
     * */
    public function fcf_wpcf7_editor_panels($panels) {
        $panels['form-panel']['callback'] = [$this, 'fcf_get_edit_template'];
        return $panels;
    }

    /**
     * Get new admin edit template
     *
     * @sicne 0.2
     * */
    public function fcf_get_edit_template($post) {
        cffe_get_template('templates/admin-edit.php', [
            'post' => $post,
        ]);
    }

    /**
     * Setup to front all data of widgets
     *
     * @sicne 0.2
     * */
    public function get_front_data() {
        $widgets = $this->get_widgets();

        $data = [];

        foreach ($widgets as $widget) {
            $widget_data = [
                'name'              => $widget->get_name(),
                'title'             => $widget->get_title(),
                'controls'          => $this->controller->get_controllers( $widget->get_settings() ),
                'template'          => $widget->get_template(),
                'controls_default'  => $widget->get_defaults(),
            ];

            $data[$widget->get_name()] = $widget_data;
        }

        return apply_filters('cffe_get_front_data', $data);
    }

    /**
     * Add custom property data for save
     *
     * @sicne 0.2
     * @hook wpcf7_save_contact_form
     * */
    public function save_widgets_data($form) {
        //data about widgets settings
        $form->set_properties( ['cffe_widgets_data' => wp_unslash($_POST['cffe_widgets_data']) ] );
    }

    /**
     * Make custom properties
     *
     * @since 0.2.1
     * @param $builtin_properties array default properties
     * @return array modified properties
     * @filter wpcf7_pre_construct_contact_form_properties
     * */
    public function cffe_pre_construct_contact_form_properties($builtin_properties) {
        $builtin_properties['cffe_widgets_data'] = '';
        return $builtin_properties;
    }

    /**
     * Add and change default form template
     *
     * @since 0.2.1
     * @filter wpcf7_default_template
     * @param $template string current template
     * @param $prop string current property
     * @return string template
     * */
    public function cffe_default_template( $template, $prop ) {
        if ( $prop === 'cffe_widgets_data' ) {
            $template = cffe_get_template('templates/default-widget-data', [], false);
        }

        if ( $prop === 'form' ) {
            $template = cffe_get_template('templates/default-form-template', [], false);
        }

        return $template;
    }

}

if ( ! function_exists('CFFE') ) {

    /**
     * Returns the main instance of CFFE_Plugin.
     *
     * @since  0.2
     * @return CFFE_Plugin
     */
    function CFFE() {
        return CFFE_Plugin::instance();
    }
}