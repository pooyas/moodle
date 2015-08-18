<?php


/**
 * @package    core
 * @subpackage calendar
 * @copyright  2015 Pooya Saeedi
*/



require_once('../config.php');
require_once($CFG->dirroot.'/calendar/lib.php');

require_sesskey();

$var = required_param('var', PARAM_ALPHA);
$return = clean_param(base64_decode(required_param('return', PARAM_RAW)), PARAM_LOCALURL);
$courseid = optional_param('id', -1, PARAM_INT);
if ($courseid != -1) {
    $return = new lion_url($return, array('course' => $courseid));
} else {
    $return = new lion_url($return);
}
$url = new lion_url('/calendar/set.php', array('return'=>base64_encode($return->out_as_local_url(false)), 'course' => $courseid, 'var'=>$var, 'sesskey'=>sesskey()));
$PAGE->set_url($url);
$PAGE->set_context(context_system::instance());

switch($var) {
    case 'showgroups':
        calendar_set_event_type_display(CALENDAR_EVENT_GROUP);
        break;
    case 'showcourses':
        calendar_set_event_type_display(CALENDAR_EVENT_COURSE);
        break;
    case 'showglobal':
        calendar_set_event_type_display(CALENDAR_EVENT_GLOBAL);
        break;
    case 'showuser':
        calendar_set_event_type_display(CALENDAR_EVENT_USER);
        break;
}

redirect($return);
