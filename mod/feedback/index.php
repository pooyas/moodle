<?php


/**
 * prints the overview of all feedbacks included into the current course
 *
 * @package    mod
 * @subpackage feedback
 * @copyright  2015 Pooya Saeedi
 */

require_once("../../config.php");
require_once("lib.php");

$id = required_param('id', PARAM_INT);

$url = new lion_url('/mod/feedback/index.php', array('id'=>$id));

$PAGE->set_url($url);

if (!$course = $DB->get_record('course', array('id'=>$id))) {
    print_error('invalidcourseid');
}

$context = context_course::instance($course->id);

require_login($course);
$PAGE->set_pagelayout('incourse');

// Trigger instances list viewed event.
$event = \mod_feedback\event\course_module_instance_list_viewed::create(array('context' => $context));
$event->add_record_snapshot('course', $course);
$event->trigger();

/// Print the page header
$strfeedbacks = get_string("modulenameplural", "feedback");
$strfeedback  = get_string("modulename", "feedback");

$PAGE->navbar->add($strfeedbacks);
$PAGE->set_heading($course->fullname);
$PAGE->set_title(get_string('modulename', 'feedback').' '.get_string('activities'));
echo $OUTPUT->header();
echo $OUTPUT->heading($strfeedbacks);

/// Get all the appropriate data

if (! $feedbacks = get_all_instances_in_course("feedback", $course)) {
    $url = new lion_url('/course/view.php', array('id'=>$course->id));
    notice(get_string('thereareno', 'lion', $strfeedbacks), $url);
    die;
}

$usesections = course_format_uses_sections($course->format);

/// Print the list of instances (your module will probably extend this)

$timenow = time();
$strname  = get_string("name");
$strresponses = get_string('responses', 'feedback');

$table = new html_table();

if ($usesections) {
    $strsectionname = get_string('sectionname', 'format_'.$course->format);
    if (has_capability('mod/feedback:viewreports', $context)) {
        $table->head  = array ($strsectionname, $strname, $strresponses);
        $table->align = array ("center", "left", 'center');
    } else {
        $table->head  = array ($strsectionname, $strname);
        $table->align = array ("center", "left");
    }
} else {
    if (has_capability('mod/feedback:viewreports', $context)) {
        $table->head  = array ($strname, $strresponses);
        $table->align = array ("left", "center");
    } else {
        $table->head  = array ($strname);
        $table->align = array ("left");
    }
}


foreach ($feedbacks as $feedback) {
    //get the responses of each feedback
    $viewurl = new lion_url('/mod/feedback/view.php', array('id'=>$feedback->coursemodule));

    if (has_capability('mod/feedback:viewreports', $context)) {
        $completed_feedback_count = intval(feedback_get_completeds_group_count($feedback));
    }

    $dimmedclass = $feedback->visible ? '' : 'class="dimmed"';
    $link = '<a '.$dimmedclass.' href="'.$viewurl->out().'">'.$feedback->name.'</a>';

    if ($usesections) {
        $tabledata = array (get_section_name($course, $feedback->section), $link);
    } else {
        $tabledata = array ($link);
    }
    if (has_capability('mod/feedback:viewreports', $context)) {
        $tabledata[] = $completed_feedback_count;
    }

    $table->data[] = $tabledata;

}

echo "<br />";

echo html_writer::table($table);

/// Finish the page

echo $OUTPUT->footer();

