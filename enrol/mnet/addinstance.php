<?php

/**
 * Adds new instance of enrol_mnet into the specified course
 *
 * @package    enrol_mnet
 * @copyright  2010 David Mudrak <david@lion.com>
 * 
 */

require(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once($CFG->dirroot.'/enrol/mnet/addinstance_form.php');
require_once($CFG->dirroot.'/mnet/service/enrol/locallib.php');

$id = required_param('id', PARAM_INT); // course id

$course = $DB->get_record('course', array('id'=>$id), '*', MUST_EXIST);
$context = context_course::instance($course->id, MUST_EXIST);

require_login($course);
require_capability('lion/course:enrolconfig', $context);

$PAGE->set_url('/enrol/mnet/addinstance.php', array('id'=>$course->id));
$PAGE->set_pagelayout('standard');

// Try and make the manage instances node on the navigation active
$courseadmin = $PAGE->settingsnav->get('courseadmin');
if ($courseadmin && $courseadmin->get('users') && $courseadmin->get('users')->get('manageinstances')) {
    $courseadmin->get('users')->get('manageinstances')->make_active();
}

$enrol = enrol_get_plugin('mnet');
// make sure we were allowed to get here form the Enrolment methods page
if (!$enrol->get_newinstance_link($course->id)) {
    redirect(new lion_url('/enrol/instances.php', array('id'=>$course->id)));
}
$service = mnetservice_enrol::get_instance();
$mform = new enrol_mnet_addinstance_form(null, array('course'=>$course, 'enrol'=>$enrol, 'service'=>$service));

if ($mform->is_cancelled()) {
    redirect(new lion_url('/enrol/instances.php', array('id'=>$course->id)));

} else if ($data = $mform->get_data()) {
    $enrol->add_instance($course, array('customint1'=>$data->hostid, 'roleid'=>$data->roleid, 'name'=>$data->name));
    redirect(new lion_url('/enrol/instances.php', array('id'=>$course->id)));
}

$PAGE->set_heading($course->fullname);
$PAGE->set_title(get_string('pluginname', 'enrol_mnet'));

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
