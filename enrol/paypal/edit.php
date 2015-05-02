<?php

/**
 * Adds new instance of enrol_paypal to specified course
 * or edits current instance.
 *
 * @package    enrol_paypal
 * @copyright  2010 Petr Skoda  {@link http://skodak.org}
 * 
 */

require('../../config.php');
require_once('edit_form.php');

$courseid   = required_param('courseid', PARAM_INT);
$instanceid = optional_param('id', 0, PARAM_INT); // instanceid

$course = $DB->get_record('course', array('id'=>$courseid), '*', MUST_EXIST);
$context = context_course::instance($course->id, MUST_EXIST);

require_login($course);
require_capability('enrol/paypal:config', $context);

$PAGE->set_url('/enrol/paypal/edit.php', array('courseid'=>$course->id, 'id'=>$instanceid));
$PAGE->set_pagelayout('admin');

$return = new lion_url('/enrol/instances.php', array('id'=>$course->id));
if (!enrol_is_enabled('paypal')) {
    redirect($return);
}

$plugin = enrol_get_plugin('paypal');

if ($instanceid) {
    $instance = $DB->get_record('enrol', array('courseid'=>$course->id, 'enrol'=>'paypal', 'id'=>$instanceid), '*', MUST_EXIST);
    $instance->cost = format_float($instance->cost, 2, true);
} else {
    require_capability('lion/course:enrolconfig', $context);
    // no instance yet, we have to add new instance
    navigation_node::override_active_url(new lion_url('/enrol/instances.php', array('id'=>$course->id)));
    $instance = new stdClass();
    $instance->id       = null;
    $instance->courseid = $course->id;
}

$mform = new enrol_paypal_edit_form(NULL, array($instance, $plugin, $context));

if ($mform->is_cancelled()) {
    redirect($return);

} else if ($data = $mform->get_data()) {
    if ($instance->id) {
        $reset = ($instance->status != $data->status);

        $instance->status         = $data->status;
        $instance->name           = $data->name;
        $instance->cost           = unformat_float($data->cost);
        $instance->currency       = $data->currency;
        $instance->roleid         = $data->roleid;
        $instance->enrolperiod    = $data->enrolperiod;
        $instance->enrolstartdate = $data->enrolstartdate;
        $instance->enrolenddate   = $data->enrolenddate;
        $instance->timemodified   = time();
        $DB->update_record('enrol', $instance);

        if ($reset) {
            $context->mark_dirty();
        }

    } else {
        $fields = array('status'=>$data->status, 'name'=>$data->name, 'cost'=>unformat_float($data->cost), 'currency'=>$data->currency, 'roleid'=>$data->roleid,
                        'enrolperiod'=>$data->enrolperiod, 'enrolstartdate'=>$data->enrolstartdate, 'enrolenddate'=>$data->enrolenddate);
        $plugin->add_instance($course, $fields);
    }

    redirect($return);
}

$PAGE->set_heading($course->fullname);
$PAGE->set_title(get_string('pluginname', 'enrol_paypal'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'enrol_paypal'));
$mform->display();
echo $OUTPUT->footer();
