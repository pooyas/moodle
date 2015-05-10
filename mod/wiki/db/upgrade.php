<?php

/**
 * This file keeps track of upgrades to the wiki module
 *
 * Sometimes, changes between versions involve
 * alterations to database structures and other
 * major things that may break installations.
 *
 * The upgrade function in this file will attempt
 * to perform all the necessary actions to upgrade
 * your older installation to the current version.
 *
 * @package mod
 * @subpackage wiki
 * @copyright 2015 Pooya Saeedi
 *
 *
 */

function xmldb_wiki_upgrade($oldversion) {
    global $CFG, $DB, $OUTPUT;

    $dbman = $DB->get_manager();


    // Lion v2.2.0 release upgrade line
    // Put any upgrade step following this

    // Lion v2.3.0 release upgrade line
    // Put any upgrade step following this

    if ($oldversion < 2012061701) {
        // Drop all legacy upgrade tables, not used anymore.

        $table = new xmldb_table('wiki_entries_old');
        if ($dbman->table_exists('wiki_entries_old')) {
            $dbman->drop_table($table);
        }

        $table = new xmldb_table('wiki_locks_old');
        if ($dbman->table_exists('wiki_locks_old')) {
            $dbman->drop_table($table);
        }

        $table = new xmldb_table('wiki_pages_old');
        if ($dbman->table_exists('wiki_pages_old')) {
            $dbman->drop_table($table);
        }

        upgrade_plugin_savepoint(true, 2012061701, 'mod', 'wiki');
    }


    // Lion v2.4.0 release upgrade line
    // Put any upgrade step following this


    // Lion v2.5.0 release upgrade line.
    // Put any upgrade step following this.


    // Lion v2.6.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.7.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
