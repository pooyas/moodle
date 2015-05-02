<?php

defined('LION_INTERNAL') || die();

/**
 * Plugin for inserting and editing of images with Lion file picker support.
 *
 * @package   tinymce_lionimage
 * @copyright 2012 Petr Skoda (http://skodak.org)
 * 
 */
class tinymce_lionimage extends editor_tinymce_plugin {
    /** @var array list of buttons defined by this plugin */
    protected $buttons = array('image');

    protected function update_init_params(array &$params, context $context,
            array $options = null) {

        // Add file picker callback.
        if (empty($options['legacy'])) {
            if (isset($options['maxfiles']) and $options['maxfiles'] != 0) {
                $params['file_browser_callback'] = "M.editor_tinymce.filepicker";
            }
        }

        // This plugin overrides standard 'image' button, no need to insert new button.

        // Add JS file, which uses default name.
        $this->add_js_plugin($params);
    }

    protected function get_sort_order() {
        return 110;
    }
}
