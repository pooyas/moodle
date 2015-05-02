<?php

/**
 * Post-install script for the quiz grades report.
 * @package   quiz_overview
 * @copyright 2013 Tim Hunt
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Post-install script
 */
function xmldb_quiz_overview_install() {
    global $DB;

    $record = new stdClass();
    $record->name         = 'overview';
    $record->displayorder = '10000';

    $DB->insert_record('quiz_reports', $record);
}
