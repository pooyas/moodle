<?php

/**
 * prints the form to confirm the deleting of a completed
 *
 * @package    mod
 * @subpackage feedback
 * @copyright  2015 Pooya Saeedi
 */

require_once("../../config.php");
require_once("lib.php");
require_once('delete_completed_form.php');

$id = required_param('id', PARAM_INT);
$completedid = optional_param('completedid', 0, PARAM_INT);
$return = optional_param('return', 'entries', PARAM_ALPHA);

if ($completedid == 0) {
    print_error('no_complete_to_delete',
                'feedback',
                'show_entries.php?id='.$id.'&do_show=showentries');
}

$PAGE->set_url('/mod/feedback/delete_completed.php', array('id'=>$id, 'completed'=>$completedid));

if (! $cm = get_coursemodule_from_id('feedback', $id)) {
    print_error('invalidcoursemodule');
}

if (! $course = $DB->get_record("course", array("id"=>$cm->course))) {
    print_error('coursemisconf');
}

if (! $feedback = $DB->get_record("feedback", array("id"=>$cm->instance))) {
    print_error('invalidcoursemodule');
}

$context = context_module::instance($cm->id);

require_login($course, true, $cm);

require_capability('mod/feedback:deletesubmissions', $context);

$mform = new mod_feedback_delete_completed_form();
$newformdata = array('id'=>$id,
                    'completedid'=>$completedid,
                    'confirmdelete'=>'1',
                    'do_show'=>'edit',
                    'return'=>$return);
$mform->set_data($newformdata);
$formdata = $mform->get_data();

if ($mform->is_cancelled()) {
    if ($return == 'entriesanonym') {
        redirect('show_entries_anonym.php?id='.$id);
    } else {
        redirect('show_entries.php?id='.$id.'&do_show=showentries');
    }
}

if (isset($formdata->confirmdelete) AND $formdata->confirmdelete == 1) {
    if ($completed = $DB->get_record('feedback_completed', array('id'=>$completedid))) {
        feedback_delete_completed($completedid);
        if ($return == 'entriesanonym') {
            redirect('show_entries_anonym.php?id='.$id);
        } else {
            redirect('show_entries.php?id='.$id.'&do_show=showentries');
        }
    }
}

/// Print the page header
$strfeedbacks = get_string("modulenameplural", "feedback");
$strfeedback  = get_string("modulename", "feedback");

$PAGE->navbar->add(get_string('delete_entry', 'feedback'));
$PAGE->set_heading($course->fullname);
$PAGE->set_title($feedback->name);
echo $OUTPUT->header();

/// Print the main part of the page
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
echo $OUTPUT->heading(format_string($feedback->name));
echo $OUTPUT->box_start('generalbox errorboxcontent boxaligncenter boxwidthnormal');
echo html_writer::tag('p', get_string('confirmdeleteentry', 'feedback'), array('class' => 'bold'));
$mform->display();
echo $OUTPUT->box_end();


echo $OUTPUT->footer();
