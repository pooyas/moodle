<?php


/**
 * A page for editing course grade settings
 *
 * @package    grade
 * @subpackage edit
 * @copyright  2015 Pooya Saeedi
 */

require_once '../../../config.php';
require_once $CFG->dirroot.'/grade/lib.php';
require_once $CFG->libdir.'/gradelib.php';
require_once 'form.php';

$courseid  = optional_param('id', SITEID, PARAM_INT);

$PAGE->set_url('/grade/edit/settings/index.php', array('id'=>$courseid));
$PAGE->set_pagelayout('admin');

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('nocourseid');
}
require_login($course);
$context = context_course::instance($course->id);

require_capability('lion/grade:manage', $context);

$gpr = new grade_plugin_return(array('type'=>'edit', 'plugin'=>'settings', 'courseid'=>$courseid));

$strgrades = get_string('grades');
$pagename  = get_string('coursesettings', 'grades');

$returnurl = $CFG->wwwroot.'/grade/index.php?id='.$course->id;

$mform = new course_settings_form();

$settings = grade_get_settings($course->id);

$mform->set_data($settings);

if ($mform->is_cancelled()) {
    redirect($returnurl);

} else if ($data = $mform->get_data()) {
    $data = (array)$data;
    $general = array('displaytype', 'decimalpoints', 'aggregationposition');
    foreach ($data as $key=>$value) {
        if (!in_array($key, $general) and strpos($key, 'report_') !== 0
                                      and strpos($key, 'import_') !== 0
                                      and strpos($key, 'export_') !== 0) {
            continue;
        }
        if ($value == -1) {
            $value = null;
        }
        grade_set_setting($course->id, $key, $value);
    }

    redirect($returnurl);
}

print_grade_page_head($courseid, 'settings', 'coursesettings', get_string('coursegradesettings', 'grades'));

echo $OUTPUT->box_start('generalbox boxaligncenter boxwidthnormal centerpara');
echo get_string('coursesettingsexplanation', 'grades');
echo $OUTPUT->box_end();

$mform->display();

echo $OUTPUT->footer();


