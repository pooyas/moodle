<?php

/**
 * deletes an item of the feedback
 *
 * @package    mod
 * @subpackage feedback
 * @copyright  2015 Pooya Saeedi
 */

require_once("../../config.php");
require_once("lib.php");
require_once('delete_item_form.php');

$id = required_param('id', PARAM_INT);
$deleteitem = required_param('deleteitem', PARAM_INT);

$PAGE->set_url('/mod/feedback/delete_item.php', array('id'=>$id, 'deleteitem'=>$deleteitem));

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

require_capability('mod/feedback:edititems', $context);

$mform = new mod_feedback_delete_item_form();
$newformdata = array('id'=>$id,
                    'deleteitem'=>$deleteitem,
                    'confirmdelete'=>'1');
$mform->set_data($newformdata);
$formdata = $mform->get_data();

if ($mform->is_cancelled()) {
    redirect('edit.php?id='.$id);
}

if (isset($formdata->confirmdelete) AND $formdata->confirmdelete == 1) {
    feedback_delete_item($formdata->deleteitem);
    redirect('edit.php?id=' . $id);
}


/// Print the page header
$strfeedbacks = get_string("modulenameplural", "feedback");
$strfeedback  = get_string("modulename", "feedback");

$PAGE->navbar->add(get_string('delete_item', 'feedback'));
$PAGE->set_heading($course->fullname);
$PAGE->set_title($feedback->name);
echo $OUTPUT->header();

/// Print the main part of the page
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
echo $OUTPUT->heading(format_string($feedback->name));
echo $OUTPUT->box_start('generalbox errorboxcontent boxaligncenter boxwidthnormal');
echo html_writer::tag('p', get_string('confirmdeleteitem', 'feedback'), array('class' => 'bold'));
print_string('relateditemsdeleted', 'feedback');
$mform->display();
echo $OUTPUT->box_end();

echo $OUTPUT->footer();


