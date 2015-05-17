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
 * Upgrade the plugin.
 *
 * @param int $oldversion
 * @return bool always true
 */
function xmldb_tool_log_upgrade($oldversion) {
    global $CFG, $DB, $OUTPUT;

    $dbman = $DB->get_manager();

    if ($oldversion < 2014040600) {
        // Reset logging defaults in dev branches,
        // in production upgrade the install.php is executed instead.
        require_once(__DIR__ . '/install.php');
        xmldb_tool_log_install();
        upgrade_plugin_savepoint(true, 2014040600, 'tool', 'log');
    }

    // Lion v2.7.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
