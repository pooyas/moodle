<?php


/**
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 * @package    repository
 * @subpackage dropbox
 * @copyright  2015 Pooya Saeedi
 */
function xmldb_repository_dropbox_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    // Lion v2.3.0 release upgrade line
    // Put any upgrade step following this

    if ($oldversion < 2012080702) {
        // Set the default value for dropbox_cachelimit
        $value = get_config('dropbox', 'dropbox_cachelimit');
        if (empty($value)) {
            set_config('dropbox_cachelimit', 1024*1024, 'dropbox');
        }
        upgrade_plugin_savepoint(true, 2012080702, 'repository', 'dropbox');
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
