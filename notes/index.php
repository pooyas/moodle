<?php


/**
 * file index.php
 * index page to view notes.
 * if a course id is specified then the entries from that course are shown
 * if a user id is specified only notes related to that user are shown
 * @package    core
 * @subpackage notes
 * @copyright  2015 Pooya Saeedi
 */
require_once('../config.php');
require_once('lib.php');

$courseid     = optional_param('course', SITEID, PARAM_INT);
$userid       = optional_param('user', 0, PARAM_INT);
$filtertype   = optional_param('filtertype', '', PARAM_ALPHA);
$filterselect = optional_param('filterselect', 0, PARAM_INT);

if (empty($CFG->enablenotes)) {
    print_error('notesdisabled', 'notes');
}

$url = new lion_url('/notes/index.php');
if ($courseid != SITEID) {
    $url->param('course', $courseid);
}
if ($userid !== 0) {
    $url->param('user', $userid);
}
$PAGE->set_url($url);

// Tabs compatibility.
switch($filtertype) {
    case 'course':
        $courseid = $filterselect;
        break;
    case 'site':
        $courseid = SITEID;
        break;
}

if (empty($courseid)) {
    $courseid = SITEID;
}

$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

if ($userid) {
    $user = $DB->get_record('user', array('id' => $userid), '*', MUST_EXIST);
    $filtertype = 'user';
    $filterselect = $user->id;

    if ($user->deleted) {
        echo $OUTPUT->header();
        echo $OUTPUT->heading(get_string('userdeleted'));
        echo $OUTPUT->footer();
        die;
    }

} else {
    $filtertype = 'course';
    $filterselect = $course->id;
}

require_login($course);

// Output HTML.
if ($course->id == SITEID) {
    $coursecontext = context_system::instance();
} else {
    $coursecontext = context_course::instance($course->id);
}

require_capability('lion/notes:view', $coursecontext);
$systemcontext = context_system::instance();

// Trigger event.
$event = \core\event\notes_viewed::create(array(
    'relateduserid' => $userid,
    'context' => $coursecontext
));
$event->trigger();

$strnotes = get_string('notes', 'notes');
if ($userid) {
    $PAGE->set_context(context_user::instance($user->id));
    $PAGE->navigation->extend_for_user($user);
} else {
    $link = null;
    if (has_capability('lion/course:viewparticipants', $coursecontext)
        || has_capability('lion/site:viewparticipants', $systemcontext)) {

        $link = new lion_url('/user/index.php', array('id' => $course->id));
    }
}

$PAGE->set_pagelayout('incourse');
$PAGE->set_title($course->shortname . ': ' . $strnotes);
$PAGE->set_heading($course->fullname);

echo $OUTPUT->header();
if ($userid) {
    echo $OUTPUT->heading(fullname($user).': '.$strnotes);
} else {
    echo $OUTPUT->heading(format_string($course->shortname, true, array('context' => $coursecontext)).': '.$strnotes);
}

$strsitenotes = get_string('sitenotes', 'notes');
$strcoursenotes = get_string('coursenotes', 'notes');
$strpersonalnotes = get_string('personalnotes', 'notes');
$straddnewnote = get_string('addnewnote', 'notes');

echo $OUTPUT->box_start();

if ($courseid != SITEID) {
    $context = context_course::instance($courseid);
    $addid = has_capability('lion/notes:manage', $context) ? $courseid : 0;
    $view = has_capability('lion/notes:view', $context);
    $fullname = format_string($course->fullname, true, array('context' => $context));
    note_print_notes(
        '<a name="sitenotes"></a>' . $strsitenotes,
        $addid,
        $view,
        0,
        $userid,
        NOTES_STATE_SITE,
        0
    );
    note_print_notes(
        '<a name="coursenotes"></a>' . $strcoursenotes. ' ('.$fullname.')',
        $addid,
        $view,
        $courseid,
        $userid,
        NOTES_STATE_PUBLIC,
        0
    );
    note_print_notes(
        '<a name="personalnotes"></a>' . $strpersonalnotes,
        $addid,
        $view,
        $courseid,
        $userid,
        NOTES_STATE_DRAFT,
        $USER->id
    );

} else {  // Normal course.
    $view = has_capability('lion/notes:view', context_system::instance());
    note_print_notes('<a name="sitenotes"></a>' . $strsitenotes, 0, $view, 0, $userid, NOTES_STATE_SITE, 0);
    echo '<a name="coursenotes"></a>';

    if (!empty($userid)) {
        $courses = enrol_get_users_courses($userid);
        foreach ($courses as $c) {
            $ccontext = context_course::instance($c->id);
            $cfullname = format_string($c->fullname, true, array('context' => $ccontext));
            $header = '<a href="' . $CFG->wwwroot . '/course/view.php?id=' . $c->id . '">' . $cfullname . '</a>';
            if (has_capability('lion/notes:manage', context_course::instance($c->id))) {
                $addid = $c->id;
            } else {
                $addid = 0;
            }
            note_print_notes($header, $addid, $view, $c->id, $userid, NOTES_STATE_PUBLIC, 0);
        }
    }
}

echo $OUTPUT->box_end();

echo $OUTPUT->footer();
