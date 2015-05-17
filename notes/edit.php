<?php



/**
 * @package    core
 * @subpackage notes
 * @copyright  2015 Pooya Saeedi
*/

require_once('../config.php');
require_once('lib.php');
require_once('edit_form.php');

$noteid = optional_param('id', 0, PARAM_INT);

$url = new lion_url('/notes/edit.php');

if ($noteid) {
    // Existing note.
    $url->param('id', $noteid);
    if (!$note = note_load($noteid)) {
        print_error('invalidid', 'notes');
    }

} else {
    // Adding new note.
    $courseid = required_param('courseid', PARAM_INT);
    $userid   = required_param('userid', PARAM_INT);
    $state    = optional_param('publishstate', NOTES_STATE_PUBLIC, PARAM_ALPHA);

    $note = new stdClass();
    $note->courseid     = $courseid;
    $note->userid       = $userid;
    $note->publishstate = $state;

    $url->param('courseid', $courseid);
    $url->param('userid', $userid);
    if ($state !== NOTES_STATE_PUBLIC) {
        $url->param('publishstate', $state);
    }
}

$PAGE->set_url($url);

if (!$course = $DB->get_record('course', array('id' => $note->courseid))) {
    print_error('invalidcourseid');
}

require_login($course);

if (empty($CFG->enablenotes)) {
    print_error('notesdisabled', 'notes');
}

$context = context_course::instance($course->id);
require_capability('lion/notes:manage', $context);

if (!$user = $DB->get_record('user', array('id' => $note->userid))) {
    print_error('invaliduserid');
}

$noteform = new note_edit_form();
$noteform->set_data($note);

// If form was cancelled then return to the notes list of the note.
if ($noteform->is_cancelled()) {
    redirect($CFG->wwwroot . '/notes/index.php?course=' . $note->courseid . '&amp;user=' . $note->userid);
}

// If data was submitted and validated, then save it to database.
if ($note = $noteform->get_data()) {
    if ($noteid) {
        // A noteid has been used, we don't allow editing of course or user so
        // lets unset them to be sure we never change that by accident.
        unset($note->courseid);
        unset($note->userid);
    }
    note_save($note);
    // Redirect to notes list that contains this note.
    redirect($CFG->wwwroot . '/notes/index.php?course=' . $note->courseid . '&amp;user=' . $note->userid);
}

if ($noteid) {
    $strnotes = get_string('editnote', 'notes');
} else {
    $strnotes = get_string('addnewnote', 'notes');
}

// Output HTML.
$link = null;
if (has_capability('lion/course:viewparticipants', $context)
    || has_capability('lion/site:viewparticipants', context_system::instance())) {

    $link = new lion_url('/user/index.php', array('id' => $course->id));
}
$PAGE->navbar->add(get_string('participants'), $link);
$PAGE->navbar->add(fullname($user), new lion_url('/user/view.php', array('id' => $user->id, 'course' => $course->id)));
$PAGE->navbar->add(get_string('notes', 'notes'),
                   new lion_url('/notes/index.php', array('user' => $user->id, 'course' => $course->id)));
$PAGE->navbar->add($strnotes);
$PAGE->set_title($course->shortname . ': ' . $strnotes);
$PAGE->set_heading($course->fullname);

echo $OUTPUT->header();
echo $OUTPUT->heading(fullname($user));

$noteform->display();
echo $OUTPUT->footer();
