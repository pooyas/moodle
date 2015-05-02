<?php

/**
 * Database log store upgrade.
 *
 * @package    logstore_database
 * @copyright  2014 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * 
 */

function xmldb_logstore_database_upgrade($oldversion) {

    if ($oldversion < 2014041700) {
        // Clean up old config.
        unset_config('excludelevels', 'logstore_database');
        unset_config('excludeactions', 'logstore_database');

        // Savepoint reached.
        upgrade_plugin_savepoint(true, 2014041700, 'logstore', 'database');
    }

    // Lion v2.7.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
