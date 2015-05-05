<?php

/**
 * Shows a screen where the user can choose a question type, before being
 * redirected to question.php
 *
 * @package    core
 * @subpackage questionbank
 * @copyright  2015 Pooya Saeedi
 * 
 */


require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/editlib.php');

// Read URL parameters.
$categoryid = required_param('category', PARAM_INT);
$cmid = optional_param('cmid', 0, PARAM_INT);
$courseid = optional_param('courseid', 0, PARAM_INT);
$returnurl = optional_param('returnurl', 0, PARAM_LOCALURL);
$appendqnumstring = optional_param('appendqnumstring', '', PARAM_ALPHA);
$validationerror = optional_param('validationerror', false, PARAM_BOOL);

// Place to accumulate hidden params for the form we will print.
$hiddenparams = array('category' => $categoryid);

// Validate params.
if (!$category = $DB->get_record('question_categories', array('id' => $categoryid))) {
    print_error('categorydoesnotexist', 'question', $returnurl);
}

if ($cmid) {
    list($module, $cm) = get_module_from_cmid($cmid);
    require_login($cm->course, false, $cm);
    $thiscontext = context_module::instance($cmid);
    $hiddenparams['cmid'] = $cmid;
} else if ($courseid) {
    require_login($courseid, false);
    $thiscontext = context_course::instance($courseid);
    $module = null;
    $cm = null;
    $hiddenparams['courseid'] = $courseid;
} else {
    print_error('missingcourseorcmid', 'question');
}

// Check permissions.
$categorycontext = context::instance_by_id($category->contextid);
require_capability('lion/question:add', $categorycontext);

// Ensure other optional params get passed on to question.php.
if (!empty($returnurl)) {
    $hiddenparams['returnurl'] = $returnurl;
}
if (!empty($appendqnumstring)) {
    $hiddenparams['appendqnumstring'] = $appendqnumstring;
}

$PAGE->set_url('/question/addquestion.php', $hiddenparams);
if ($cmid) {
    $questionbankurl = new lion_url('/question/edit.php', array('cmid' => $cmid));
} else {
    $questionbankurl = new lion_url('/question/edit.php', array('courseid' => $courseid));
}
navigation_node::override_active_url($questionbankurl);

$chooseqtype = get_string('chooseqtypetoadd', 'question');
$PAGE->set_heading($COURSE->fullname);
$PAGE->navbar->add($chooseqtype);
$PAGE->set_title($chooseqtype);

// Display a form to choose the question type.
echo $OUTPUT->header();
echo $OUTPUT->notification(get_string('youmustselectaqtype', 'question'));
echo $OUTPUT->box_start('generalbox boxwidthnormal boxaligncenter', 'chooseqtypebox');
echo print_choose_qtype_to_add_form($hiddenparams, null, false);
echo $OUTPUT->box_end();
echo $OUTPUT->footer();
