<?php


/**
 * Logging support.
 *
 * @package    admin_tool
 * @subpackage log
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Install the plugin.
 */
function xmldb_tool_log_install() {
    global $CFG, $DB;

    $enabled = array();

    // Add data to new log only from now on.
    if (file_exists("$CFG->dirroot/$CFG->admin/tool/log/store/standard")) {
        $enabled[] = 'logstore_standard';
    }

    // Enable legacy log reading, but only if there are existing data.
    if (file_exists("$CFG->dirroot/$CFG->admin/tool/log/store/legacy")) {
        unset_config('loglegacy', 'logstore_legacy');
        // Do not enabled legacy logging if somebody installed a new
        // site and in less than one day upgraded to 2.7.
        $params = array('yesterday' => time() - 60*60*24);
        if ($DB->record_exists_select('log', "time < :yesterday", $params)) {
            $enabled[] = 'logstore_legacy';
        }
    }

    set_config('enabled_stores', implode(',', $enabled), 'tool_log');
}
