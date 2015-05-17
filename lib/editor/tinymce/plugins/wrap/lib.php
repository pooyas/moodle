<?php



/**
 * @package    editor
 * @subpackage tinymce
 * @copyright  2015 Pooya Saeedi
*/

defined('LION_INTERNAL') || die();

/**
 * Plugin for Lion 'wrap' button.
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
