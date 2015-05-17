<?php


/**
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 * @package    repository
 * @subpackage picasa
 * @copyright  2015 Pooya Saeedi
 */
function xmldb_repository_picasa_upgrade($oldversion) {
    global $CFG, $DB;
    require_once(__DIR__.'/upgradelib.php');

    $dbman = $DB->get_manager();

    if ($oldversion < 2012051400) {
        // Delete old user preferences storing authsub tokens.
        $DB->delete_records('user_preferences', array('name' => 'google_authsub_sesskey_picasa'));
        upgrade_plugin_savepoint(true, 2012051400, 'repository', 'picasa');
    }

    if ($oldversion < 2012053000) {
        require_once($CFG->dirroot.'/repository/lib.php');
        $existing = $DB->get_record('repository', array('type' => 'picasa'), '*', IGNORE_MULTIPLE);

        if ($existing) {
            $picasaplugin = new repository_type('picasa', array(), true);
            $picasaplugin->delete();
            repository_picasa_admin_upgrade_notification();
        }

        upgrade_plugin_savepoint(true, 2012053000, 'repository', 'picasa');
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
