<?php

/**
 * Manual authentication plugin upgrade code
 *
 * @package    auth
 * @subpackage manual
 * @copyright  2015 Pooya Saeedi 
 * 
 */

/**
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_auth_manual_upgrade($oldversion) {
    global $CFG, $DB, $OUTPUT;

    $dbman = $DB->get_manager();


    return true;
}
