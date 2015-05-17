<?php


/**
 * Adds new instance of enrol_manual to specified course
 * or edits current instance.
 *
 * @package    enrol
 * @subpackage manual
 * @copyright  2015 Pooya Saeedi
 */

require('../../config.php');
require_once('edit_form.php');

$courseid = required_param('courseid', PARAM_INT);

$course = $DB->get_record('course', array('id'=>$courseid), '*', MUST_EXIST);
$context = context_course::instance($course->id, MUST_EXIST);

require_login($course);
require_capability('enrol/manual:config', $context);

$PAGE->set_url('/enrol/manual/edit.php', array('courseid'=>$course->id));
$PAGE->set_pagelayout('admin');

$return = new lion_url('/enrol/instances.php', array('id'=>$course->id));
if (!enrol_is_enabled('manual')) {
    redirect($return);
}

$plugin = enrol_get_plugin('manual');

if ($instances = $DB->get_records('enrol', array('courseid'=>$course->id, 'enrol'=>'manual'), 'id ASC')) {
    $instance = array_shift($instances);
    if ($instances) {
        // Oh - we allow only one instance per course!!
        foreach ($instances as $del) {
            $plugin->delete_instance($del);
        }
    }
    // Merge these two settings to one value for the single selection element.
    if ($instance->notifyall and $instance->expirynotify) {
        $instance->expirynotify = 2;
    }
    unset($instance->notifyall);

} else {
    require_capability('lion/course:enrolconfig', $context);
    // No instance yet, we have to add new instance.
    navigation_node::override_active_url(new lion_url('/enrol/instances.php', array('id'=>$course->id)));
    $instance = new stdClass();
    $instance->id              = null;
    $instance->courseid        = $course->id;
    $instance->expirynotify    = $plugin->get_config('expirynotify');
    $instance->expirythreshold = $plugin->get_config('expirythreshold');
}

$mform = new enrol_manual_edit_form(null, array($instance, $plugin, $context));

if ($mform->is_cancelled()) {
    redirect($return);

} else if ($data = $mform->get_data()) {
    if ($data->expirynotify == 2) {
        $data->expirynotify = 1;
        $data->notifyall = 1;
    } else {
        $data->notifyall = 0;
    }
    if (!$data->expirynotify) {
        // Keep previous/default value of disabled expirythreshold option.
        $data->expirythreshold = $instance->expirythreshold;
    }
    if ($instance->id) {
        $instance->roleid          = $data->roleid;
        $instance->enrolperiod     = $data->enrolperiod;
        $instance->expirynotify    = $data->expirynotify;
        $instance->notifyall       = $data->notifyall;
        $instance->expirythreshold = $data->expirythreshold;
        $instance->timemodified    = time();

        $DB->update_record('enrol', $instance);

        // Use standard API to update instance status.
        if ($instance->status != $data->status) {
            $instance = $DB->get_record('enrol', array('id'=>$instance->id));
            $plugin->update_status($instance, $data->status);
            $context->mark_dirty();
        }

    } else {
        $fields = array(
            'status'          => $data->status,
            'roleid'          => $data->roleid,
            'enrolperiod'     => $data->enrolperiod,
            'expirynotify'    => $data->expirynotify,
            'notifyall'       => $data->notifyall,
            'expirythreshold' => $data->expirythreshold);
        $plugin->add_instance($course, $fields);
    }

    redirect($return);
}

$PAGE->set_title(get_string('pluginname', 'enrol_manual'));
$PAGE->set_heading($course->fullname);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'enrol_manual'));
$mform->display();
echo $OUTPUT->footer();
