<?php

/**
 * This file keeps track of upgrades to plugin gradingform_rubric
 *
 * @package    gradingform
 * @subpackage rubric
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Keeps track or rubric plugin upgrade path
 *
 * @param int $oldversion the DB version of currently installed plugin
 * @return bool true
 */
function xmldb_gradingform_rubric_upgrade($oldversion) {
    global $CFG, $DB, $OUTPUT;

    $dbman = $DB->get_manager();

    // Lion v2.2.0 release upgrade line
    // Put any upgrade step following this

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
