# Flex editor for contact form 7
The plugin adds the ability to create forms of any complexity by dragging and dropping elements to Contact form 7 plugin. The most important feature that the application provides is the creation of forms without coding. This is a huge advantage for you, as at any time you can quickly and easily create or edit a contact form without the involvement of specialists.

Flex editor for contact form 7 plugin greatly simplifies the approach to working with forms using a special Flex editor. It provides an interface that implements all the simplicity of work. Add new elements, edit them, quickly change form layout in a convenient format.

This plugin improves the experience of interaction with the best variant of contact form plugin - contact form 7

> The plugin is in a constant process of improvement. The current version solves the task with convenient use. Further versions will expand the functionality.
> 

Several features that are planned to be added later:

1. Add the ability to duplicate widgets / containers
2. Add support for canceling actions
3. Add support for hotkeys
4. Create a widget with the editor from WordPress
5. Implementation of conditional logic

[View a detailed list of planned works.](https://www.notion.so/b2656148c658450db86632afb107f44d)

## Instructions for use - for users

If you have already used the Elementor plugin, then there will be no problems with the development of this plugin, since the principle of interaction is somewhat similar, but significantly simplified. But if you have not used Elementor, there will be no problems either.

Install the plugin in any available way on your WordPress site and enable it. The plugin will only work with the pre-installed contact form 7 plugin.

1. Go to the admin menu of contact forms. If there are no forms using Flex editor yet, start creating a new one.

![Add new form](https://groswebdev.com/cffe-data/cffe-1.png)

> We recommend not to use the plugin with old forms. Use the plugin for new forms or for those forms where our editor is already used.
> 
1. You will see an editor with a pre-prepared form. It is advisable to test this template to understand the principle of working with the editor.
2. To add a new widget to the form, drag it from the widgets window. Widgets are sorted by categories for better understanding of their purpose. You can drag a widget to any place in the form.
3. Container - the main component of the form, with which you can build a form of any complexity.

![Conteiner\widget interface example](https://groswebdev.com/cffe-data/cffe-2.png)

Hover over the form. If the form has several containers in it, they will move away to show how many containers you use and have access to them at any time.

To go to the widget editing - click on it or on the blue icon on the widget, to go to the container settings click on the gray icon. Containers can be dragged only by pulling the gray mark, widgets by all its internal content.

You can edit a widget or container only in the settings window for it.

Create new containers and add widgets to them, change their order, quickly and conveniently change any form parameter. I hope this plugin will improve your experience in using contact form 7!

## Instructions for use - for developers

The main direction of extending the plugin is to create your own widgets and controllers for them.

The starting code for creating your own widget (for example, one of the standard widgets):

Instructions for using the functions are provided in the comments to the code.

```php
<?php
/**
 * Widget class
 *
 * @class CFC_Description
 * @since 0.2
 * */
final class Custom_Widget extends CFC_Abstract_Widget {

    /**
     * Uniq id for widget
     *
     * @return string
     * */
    public function get_name() {
        return 'cfc-desc';
    }

    /**
     * Set title for widget
     *
     * @return string
     * */
    public function get_title() {
        return __('Description', 'cffe');
    }

    /**
     * Set widget category
     *
		 * can be: 'layout'|'form'|'text'|'default'|'your_cat'
		 * for use de
     * @return string
     * */
    public function get_category() {
        return 'text';
    }

    /**
     * Widget settings
     * */
    public function settings() {
			/**
	     * Set widget setting
	     *
	     * @param $type    string type of controller
	     * @param $id      string setting key
	     * @param $label   string Setting label
	     * @param $options array  options
	     */
        $this->set_setting('textarea', 'text', __('Description', 'cffe'),
            [
                'default'   => __('Enter description', 'cffe'),
            ]
        );

        $this->set_setting( 'select', 'tag',__('Tag', 'cffe'),
            [
                'options'   => [
                    'p'     => 'p',
                    'span'  => 'span',
                    'div'   => 'div',
                    'b'     => 'b',
                    'i'     => 'i'
                ],
                'default'   => 'p',
            ]
        );
    }

    /**
     * Render template
     *
     * {{setting_id}} - The value will be replaced by the corresponding setting
     * */
    public function render() {
        ?>
        <{{tag}}>{{text}}</{{tag}}>
        <?php
    }
}

//register new widget
add_filter('cffe_register_widgets', 'cffe_add_new_widget');
function cffe_add_new_widget($widgets) {
	$widgets[] = new Custom_Widget();
	return $widgets;
}

//register new category
add_filter('cffe_register_categories', 'cffe_add_new_category');
function cffe_add_new_category($cats) {
	$cats['cat_name'] = __('New cat label');
	return $cats;
}
```

To create your own controller, use this start code:

```php
//register new controller
add_filter('cffe_register_controllers', 'cffe_register_new_controller');
function cffe_register_new_controller($controllers) {
	$controllers['my_controller_type'] = 'my_controller_calback';
	return $controllers;
}

//custom controller
function my_controller_calback($args) { ?>
        <input
                type="text"
                class="cfc-control"
                data-setting-id="<?php echo $args['setting_id'] ?>"
                name="<?php echo $args['setting_id'] ?>"
        >
        <?php
    }
```
