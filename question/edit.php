<?php

/**
 * Page to edit the question bank
 *
 * @package    lioncore
 * @subpackage questionbank
 * @copyright  1999 onwards Martin Dougiamas {@link http://lion.com}
 * 
 */


require_once(dirname(__FILE__) . '/../config.php');
require_once($CFG->dirroot . '/question/editlib.php');

list($thispageurl, $contexts, $cmid, $cm, $module, $pagevars) =
        question_edit_setup('questions', '/question/edit.php');

$url = new lion_url($thispageurl);
if (($lastchanged = optional_param('lastchanged', 0, PARAM_INT)) !== 0) {
    $url->param('lastchanged', $lastchanged);
}
$PAGE->set_url($url);

$questionbank = new core_question\bank\view($contexts, $thispageurl, $COURSE, $cm);
$questionbank->process_actions();

// TODO log this page view.

$context = $contexts->lowest();
$streditingquestions = get_string('editquestions', 'question');
$PAGE->set_title($streditingquestions);
$PAGE->set_heading($COURSE->fullname);
echo $OUTPUT->header();

echo '<div class="questionbankwindow boxwidthwide boxaligncenter">';
$questionbank->display('questions', $pagevars['qpage'], $pagevars['qperpage'],
        $pagevars['cat'], $pagevars['recurse'], $pagevars['showhidden'],
        $pagevars['qbshowtext']);
echo "</div>\n";

echo $OUTPUT->footer();
