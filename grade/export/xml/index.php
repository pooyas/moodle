<?php

/**
 * @package    gradeexport
 * @subpackage xml
 * @copyright  2015 Pooya Saeedi
 */

require_once '../../../config.php';
require_once $CFG->dirroot.'/grade/export/lib.php';
require_once 'grade_export_xml.php';

$id = required_param('id', PARAM_INT); // course id

$PAGE->set_url('/grade/export/xml/index.php', array('id'=>$id));

if (!$course = $DB->get_record('course', array('id'=>$id))) {
    print_error('nocourseid');
}

require_login($course);
$context = context_course::instance($id);

require_capability('lion/grade:export', $context);
require_capability('gradeexport/xml:view', $context);

print_grade_page_head($COURSE->id, 'export', 'xml', get_string('exportto', 'grades') . ' ' . get_string('pluginname', 'gradeexport_xml'));
export_verify_grades($COURSE->id);

if (!empty($CFG->gradepublishing)) {
    $CFG->gradepublishing = has_capability('gradeexport/xml:publish', $context);
}

$actionurl = new lion_url('/grade/export/xml/export.php');
// The option 'idnumberrequired' excludes grade items that dont have an ID to use during import.
$formoptions = array(
    'idnumberrequired' => true,
    'updategradesonly' => true,
    'publishing' => true,
    'simpleui' => true,
    'multipledisplaytypes' => false
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

