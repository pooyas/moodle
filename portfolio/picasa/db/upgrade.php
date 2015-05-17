<?php


/**
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 * @package    portfolio
 * @subpackage picasa
 * @copyright  2015 Pooya Saeedi
 */
function xmldb_portfolio_picasa_upgrade($oldversion) {
    global $CFG, $DB;
    require_once(__DIR__.'/upgradelib.php');

    $dbman = $DB->get_manager();

    if ($oldversion < 2012053000) {
        // Delete old user preferences containing authsub tokens.
        $DB->delete_records('user_preferences', array('name' => 'google_authsub_sesskey_picasa'));
        upgrade_plugin_savepoint(true, 2012053000, 'portfolio', 'picasa');
    }

    if ($oldversion < 2012053001) {
        $existing = $DB->get_record('portfolio_instance', array('plugin' => 'picasa'), '*', IGNORE_MISSING);

        if ($existing) {
            portfolio_picasa_admin_upgrade_notification();
        }

        upgrade_plugin_savepoint(true, 2012053001, 'portfolio', 'picasa');
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
