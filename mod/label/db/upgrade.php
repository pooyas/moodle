<?php



/**
 * Label module upgrade
 *
 * @package    mod
 * @subpackage label
 * @copyright  2015 Pooya Saeedi
 */

// This file keeps track of upgrades to
// the label module
//
// Sometimes, changes between versions involve
// alterations to database structures and other
// major things that may break installations.
//
// The upgrade function in this file will attempt
// to perform all the necessary actions to upgrade
// your older installation to the current version.
//
// If there's something it cannot do itself, it
// will tell you what you need to do.
//
// The commands in here will all be database-neutral,
// using the methods of database_manager class
//
// Please do not forget to use upgrade_set_timeout()
// before any action that may take longer time to finish.

defined('LION_INTERNAL') || die;

function xmldb_label_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();


    // Lion v2.2.0 release upgrade line
    // Put any upgrade step following this

    // Lion v2.3.0 release upgrade line
    // Put any upgrade step following this


    // Lion v2.4.0 release upgrade line
    // Put any upgrade step following this

    if ($oldversion < 2013021400) {
        // find all courses that contain labels and reset their cache
        $modid = $DB->get_field_sql("SELECT id FROM {modules} WHERE name=?",
                array('label'));
        if ($modid) {
            $courses = $DB->get_fieldset_sql('SELECT DISTINCT course '.
                'FROM {course_modules} WHERE module=?', array($modid));
            foreach ($courses as $courseid) {
                rebuild_course_cache($courseid, true);
            }
        }

        // label savepoint reached
        upgrade_mod_savepoint(true, 2013021400, 'label');
    }

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


