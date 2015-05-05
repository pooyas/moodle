<?php

/**
 * This file keeps track of upgrades to the manual enrolment plugin
 *
 * @package    enrol
 * @subpackage manual
 * @copyright  2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die();

function xmldb_enrol_manual_upgrade($oldversion) {
    global $CFG, $DB, $OUTPUT;

    $dbman = $DB->get_manager();

    if ($oldversion < 2012100702) {
        // Set default expiry threshold to 1 day.
        $DB->execute("UPDATE {enrol} SET expirythreshold = 86400 WHERE enrol = 'manual' AND expirythreshold = 0");
        upgrade_plugin_savepoint(true, 2012100702, 'enrol', 'manual');
    }

    if ($oldversion < 2012101400) {
        // Delete obsoleted settings, now using expiry* prefix to make them more consistent.
        unset_config('notifylast', 'enrol_manual');
        unset_config('notifyhour', 'enrol_manual');
        upgrade_plugin_savepoint(true, 2012101400, 'enrol', 'manual');
    }


    return true;
}


