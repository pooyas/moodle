<?php


/**
 * Post-install script for the quiz responses report.
 * @package    mod
 * @subpackage quiz
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();


/**
 * Post-install script
 */
function xmldb_quiz_responses_install() {
    global $DB;

    $record = new stdClass();
    $record->name         = 'responses';
    $record->displayorder = '9000';

    $DB->insert_record('quiz_reports', $record);
}
