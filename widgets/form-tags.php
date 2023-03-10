<?php
/**
 * Widget class
 *
 * @class CFC_Tag_Generator
 * @since 0.2
 * */
final class CFC_Tag_Generator extends CFC_Abstract_Widget {

    /**
     * Uniq id for widget
     *
     * @return string
     * */
    public function get_name() {
        return 'cfc-tags';
    }

    /**
     * Set title for widget
     *
     * @return string
     * */
    public function get_title() {
        return __('Form tag generator', 'cffe');
    }

    /**
     * Set widget category
     *
     * @return string
     * */
    public function get_category(){
        return 'form';
    }

    /**
     * Widget settings
     * */
    public function settings() {
        $this->set_setting('tag-generator', 'tag_generator', __('Chose tag', 'cffe') );

        $this->set_setting('textarea', 'tag_content', __('Tag content', 'cffe'),
            [
                'default' => 'Выбирите тег из списка'
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
        {{tag_content}}
        <?php
    }
}