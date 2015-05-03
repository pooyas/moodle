<?php

/**
 * Keeps track of upgrades to the auth_mnet plugin
 *
 * @package    auth
 * @subpackage mnet
 * @copyright  2015 Pooya Saeedi 
 * 
 */

/**
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_auth_mnet_upgrade($oldversion) {
    global $CFG, $DB, $OUTPUT;

    $dbman = $DB->get_manager();



    return true;
}
