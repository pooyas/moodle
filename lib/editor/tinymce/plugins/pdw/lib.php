<?php



/**
 * @package    editor
 * @subpackage tinymce
 * @copyright  2015 Pooya Saeedi
*/

defined('LION_INTERNAL') || die();

/**
 * Plugin for Lion 'Toolbar Toggle' button.
 *
 */
class tinymce_pdw extends editor_tinymce_plugin {
    /**
     * Adds pdw toggle button if there are more than one row of buttons in TinyMCE
     *
     * @param array $params TinyMCE init parameters array
     * @param context $context Context where editor is being shown
     * @param array $options Options for this editor
     */
    protected function update_init_params(array &$params, context $context,
            array $options = null) {

        $rowsnumber = $this->count_button_rows($params);
        if ($rowsnumber > 1) {
            $this->add_button_before($params, 1, 'pdw_toggle', '');
            $params['pdw_toggle_on'] = 1;
            $params['pdw_toggle_toolbars'] = join(',', range(2, $rowsnumber));

            // Add JS file, which uses default name.
            $this->add_js_plugin($params);
        }
    }

    /**
     * Gets the order in which to run this plugin
     *
     * We need pdw plugin to be added the last, so nothing is added before the button.
     */
    protected function get_sort_order() {
        return 100000;
    }
}
