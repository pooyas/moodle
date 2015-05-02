<?php

/**
 * Standard log store upgrade.
 *
 * @package    logstore_standard
 * @copyright  2014 Petr Skoda
 * 
 */

function xmldb_logstore_standard_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2014032000) {

        // Define field anonymous to be added to logstore_standard_log.
        $table = new xmldb_table('logstore_standard_log');
        $field = new xmldb_field('anonymous', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0', 'relateduserid');

        // Conditionally launch add field anonymous.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Standard savepoint reached.
        upgrade_plugin_savepoint(true, 2014032000, 'logstore', 'standard');
    }

    if ($oldversion < 2014041500) {

        // Define index contextid-component (not unique) to be dropped form logstore_standard_log.
        $table = new xmldb_table('logstore_standard_log');
        $index = new xmldb_index('contextid-component', XMLDB_INDEX_NOTUNIQUE, array('contextid', 'component'));

        // Conditionally launch drop index contextid-component.
        if ($dbman->index_exists($table, $index)) {
            $dbman->drop_index($table, $index);
        }

        // Define index courseid (not unique) to be dropped form logstore_standard_log.
        $table = new xmldb_table('logstore_standard_log');
        $index = new xmldb_index('courseid', XMLDB_INDEX_NOTUNIQUE, array('courseid'));

        // Conditionally launch drop index courseid.
        if ($dbman->index_exists($table, $index)) {
            $dbman->drop_index($table, $index);
        }

        // Define index eventname (not unique) to be dropped form logstore_standard_log.
        $table = new xmldb_table('logstore_standard_log');
        $index = new xmldb_index('eventname', XMLDB_INDEX_NOTUNIQUE, array('eventname'));

        // Conditionally launch drop index eventname.
        if ($dbman->index_exists($table, $index)) {
            $dbman->drop_index($table, $index);
        }

        // Define index crud (not unique) to be dropped form logstore_standard_log.
        $table = new xmldb_table('logstore_standard_log');
        $index = new xmldb_index('crud', XMLDB_INDEX_NOTUNIQUE, array('crud'));

        // Conditionally launch drop index crud.
        if ($dbman->index_exists($table, $index)) {
            $dbman->drop_index($table, $index);
        }

        // Define index edulevel (not unique) to be dropped form logstore_standard_log.
        $table = new xmldb_table('logstore_standard_log');
        $index = new xmldb_index('edulevel', XMLDB_INDEX_NOTUNIQUE, array('edulevel'));

        // Conditionally launch drop index edulevel.
        if ($dbman->index_exists($table, $index)) {
            $dbman->drop_index($table, $index);
        }

        // Define index course-time (not unique) to be added to logstore_standard_log.
        $table = new xmldb_table('logstore_standard_log');
        $index = new xmldb_index('course-time', XMLDB_INDEX_NOTUNIQUE, array('courseid', 'anonymous', 'timecreated'));

        // Conditionally launch add index course-time.
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        // Define index user-module (not unique) to be added to logstore_standard_log.
        $table = new xmldb_table('logstore_standard_log');
        $index = new xmldb_index('user-module', XMLDB_INDEX_NOTUNIQUE, array('userid', 'contextlevel', 'contextinstanceid', 'crud', 'edulevel', 'timecreated'));

        // Conditionally launch add index user-module.
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        // Standard savepoint reached.
        upgrade_plugin_savepoint(true, 2014041500, 'logstore', 'standard');
    }

    // Lion v2.7.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
