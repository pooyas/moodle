<?php


/**
 * List of all resources in course
 *
 * @package    mod
 * @subpackage resource
 * @copyright  2015 Pooya Saeedi
 * 
 */

require('../../config.php');

$id = required_param('id', PARAM_INT); // course id

$course = $DB->get_record('course', array('id'=>$id), '*', MUST_EXIST);

require_course_login($course, true);
$PAGE->set_pagelayout('incourse');

$params = array(
    'context' => context_course::instance($course->id)
);
$event = \mod_resource\event\course_module_instance_list_viewed::create($params);
$event->add_record_snapshot('course', $course);
$event->trigger();

$strresource     = get_string('modulename', 'resource');
$strresources    = get_string('modulenameplural', 'resource');
$strsectionname  = get_string('sectionname', 'format_'.$course->format);
$strname         = get_string('name');
$strintro        = get_string('moduleintro');
$strlastmodified = get_string('lastmodified');

$PAGE->set_url('/mod/resource/index.php', array('id' => $course->id));
$PAGE->set_title($course->shortname.': '.$strresources);
$PAGE->set_heading($course->fullname);
$PAGE->navbar->add($strresources);
echo $OUTPUT->header();
echo $OUTPUT->heading($strresources);

if (!$resources = get_all_instances_in_course('resource', $course)) {
    notice(get_string('thereareno', 'lion', $strresources), "$CFG->wwwroot/course/view.php?id=$course->id");
    exit;
}

$usesections = course_format_uses_sections($course->format);

$table = new html_table();
$table->attributes['class'] = 'generaltable mod_index';

if ($usesections) {
    $table->head  = array ($strsectionname, $strname, $strintro);
    $table->align = array ('center', 'left', 'left');
} else {
    $table->head  = array ($strlastmodified, $strname, $strintro);
    $table->align = array ('left', 'left', 'left');
}

$modinfo = get_fast_modinfo($course);
$currentsection = '';
foreach ($resources as $resource) {
    $cm = $modinfo->cms[$resource->coursemodule];
    if ($usesections) {
        $printsection = '';
        if ($resource->section !== $currentsection) {
            if ($resource->section) {
                $printsection = get_section_name($course, $resource->section);
            }
            if ($currentsection !== '') {
                $table->data[] = 'hr';
            }
            $currentsection = $resource->section;
        }
    } else {
        $printsection = '<span class="smallinfo">'.userdate($resource->timemodified)."</span>";
    }

    $extra = empty($cm->extra) ? '' : $cm->extra;
    $icon = '';
    if (!empty($cm->icon)) {
        // each resource file has an icon in 2.0
        $icon = '<img src="'.$OUTPUT->pix_url($cm->icon).'" class="activityicon" alt="'.get_string('modulename', $cm->modname).'" /> ';
    }

    $class = $resource->visible ? '' : 'class="dimmed"'; // hidden modules are dimmed
    $table->data[] = array (
        $printsection,
        "<a $class $extra href=\"view.php?id=$cm->id\">".$icon.format_string($resource->name)."</a>",
        format_module_intro('resource', $resource, $cm->id));
}

echo html_writer::table($table);

echo $OUTPUT->footer();
