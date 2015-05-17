<?php



/**
 * The purpose of this feature is to quickly remove all user related data from a course
 * in order to make it available for a new semester.  This feature can handle the removal
 * of general course data like students, teachers, logs, events and groups as well as module
 * specific data.  Each module must be modified to take advantage of this new feature.
 * The feature will also reset the start date of the course if necessary.
 *
 * @package    core
 * @subpackage course
 * @copyright  2015 Pooya Saeedi
 */

require('../config.php');
require_once('reset_form.php');

$id = required_param('id', PARAM_INT);

if (!$course = $DB->get_record('course', array('id'=>$id))) {
    print_error("invalidcourseid");
}

$PAGE->set_url('/course/reset.php', array('id'=>$id));
$PAGE->set_pagelayout('admin');

require_login($course);
require_capability('lion/course:reset', context_course::instance($course->id));

$strreset       = get_string('reset');
$strresetcourse = get_string('resetcourse');
$strremove      = get_string('remove');

$PAGE->navbar->add($strresetcourse);
$PAGE->set_title($course->fullname.': '.$strresetcourse);
$PAGE->set_heading($course->fullname.': '.$strresetcourse);

$mform = new course_reset_form();

if ($mform->is_cancelled()) {
    redirect($CFG->wwwroot.'/course/view.php?id='.$id);

} else if ($data = $mform->get_data()) { // no magic quotes

    if (isset($data->selectdefault)) {
        $_POST = array();
        $mform = new course_reset_form();
        $mform->load_defaults();

    } else if (isset($data->deselectall)) {
        $_POST = array();
        $mform = new course_reset_form();

    } else {
        echo $OUTPUT->header();
        echo $OUTPUT->heading($strresetcourse);

        $data->reset_start_date_old = $course->startdate;
        $status = reset_course_userdata($data);

        $data = array();
        foreach ($status as $item) {
            $line = array();
            $line[] = $item['component'];
            $line[] = $item['item'];
            $line[] = ($item['error']===false) ? get_string('ok') : '<div class="notifyproblem">'.$item['error'].'</div>';
            $data[] = $line;
        }

        $table = new html_table();
        $table->head  = array(get_string('resetcomponent'), get_string('resettask'), get_string('resetstatus'));
        $table->size  = array('20%', '40%', '40%');
        $table->align = array('left', 'left', 'left');
        $table->width = '80%';
        $table->data  = $data;
        echo html_writer::table($table);

        echo $OUTPUT->continue_button('view.php?id='.$course->id);  // Back to course page
        echo $OUTPUT->footer();
        exit;
    }
}

echo $OUTPUT->header();
echo $OUTPUT->heading($strresetcourse);

echo $OUTPUT->box(get_string('resetinfo'));

$mform->display();
echo $OUTPUT->footer();


