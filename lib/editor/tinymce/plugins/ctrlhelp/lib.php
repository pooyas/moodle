<?php

defined('LION_INTERNAL') || die();

/**
 * CTRL + right click helper
 *
 * @package   tinymce_ctrlhelp
 * @copyright 2013 Petr Skoda {@link http://skodak.org}
 * 
 */
class tinymce_ctrlhelp extends editor_tinymce_plugin {
    protected function update_init_params(array &$params, context $context, array $options = null) {
        $this->add_js_plugin($params);
    }

    protected function get_sort_order() {
        // We want this plugin to register as the last one in the context menu.
        return 66666;
    }
}
