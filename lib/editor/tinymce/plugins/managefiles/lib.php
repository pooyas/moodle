<?php



/**
 * @package    editor
 * @subpackage tinymce
 * @copyright  2015 Pooya Saeedi
*/

defined('LION_INTERNAL') || die();

/**
 * Plugin for managing files embedded in the text editor
 *
 */
class tinymce_managefiles extends editor_tinymce_plugin {
    /** @var array list of buttons defined by this plugin */
    protected $buttons = array('managefiles');

    /**
     * Adjusts TinyMCE init parameters for tinymce_managefiles
     *
     * Adds file area restrictions parameters and actual 'managefiles' button
     *
     * @param array $params TinyMCE init parameters array
     * @param context $context Context where editor is being shown
     * @param array $options Options for this editor
     */
    protected function update_init_params(array &$params, context $context,
            array $options = null) {
        global $USER;

        if (!isloggedin() or isguestuser()) {
            // Must be a real user to manage any files.
            return;
        }
        if (!isset($options['maxfiles']) or $options['maxfiles'] == 0) {
            // No files allowed - easy, do not load anything.
            return;
        }

        // Add parameters for filemanager
        $params['managefiles'] = array('usercontext' => context_user::instance($USER->id)->id);
        foreach (array('itemid', 'context', 'areamaxbytes', 'maxbytes', 'subdirs', 'return_types') as $key) {
            if (isset($options[$key])) {
                if ($key === 'context' && is_object($options[$key])) {
                    // Just context id is enough
                    $params['managefiles'][$key] = $options[$key]->id;
                } else {
                    $params['managefiles'][$key] = $options[$key];
                }
            }
        }

        if ($row = $this->find_button($params, 'lionmedia')) {
            // Add button after 'lionmedia' button.
            $this->add_button_after($params, $row, 'managefiles', 'lionmedia');
        } else if ($row = $this->find_button($params, 'image')) {
            // If 'lionmedia' is not found add after 'image'.
            $this->add_button_after($params, $row, 'managefiles', 'image');
        } else {
            // OTherwise add button in the end of the last row.
            $this->add_button_after($params, $this->count_button_rows($params), 'managefiles');
        }

        // Add JS file, which uses default name.
        $this->add_js_plugin($params);
    }

    protected function get_sort_order() {
        return 310;
    }
}
