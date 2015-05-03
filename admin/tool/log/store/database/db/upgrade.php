<?php

/**
 * Database log store upgrade.
 *
 * @package    tool
 * @subpackage log
 * @copyright  2015 Pooya Saeedi 
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


    return true;
}
