<?php


/**
 * Post-install code for the assignfeedback_file module.
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();

/**
 * Code run after the assignfeedback_file module database tables have been created.
 * Moves the feedback file plugin down
 *
 * @return bool
 */
function xmldb_assignfeedback_file_install() {
    global $CFG;

    require_once($CFG->dirroot . '/mod/assign/adminlib.php');

    // Set the correct initial order for the plugins.
    $pluginmanager = new assign_plugin_manager('assignfeedback');
    $pluginmanager->move_plugin('file', 'down');

    return true;
}


