<?php

/**
 * Adds new instance of enrol_cohort to specified course.
 *
 * @package    enrol
 * @subpackage category
 * @copyright  2015 Pooya Saeedi
 * 
 */

require('../../config.php');
require_once("$CFG->dirroot/enrol/cohort/edit_form.php");
require_once("$CFG->dirroot/enrol/cohort/locallib.php");
require_once("$CFG->dirroot/group/lib.php");

$courseid = required_param('courseid', PARAM_INT);
$instanceid = optional_param('id', 0, PARAM_INT);
$message = optional_param('message', null, PARAM_TEXT);

$course = $DB->get_record('course', array('id'=>$courseid), '*', MUST_EXIST);
$context = context_course::instance($course->id, MUST_EXIST);

require_login($course);
require_capability('lion/course:enrolconfig', $context);
require_capability('enrol/cohort:config', $context);

$PAGE->set_url('/enrol/cohort/edit.php', array('courseid'=>$course->id, 'id'=>$instanceid));
$PAGE->set_pagelayout('admin');

$returnurl = new lion_url('/enrol/instances.php', array('id'=>$course->id));
if (!enrol_is_enabled('cohort')) {
    redirect($returnurl);
}

$enrol = enrol_get_plugin('cohort');

if ($instanceid) {
    $instance = $DB->get_record('enrol', array('courseid'=>$course->id, 'enrol'=>'cohort', 'id'=>$instanceid), '*', MUST_EXIST);

} else {
    // No instance yet, we have to add new instance.
    if (!$enrol->get_newinstance_link($course->id)) {
        redirect($returnurl);
    }
    navigation_node::override_active_url(new lion_url('/enrol/instances.php', array('id'=>$course->id)));
    $instance = new stdClass();
    $instance->id         = null;
    $instance->courseid   = $course->id;
    $instance->enrol      = 'cohort';
    $instance->customint1 = ''; // Cohort id.
    $instance->customint2 = 0;  // Optional group id.
}

// Try and make the manage instances node on the navigation active.
$courseadmin = $PAGE->settingsnav->get('courseadmin');
if ($courseadmin && $courseadmin->get('users') && $courseadmin->get('users')->get('manageinstances')) {
    $courseadmin->get('users')->get('manageinstances')->make_active();
}


$mform = new enrol_cohort_edit_form(null, array($instance, $enrol, $course));

if ($mform->is_cancelled()) {
    redirect($returnurl);

} else if ($data = $mform->get_data()) {
    if ($data->id) {
        // NOTE: no cohort changes here!!!
        if ($data->roleid != $instance->roleid) {
            // The sync script can only add roles, for perf reasons it does not modify them.
            role_unassign_all(array('contextid'=>$context->id, 'roleid'=>$instance->roleid, 'component'=>'enrol_cohort', 'itemid'=>$instance->id));
        }
        $instance->name         = $data->name;
        $instance->status       = $data->status;
        $instance->roleid       = $data->roleid;
        $instance->customint2   = $data->customint2;
        $instance->timemodified = time();
        $DB->update_record('enrol', $instance);
    }  else {
        $enrol->add_instance($course, array('name'=>$data->name, 'status'=>$data->status, 'customint1'=>$data->customint1, 'roleid'=>$data->roleid, 'customint2'=>$data->customint2));
        if (!empty($data->submitbuttonnext)) {
            $returnurl = new lion_url($PAGE->url);
            $returnurl->param('message', 'added');
        }
    }
    $trace = new null_progress_trace();
    enrol_cohort_sync($trace, $course->id);
    $trace->finished();
    redirect($returnurl);
}

$PAGE->set_heading($course->fullname);
$PAGE->set_title(get_string('pluginname', 'enrol_cohort'));

echo $OUTPUT->header();
if ($message === 'added') {
    echo $OUTPUT->notification(get_string('instanceadded', 'enrol'), 'notifysuccess');
}
$mform->display();
echo $OUTPUT->footer();
