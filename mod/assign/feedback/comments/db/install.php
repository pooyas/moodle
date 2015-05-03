<?php

/**
 * Post-install code for the feedback_comments module.
 *
 * @package   assignfeedback_comments
 * @copyright 2015 Pooya Saeedi {@link http://www.netspot.com.au}
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Set the initial order for the feedback comments plugin (top)
 * @return bool
 */
function xmldb_assignfeedback_comments_install() {
    global $CFG;

    require_once($CFG->dirroot . '/mod/assign/adminlib.php');

    // Set the correct initial order for the plugins.
    $pluginmanager = new assign_plugin_manager('assignfeedback');
    $pluginmanager->move_plugin('comments', 'up');

    return true;
}
