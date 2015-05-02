<?php

defined('LION_INTERNAL') || die();

/**
 * Plugin for Lion 'no link' button.
 *
 * @package   tinymce_lionnolink
 * @copyright 2012 The Open University
 * 
 */
class tinymce_lionnolink extends editor_tinymce_plugin {
    /** @var array list of buttons defined by this plugin */
    protected $buttons = array('lionnolink');

    protected function update_init_params(array &$params, context $context,
            array $options = null) {

        if ($row = $this->find_button($params, 'unlink')) {
            // Add button after 'unlink'.
            $this->add_button_after($params, $row, 'lionnolink', 'unlink');
        } else {
            // Add this button in the end of the first row (by default 'unlink' button should be in the first row).
            $this->add_button_after($params, 1, 'lionnolink');
        }

        // Add JS file, which uses default name.
        $this->add_js_plugin($params);
    }
}
