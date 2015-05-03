<?php

/**
 * Flatfile enrolment plugin installation.
 *
 * @package    enrol_flatfile
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

function xmldb_enrol_flatfile_install() {
    global $CFG, $DB;

    // Flatfile role mappings are empty by default now.
    $roles = get_all_roles();
    foreach ($roles as $role) {
        set_config('map_'.$role->id, $role->shortname, 'enrol_flatfile');
    }
}
