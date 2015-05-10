<?php


/**
 * Aggregates the grades for submission and grades for assessments
 *
 * @package    mod
 * @subpackage workshop
 * @copyright  2015 Pooya Saeedi
 * 
 */

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/locallib.php');

$cmid       = required_param('cmid', PARAM_INT);            // course module
$confirm    = optional_param('confirm', false, PARAM_BOOL); // confirmation

// the params to be re-passed to view.php
$page       = optional_param('page', 0, PARAM_INT);
$sortby     = optional_param('sortby', 'lastname', PARAM_ALPHA);
$sorthow    = optional_param('sorthow', 'ASC', PARAM_ALPHA);

$cm         = get_coursemodule_from_id('workshop', $cmid, 0, false, MUST_EXIST);
$course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$workshop   = $DB->get_record('workshop', array('id' => $cm->instance), '*', MUST_EXIST);
$workshop   = new workshop($workshop, $cm, $course);

$PAGE->set_url($workshop->aggregate_url(), compact('confirm', 'page', 'sortby', 'sorthow'));

require_login($course, false, $cm);
require_capability('mod/workshop:overridegrades', $PAGE->context);

// load and init the grading evaluator
$evaluator = $workshop->grading_evaluation_instance();
$settingsform = $evaluator->get_settings_form($PAGE->url);

if ($settingsdata = $settingsform->get_data()) {
    $workshop->aggregate_submission_grades();           // updates 'grade' in {workshop_submissions}
    $evaluator->update_grading_grades($settingsdata);   // updates 'gradinggrade' in {workshop_assessments}
    $workshop->aggregate_grading_grades();              // updates 'gradinggrade' in {workshop_aggregations}
}

redirect(new lion_url($workshop->view_url(), compact('page', 'sortby', 'sorthow')));
