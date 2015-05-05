<?php

/**
 * This file keeps track of upgrades to the self enrolment plugin
 *
 * @package    enrol
 * @subpackage self
 * @copyright  2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die();

function xmldb_enrol_self_upgrade($oldversion) {
    global $CFG, $DB, $OUTPUT;

    $dbman = $DB->get_manager();


    if ($oldversion < 2012101400) {
        // Set default expiry threshold to 1 day.
        $DB->execute("UPDATE {enrol} SET expirythreshold = 86400 WHERE enrol = 'self' AND expirythreshold = 0");
        upgrade_plugin_savepoint(true, 2012101400, 'enrol', 'self');
    }

    if ($oldversion < 2012120600) {
        // Enable new self enrolments everywhere.
        $DB->execute("UPDATE {enrol} SET customint6 = 1 WHERE enrol = 'self'");
        upgrade_plugin_savepoint(true, 2012120600, 'enrol', 'self');
    }



    if ($oldversion < 2013112100) {
        // Set customint1 (group enrolment key) to 0 if it was not set (null).
        $DB->execute("UPDATE {enrol} SET customint1 = 0 WHERE enrol = 'self' AND customint1 IS NULL");
        upgrade_plugin_savepoint(true, 2013112100, 'enrol', 'self');
    }

    return true;
}


