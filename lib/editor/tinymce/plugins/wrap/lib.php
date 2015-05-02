<?php

defined('LION_INTERNAL') || die();

/**
 * Plugin for Lion 'wrap' button.
 *
 * @package   tinymce_wrap
 * @copyright 2013 Damyon Wiese
 * 
 */
class tinymce_wrap extends editor_tinymce_plugin {
    /** @var array list of buttons defined by this plugin */
    protected $buttons = array('wrap');

    protected function update_init_params(array &$params, context $context,
            array $options = null) {

        // Add JS file, which uses default name.
        $this->add_js_plugin($params);
    }
}
