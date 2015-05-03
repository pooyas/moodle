<?php


/**
 * Defines backup_plagiarism_plugin class
 *
 * @package     core_backup
 * @subpackage  lion2
 * @category    backup
 * @copyright   2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Class extending standard backup_plugin in order to implement some
 * helper methods related with the plagiarism plugins (plagiarism plugin)
 *
 * TODO: Finish phpdocs
 */
abstract class backup_plagiarism_plugin extends backup_plugin {

    public function define_plugin_structure($connectionpoint) {
        global $CFG;
        require_once($CFG->libdir . '/plagiarismlib.php');
        //check if enabled at site level and plugin is enabled.
        $enabledplugins = plagiarism_load_available_plugins();
        if (!array_key_exists($this->pluginname, $enabledplugins)) {
            return;
        }

        parent::define_plugin_structure($connectionpoint);
    }
}