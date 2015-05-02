<?php

/**
 * Upgrade scirpt for tool_monitor.
 *
 * @package    tool_monitor
 * @copyright  2014 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Upgrade the plugin.
 *
 * @param int $oldversion
 * @return bool always true
 */
function xmldb_tool_monitor_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2014102000) {

        // Define field lastnotificationsent to be added to tool_monitor_subscriptions.
        $table = new xmldb_table('tool_monitor_subscriptions');
        $field = new xmldb_field('lastnotificationsent', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'timecreated');

        // Conditionally launch add field lastnotificationsent.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Monitor savepoint reached.
        upgrade_plugin_savepoint(true, 2014102000, 'tool', 'monitor');
    }

    // Lion v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
