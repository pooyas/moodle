<?php

/**
 * Database enrolment plugin upgrade.
 *
 * @package    enrol
 * @subpackage database
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();
function xmldb_enrol_database_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();


    return true;
}
