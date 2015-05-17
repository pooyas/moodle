<?php



/**
 * @package    editor
 * @subpackage tinymce
 * @copyright  2015 Pooya Saeedi
*/

defined('LION_INTERNAL') || die();

/**
 * CTRL + right click helper
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
