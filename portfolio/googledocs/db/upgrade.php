<?php

/**
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_portfolio_googledocs_upgrade($oldversion) {
    global $CFG, $DB;
    require_once(__DIR__.'/upgradelib.php');

    $dbman = $DB->get_manager();

    if ($oldversion < 2012053000) {
        // Delete old user preferences containing authsub tokens.
        $DB->delete_records('user_preferences', array('name' => 'google_authsub_sesskey'));
        upgrade_plugin_savepoint(true, 2012053000, 'portfolio', 'googledocs');
    }

    if ($oldversion < 2012053001) {
        $existing = $DB->get_record('portfolio_instance', array('plugin' => 'googledocs'), '*', IGNORE_MULTIPLE);

        if ($existing) {
            portfolio_googledocs_admin_upgrade_notification();
        }

        upgrade_plugin_savepoint(true, 2012053001, 'portfolio', 'googledocs');
    }

    // Lion v2.3.0 release upgrade line
    // Put any upgrade step following this


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
