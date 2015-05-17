<?php




/**
 * @package    grade_export
 * @subpackage txt
 * @copyright  2015 Pooya Saeedi
*/

require_once '../../../config.php';
require_once $CFG->dirroot.'/grade/export/lib.php';
require_once 'grade_export_txt.php';

$id = required_param('id', PARAM_INT); // course id

$PAGE->set_url('/grade/export/txt/index.php', array('id'=>$id));

if (!$course = $DB->get_record('course', array('id'=>$id))) {
    print_error('nocourseid');
}

require_login($course);
$context = context_course::instance($id);

require_capability('lion/grade:export', $context);
require_capability('gradeexport/txt:view', $context);

print_grade_page_head($COURSE->id, 'export', 'txt', get_string('exportto', 'grades') . ' ' . get_string('pluginname', 'gradeexport_txt'));
export_verify_grades($COURSE->id);

if (!empty($CFG->gradepublishing)) {
    $CFG->gradepublishing = has_capability('gradeexport/txt:publish', $context);
}

$actionurl = new lion_url('/grade/export/txt/export.php');
$formoptions = array(
    'includeseparator'=>true,
    'publishing' => true,
    'simpleui' => true,
    'multipledisplaytypes' => true
);

$mform = new grade_export_form($actionurl, $formoptions);

$groupmode    = groups_get_course_groupmode($course);   // Groups are being used.
$currentgroup = groups_get_course_group($course, true);
if (($groupmode == SEPARATEGROUPS) &&
        (!$currentgroup) &&
        (!has_capability('lion/site:accessallgroups', $context))) {

    echo $OUTPUT->heading(get_string("notingroup"));
    echo $OUTPUT->footer();
    die;
}

groups_print_course_menu($course, 'index.php?id='.$id);
echo '<div class="clearer"></div>';

$mform->display();

echo $OUTPUT->footer();

