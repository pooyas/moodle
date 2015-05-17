<?php



/**
 * @package    editor
 * @subpackage tinymce
 * @copyright  2015 Pooya Saeedi
*/

defined('LION_INTERNAL') || die();

/**
 * Plugin for Lion media (audio/video) insertion dialog.
 *
 */
class tinymce_lionmedia extends editor_tinymce_plugin {
    /** @var array list of buttons defined by this plugin */
    protected $buttons = array('lionmedia');

    protected function update_init_params(array &$params, context $context,
            array $options = null) {

        // Add file picker callback.
        if (empty($options['legacy'])) {
            if (isset($options['maxfiles']) and $options['maxfiles'] != 0) {
                $params['file_browser_callback'] = "M.editor_tinymce.filepicker";
            }
        }

        if ($row = $this->find_button($params, 'lionemoticon')) {
            // Add button after 'lionemoticon' icon.
            $this->add_button_after($params, $row, 'lionmedia', 'lionemoticon');
        } else if ($row = $this->find_button($params, 'image')) {
            // Note: We know that the plugin emoticon button has already been added
            // if it is enabled because this plugin has higher sortorder.
            // Otherwise add after 'image'.
            $this->add_button_after($params, $row, 'lionmedia', 'image');
        } else {
            // Add this button in the end of the first row (by default 'image' button should be in the first row).
            $this->add_button_after($params, 1, 'lionmedia');
        }

        // Add JS file, which uses default name.
        $this->add_js_plugin($params);
    }

    protected function get_sort_order() {
        return 110;
    }
}
