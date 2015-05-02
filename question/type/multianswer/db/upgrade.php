<?php

/**
 * Multi-answer question type upgrade code.
 *
 * @package    qtype
 * @subpackage multianswer
 * @copyright  1999 onwards Martin Dougiamas {@link http://lion.com}
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Upgrade code for the multi-answer question type.
 * @param int $oldversion the version we are upgrading from.
 */
function xmldb_qtype_multianswer_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    // Lion v2.2.0 release upgrade line
    // Put any upgrade step following this.

    // Lion v2.3.0 release upgrade line
    // Put any upgrade step following this.

    // Lion v2.4.0 release upgrade line
    // Put any upgrade step following this.

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
