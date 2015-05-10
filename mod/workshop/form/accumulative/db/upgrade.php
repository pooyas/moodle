<?php


/**
 * Keeps track of upgrades to the workshop accumulative grading strategy
 *
 * @package    workshopform
 * @subpackage accumulative
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Performs upgrade of the database structure and data
 *
 * @param int $oldversion the version we are upgrading from
 * @return bool true
 */
function xmldb_workshopform_accumulative_upgrade($oldversion) {
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
