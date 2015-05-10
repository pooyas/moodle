<?php

/**
 * Functions common to the question usage statistics code.
 *
 * @package    core
 * @subpackage questionbank
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Question statistics cron code. Deletes cached stats more than a certain age.
 */
function question_usage_statistics_cron() {
    global $DB;

    $expiretime = time() - 5 * HOURSECS;

    mtrace("\n  Cleaning up old question statistics cache records...", '');

    $DB->delete_records_select('question_statistics', 'timemodified < ?', array($expiretime));
    $responseanlysisids = $DB->get_records_select_menu('question_response_analysis',
                                                           'timemodified < ?',
                                                           array($expiretime),
                                                           'id',
                                                           'id, id AS id2');

    $DB->delete_records_list('question_response_analysis', 'id', $responseanlysisids);
    $DB->delete_records_list('question_response_count', 'analysisid', $responseanlysisids);

    mtrace('done.');
    return true;
}
