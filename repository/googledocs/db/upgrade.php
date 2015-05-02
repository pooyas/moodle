<?php

/**
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_repository_googledocs_upgrade($oldversion) {
    global $CFG, $DB;
    require_once(__DIR__.'/upgradelib.php');

    $dbman = $DB->get_manager();

    if ($oldversion < 2012051400) {
        // Delete old user preferences containing authsub tokens.
        $DB->delete_records('user_preferences', array('name' => 'google_authsub_sesskey'));
        upgrade_plugin_savepoint(true, 2012051400, 'repository', 'googledocs');
    }

    if ($oldversion < 2012053000) {
        require_once($CFG->dirroot.'/repository/lib.php');
        $existing = $DB->get_record('repository', array('type' => 'googledocs'), '*', IGNORE_MULTIPLE);

        if ($existing) {
            $googledocsplugin = new repository_type('googledocs', array(), true);
            $googledocsplugin->delete();
            repository_googledocs_admin_upgrade_notification();
        }

        upgrade_plugin_savepoint(true, 2012053000, 'repository', 'googledocs');
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
