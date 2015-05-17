<?php


/**
 * Post-install script for the quiz manual grading report.
 * @package    mod
 * @subpackage quiz
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();


/**
 * Post-install script
 */
function xmldb_quiz_grading_install() {
    global $DB;

    $record = new stdClass();
    $record->name         = 'grading';
    $record->displayorder = '6000';
    $record->capability   = 'mod/quiz:grade';

    $DB->insert_record('quiz_reports', $record);
}
