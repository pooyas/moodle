<?php


/**
 * List of urls in course
 *
 * @package    mod
 * @subpackage survey
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
$event = \mod_url\event\course_module_instance_list_viewed::create($params);
$event->add_record_snapshot('course', $course);
$event->trigger();

$strurl       = get_string('modulename', 'url');
$strurls      = get_string('modulenameplural', 'url');
$strname         = get_string('name');
$strintro        = get_string('moduleintro');
$strlastmodified = get_string('lastmodified');

$PAGE->set_url('/mod/url/index.php', array('id' => $course->id));
$PAGE->set_title($course->shortname.': '.$strurls);
$PAGE->set_heading($course->fullname);
$PAGE->navbar->add($strurls);
echo $OUTPUT->header();
echo $OUTPUT->heading($strurls);

if (!$urls = get_all_instances_in_course('url', $course)) {
    notice(get_string('thereareno', 'lion', $strurls), "$CFG->wwwroot/course/view.php?id=$course->id");
    exit;
}

$usesections = course_format_uses_sections($course->format);

$table = new html_table();
$table->attributes['class'] = 'generaltable mod_index';

if ($usesections) {
    $strsectionname = get_string('sectionname', 'format_'.$course->format);
    $table->head  = array ($strsectionname, $strname, $strintro);
    $table->align = array ('center', 'left', 'left');
} else {
    $table->head  = array ($strlastmodified, $strname, $strintro);
    $table->align = array ('left', 'left', 'left');
}

$modinfo = get_fast_modinfo($course);
$currentsection = '';
foreach ($urls as $url) {
    $cm = $modinfo->cms[$url->coursemodule];
    if ($usesections) {
        $printsection = '';
        if ($url->section !== $currentsection) {
            if ($url->section) {
                $printsection = get_section_name($course, $url->section);
            }
            if ($currentsection !== '') {
                $table->data[] = 'hr';
            }
            $currentsection = $url->section;
        }
    } else {
        $printsection = '<span class="smallinfo">'.userdate($url->timemodified)."</span>";
    }

    $extra = empty($cm->extra) ? '' : $cm->extra;
    $icon = '';
    if (!empty($cm->icon)) {
        // each url has an icon in 2.0
        $icon = '<img src="'.$OUTPUT->pix_url($cm->icon).'" class="activityicon" alt="'.get_string('modulename', $cm->modname).'" /> ';
    }

    $class = $url->visible ? '' : 'class="dimmed"'; // hidden modules are dimmed
    $table->data[] = array (
        $printsection,
        "<a $class $extra href=\"view.php?id=$cm->id\">".$icon.format_string($url->name)."</a>",
        format_module_intro('url', $url, $cm->id));
}

echo html_writer::table($table);

echo $OUTPUT->footer();
