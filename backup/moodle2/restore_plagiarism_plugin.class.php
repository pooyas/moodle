<?php

/**
 * Defines restore_plagiarism_plugin class
 *
 * @package     core
 * @subpackage backup
 * @copyright   2015 Pooya Saeedi
 */

// Note:
// Renaming required

defined('MOODLE_INTERNAL') || die();

/**
 * Class extending standard restore_plugin in order to implement some
 * helper methods related with the plagiarism plugins
 *
 * TODO: Finish phpdocs
 */
abstract class restore_plagiarism_plugin extends restore_plugin {
    public function define_plugin_structure($connectionpoint) {
        global $CFG;
        if (!$connectionpoint instanceof restore_path_element) {
            throw new restore_step_exception('restore_path_element_required', $connectionpoint);
        }

        //check if enabled at site level and plugin is enabled.
        require_once($CFG->libdir . '/plagiarismlib.php');
        $enabledplugins = plagiarism_load_available_plugins();
        if (!array_key_exists($this->pluginname, $enabledplugins)) {
            return array();
        }
        return parent::define_plugin_structure($connectionpoint);
    }
}
